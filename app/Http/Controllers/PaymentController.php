<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsapp;
use App\Models\Order;
use App\Models\User;
use App\Services\TokopayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $tokopay;

    public function __construct(TokopayService $tokopay)
    {
        $this->tokopay = $tokopay;
    }

    public function index($invoice)
    {
        $order = Order::with('paymentMethod', 'product')->where('invoice', $invoice)->first();
        $paymentMethod = $order->paymentMethod;
        $data = $this->tokopay->createOrder($paymentMethod->code, $order->invoice, $order->amount);
        if (!isset($data['data']) || $data['status'] == false) {
            return redirect()->route('product.show', $order->product->id)->with('error','Gagal Memproses Order');
        }

        return view('pages.payment.index', compact('data', 'order'));
    }

    public function webhook(Request $request)
    {
        Log::info('Tokopay Webhook:', ['data' => $request->all()]);

        $reffId    = $request['reff_id'];
        $reference = $request['reference'];
        $status    = $request['status'];
        $signature = $request['signature'];
        $data      = $request['data'];




        // Validasi signature
        $expected = md5(config('tokopay.merchant_id') . ':' . config('tokopay.api_key') . ':' . $reffId);
        if ($signature !== $expected) {
            Log::warning("Invalid signature for invoice: {$reffId}");
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // --- HANDLE TOKEN ORDER WEBHOOK ---
        if (\Illuminate\Support\Str::startsWith($reffId, 'TKN-')) {
            $tokenOrder = \App\Models\CheckerTokenOrder::with('package')->where('invoice_number', $reffId)->first();
            
            if (!$tokenOrder) {
                Log::error("TokenOrder not found for invoice: {$reffId}");
                return response()->json(['error' => 'TokenOrder not found'], 404);
            }

            if ($status === 'Success' || $status === 'Completed') {
                if ($tokenOrder->status === 'waiting_payment') {
                    $tokenOrder->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);

                    // Tambah/Buat dompet token
                    $wallet = \App\Models\CheckerTokenWallet::firstOrCreate(
                        [
                            'customer_id' => $tokenOrder->customer_id,
                            'checker_package_id' => $tokenOrder->checker_package_id,
                        ],
                        [
                            'total_token' => 0,
                            'expired_at' => now()->addDays($tokenOrder->package->expired_day)
                        ]
                    );

                    $wallet->increment('total_token', $tokenOrder->package->total_token);
                    
                    // Update expired date agar direset lagi sesuai masa aktif baru dari pembelian ini
                    $wallet->update([
                        'expired_at' => now()->addDays($tokenOrder->package->expired_day)
                    ]);

                    // Catat Histori
                    \App\Models\CheckerTokenHistory::create([
                        'checker_token_wallet_id' => $wallet->id,
                        'checker_package_id' => $tokenOrder->checker_package_id,
                        'type' => 'purchase',
                        'token' => $tokenOrder->package->total_token,
                        'balance_before' => $wallet->total_token - $tokenOrder->package->total_token,
                        'balance_after' => $wallet->total_token,
                        'description' => 'Top-Up Pembelian ' . $tokenOrder->package->name,
                    ]);
                }
            } elseif ($status === 'Failed') {
                if ($tokenOrder->status === 'waiting_payment') {
                    $tokenOrder->update(['status' => 'cancelled']);
                }
            }

            return response()->json(['message' => 'Token Order updated']);
        }

        // --- HANDLE CHECKER ORDER WEBHOOK ---
        if (\Illuminate\Support\Str::startsWith($reffId, 'CHK-')) {
            $checkerOrder = \App\Models\CheckerOrder::with('customer', 'service')->where('invoice_number', $reffId)->first();
            
            if (!$checkerOrder) {
                Log::error("CheckerOrder not found for invoice: {$reffId}");
                return response()->json(['error' => 'CheckerOrder not found'], 404);
            }

            switch ($status) {
                case 'Success':
                case 'Completed':
                    if ($checkerOrder->status === 'waiting_payment') {
                        $checkerOrder->update(['status' => 'pending']);
                        
                        $checkerOrder->payments()->update([
                            'payment_status' => 'success',
                            'transaction_code' => $reference,
                            'paid_at' => now(),
                        ]);

                        \App\Models\CheckerPaymentLog::create([
                            'checker_order_id' => $checkerOrder->id,
                            'status' => 'success',
                            'gateway_response' => $request->all(),
                        ]);

                        \App\Models\CheckerStatusLog::create([
                            'checker_order_id' => $checkerOrder->id,
                            'status' => 'pending',
                            'notes' => 'Pembayaran berhasil. Pesanan menunggu konfirmasi Admin.',
                            'created_by' => 'system'
                        ]);
                        
                        // Kirim notifikasi WA (opsional/nanti bisa disesuaikan)
                        $this->sendCheckerWhatsapp($checkerOrder->customer, $checkerOrder);
                    }
                    break;

                case 'Failed':
                    if ($checkerOrder->status === 'waiting_payment') {
                        $checkerOrder->update(['status' => 'cancelled']);
                        
                        $checkerOrder->payments()->update([
                            'payment_status' => 'failed',
                            'response' => json_encode($request->all()),
                        ]);

                        \App\Models\CheckerStatusLog::create([
                            'checker_order_id' => $checkerOrder->id,
                            'status' => 'cancelled',
                            'notes' => 'Pembayaran dibatalkan atau kedaluwarsa.',
                            'created_by' => 'system'
                        ]);
                    }
                    break;
            }

            return response()->json(['success' => true]);
        }
        // --- END HANDLE CHECKER ORDER WEBHOOK ---

        $order = Order::with(['costumer', 'product', 'paymentMethod', 'productPrice'])->where('invoice', $reffId)->first();

        if (!$order) {
            Log::error("Order not found for invoice: {$reffId}");
            return response()->json(['error' => 'Order not found'], 404);
        }


        switch ($status) {
            case 'Success':
                $duration  = (int) $order->productPrice->duration_day;
                $end_date  = now()->addDays($duration)->toDateString();


                $order->update([
                    'status'       => 'completed',
                    'reference'    => $reference,
                    'payment_data' => json_encode($request->all()),
                    'start_date'   => now()->toDateString(),
                    'end_date'     => $end_date,
                ]);


                $this->sendMessageWhatsapp($order->costumer, $order);
                break;
            case 'Completed':
                $duration  = (int) $order->productPrice->duration_day;
                $end_date  = now()->addDays($duration)->toDateString();


                $order->update([
                    'status'       => 'completed',
                    'reference'    => $reference,
                    'payment_data' => json_encode($request->all()),
                    'start_date'   => now()->toDateString(),
                    'end_date'     => $end_date,
                ]);

                $this->sendMessageWhatsapp($order->costumer, $order);
                break;

            case 'Failed':
                $order->update(['status' => 'canceled']);
                break;

            case 'Pending':
                $order->update(['status' => 'pending']);
                break;
        }

        return response()->json(['success' => true]);
    }



    public function sendMessageWhatsapp($customer, $order)
    {
        $admins = User::all();
        $customerMessage = "Hi, {NAMA}

Pesanan \"{PRODUK}\" sebanyak {SLOT} slot telah kami konfirmasi dan akan segera diproses.
Admin KomfyShare akan menghubungi Anda dalam waktu dekat.

🧾 Invoice: {INVOICE}
📅 Masa Berlaku: {TANGGAL_MULAI} – {TANGGAL_AKHIR}

Jika ada pertanyaan atau kendala, silakan hubungi kami.

Salam,
KomfyShare";


        $adminMessage = "📢 Notifikasi Transaksi Masuk

🧾 Invoice : {INVOICE}
📦 Produk  : {PRODUK}
🎟️ Slot    : {SLOT}
💰 Nominal : {NOMINAL}
👤 Pembeli : {NAMA} ({EMAIL})
📞 WA      : {PHONE}
💳 Metode  : {METODE}
🔢 Kode    : {REFID}
🏷️ Referral: {REFERRAL}
📅 Waktu   : {DATETIME} WIB";


        // Replace placeholder dengan data asli
        $customerMessage = str_replace(
            ['{NAMA}', '{PRODUK}', '{SLOT}', '{INVOICE}', '{TANGGAL_MULAI}', '{TANGGAL_AKHIR}'],
            [
                $customer->name,
                $order->product->title,
                $order->quantity,
                $order->invoice,
                $order->start_date->format('d/m/Y'),
                $order->end_date->format('d/m/Y'),
            ],
            $customerMessage
        );

        // admin
        $adminMessage = str_replace(
            [
                '{INVOICE}',
                '{PRODUK}',
                '{SLOT}',
                '{NOMINAL}',
                '{NAMA}',
                '{EMAIL}',
                '{PHONE}',
                '{METODE}',
                '{REFID}',
                '{REFERRAL}',
                '{DATETIME}',
            ],
            [
                $order->invoice,
                $order->product->title,
                $order->quantity,
                number_format($order->amount, 0, ',', '.'),
                $order->costumer->name,
                $order->costumer->email,
                $order->costumer->phone,
                $order->paymentMethod->name,
                $order->invoice,
                $order->referral ?? '-',
                Carbon::now()->format('d/m/Y H:i:s'),
            ],
            $adminMessage
        );

        // Kirim WhatsApp ke costumer
        SendWhatsapp::dispatch($customer->phone, $customerMessage);
        // admins
        foreach ($admins as $admin) {
            SendWhatsapp::dispatch($admin->phone, $adminMessage);
        }
    }


    public function createSlot()
    {
        // $product = $record->product; // relasi order -> product
        // $groups = $product->groups;  // relasi product -> groups (Collection)

        // if ($groups->isNotEmpty()) {
        //     // pilih group pertama yang masih punya slot kosong
        //     $group = $groups->firstWhere(fn($g) => $g->slots()->count() < $g->max_slot);

        //     if ($group) {
        //         $group->slots()->create([
        //             'order_id'    => $record->id,
        //             'group_id'    => $group->id,
        //             'costumer_id' => $record->costumer_id,
        //         ]);
        //     }
        // }
    }

    public function sendCheckerWhatsapp($customer, $order)
    {
        $admins = User::all();
        $customerMessage = "Hi, {NAMA}

Pembayaran untuk pesanan pengecekan dokumen Anda telah kami terima dan saat ini sedang dalam antrean proses (Pending).
Admin KomfyChecker akan segera meninjau pesanan Anda.

🧾 Invoice: {INVOICE}
📄 Layanan: {LAYANAN}
💰 Total: Rp {TOTAL}

Anda dapat memantau status pesanan kapan saja melalui tautan berikut:
{LINK_TRACKING}

Jika ada pertanyaan, silakan hubungi kami.

Salam,
KomfyChecker";

        $adminMessage = "📢 [KomfyChecker] Pesanan Baru Dibayar!

🧾 Invoice: {INVOICE}
📄 Layanan: {LAYANAN}
👤 Pelanggan: {NAMA}
📞 WA: {PHONE}
💰 Nominal: Rp {TOTAL}
📅 Waktu: {DATETIME} WIB

Mohon segera cek dan proses dokumen di dashboard.";

        // Replace for customer
        $customerMessage = str_replace(
            ['{NAMA}', '{INVOICE}', '{LAYANAN}', '{TOTAL}', '{LINK_TRACKING}'],
            [
                $customer->name ?? 'Pelanggan',
                $order->invoice_number,
                $order->service->name ?? 'Layanan Pengecekan',
                number_format($order->total_price, 0, ',', '.'),
                route('checker.track.detail', $order->invoice_number)
            ],
            $customerMessage
        );

        // Replace for admin
        $adminMessage = str_replace(
            ['{INVOICE}', '{LAYANAN}', '{NAMA}', '{PHONE}', '{TOTAL}', '{DATETIME}'],
            [
                $order->invoice_number,
                $order->service->name ?? 'Layanan',
                $customer->name ?? 'Pelanggan',
                $customer->phone ?? '-',
                number_format($order->total_price, 0, ',', '.'),
                Carbon::now()->format('d/m/Y H:i:s'),
            ],
            $adminMessage
        );

        if ($customer && $customer->phone) {
            SendWhatsapp::dispatch($customer->phone, $customerMessage);
        }
        
        foreach ($admins as $admin) {
            if ($admin->phone) {
                SendWhatsapp::dispatch($admin->phone, $adminMessage);
            }
        }
    }
}
