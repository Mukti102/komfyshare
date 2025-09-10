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
        $order = Order::with('paymentMethod')->where('invoice', $invoice)->first();
        $paymentMethod = $order->paymentMethod;
        $data = $this->tokopay->createOrder($paymentMethod->code, $order->invoice, $order->amount);
        // $data = [
        //     "data" => [
        //         "nomor_va" => "8578330274425713",
        //         "pay_url" => "https://pay.tokopay.id/?token=xxx",
        //         "panduan_pembayaran" => "8578330274425713",
        //         "total_bayar" => "20000",
        //         "total_diterima" => "19000",
        //         "trx_id" => "T230404OTMP000001",
        //     ],
        //     "status" => "Success"
        // ];
        return view('pages.payment.index', compact('data', 'order'));
    }

    public function webhook(Request $request)
    {
        Log::info('Tokopay Webhook:', ['data' => $request->all()]);

        $reffId    = $request->input('reff_id');
        $reference = $request->input('reference');
        $status    = $request->input('status');
        $signature = $request->input('signature');
        $data      = $request->input('data');

        // Validasi signature
        $expected = md5(config('tokopay.merchant_id') . ':' . config('tokopay.api_key') . ':' . $reffId);
        if ($signature !== $expected) {
            Log::warning("Invalid signature for invoice: {$reffId}");
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $order = Order::with(['customer', 'product', 'paymentMethod'])->where('invoice', $reffId)->first();

        if (!$order) {
            Log::error("Order not found for invoice: {$reffId}");
            return response()->json(['error' => 'Order not found'], 404);
        }

        switch ($status) {
            case 'Success':
            case 'Complete':
                $duration  = $order->productPrice->duration_day;
                $end_date  = now()->addDays($duration)->toDateString();

                $order->update([
                    'status'       => 'completed',
                    'reference'    => $reference,
                    'payment_data' => json_encode($data),
                    'start_date'   => now()->toDateString(),
                    'end_date'     => $end_date,
                ]);

                $this->sendMessageWhatsapp($order->customer, $order);
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
                $order->slot,
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
                $order->customer->name,
                $order->customer->email,
                $order->customer->phone,
                $order->paymentMethod->name,
                $order->reference,
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
}
