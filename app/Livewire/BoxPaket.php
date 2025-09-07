<?php

namespace App\Livewire;

use App\Jobs\SendWhatsapp;
use App\Models\Costumer;
use App\Models\Order;
use App\Models\PaymentMetods;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class BoxPaket extends Component
{

    use WithFileUploads;

    public $prices;
    public $paymentMethods;
    public $selectedPriceId;
    public $price;
    public $slot = 1;
    public $order = null;
    public $cart = null;
    public $name;
    public $email;
    public $phone;
    public $invoice;
    public $payment_proof;
    public $paymentMethodId=null;

    public function mount($prices)
    {
        $this->prices = $prices;
        $this->paymentMethods = PaymentMetods::all();
    }

    public function setPaymentMethodId($paymentMethodId){
        $this->paymentMethodId = $paymentMethodId;
    }

    public function checkout()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        if (!$this->order) {
            $this->addError('order', 'Silakan pilih paket terlebih dahulu.');
            return;
        }

        $total = $this->order->price - ( $this->order->price * $this->order->product->discount) / 100;
        $amount = $total * (int) $this->slot;
        $this->cart = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'product_id' => $this->order->product->id,
            'product_price_id' => $this->order->id,
            'quantity' => $this->slot,
            'amount' => $amount,
            'invoice'  => $this->invoice ?? 'INV-' . strtoupper(uniqid()),
            'start_date' => now(),
            'status' => 'pending',
            'payment_proof' => null,
        ];

        // setelah sukses, trigger event JS
        $this->dispatch('show-payment-modal');
    }

    public function selectPrice($priceId)
    {
        $this->selectedPriceId = $priceId;
    }

    public function confirmation()
    {

        $this->validate([
            'payment_proof' => 'required|image|max:2048', // max 2MB
        ]);

        try {

            Log::info('payment', ['message' => $this->payment_proof]);
            if (!$this->cart) {
                $this->addError('cart', 'Data order tidak ditemukan. Silakan ulangi checkout.');
                return;
            }

            // simpan file bukti pembayaran
            $filename = time() . '_' . Str::of($this->payment_proof->getClientOriginalName())->ascii()->replace(' ', '_');
            $path = $this->payment_proof->storeAs('payment_proofs', $filename, 'public');


            // update cart dengan path bukti pembayaran
            $this->cart['payment_proof'] = $path;

            $costumer = Costumer::updateOrCreate(
                ['email' => $this->cart['email']],
                [
                    'name'  => $this->cart['name'],
                    'phone' => $this->cart['phone'],
                ]
            );


            $pesanan = [
                'invoice'           => $this->cart['invoice'],
                'costumer_id'       => $costumer->id,
                'product_id'        => $this->cart['product_id'],
                'product_price_id'  => $this->cart['product_price_id'],
                'quantity'          => $this->cart['quantity'],
                'amount'            => $this->cart['amount'],
                'start_date'        => $this->cart['start_date'],
                'payment_metod_id'  => $this->paymentMethodId,
                'status'            => 'pending',
                'payment_proof'     => $path,
            ];

            Log::info('oreder', ['message' => $pesanan]);
            // simpan ke database
            $order = Order::create($pesanan);

            // send whatsapp
            SendWhatsapp::dispatch($costumer->phone,"Berhasil Mengirim Pesanan dengan invoice : " . $order->invoice . 'silhkan tunggu pesanan di konfirmasi');


            // setelah proses create/update data
            session()->flash('success', 'Data berhasil dikirim.');


            $this->reset([
                'payment_proof',
                'name',
                'email',
                'phone',
                'invoice',
                'order',
                'cart',
                'slot',
                'selectedPriceId',
            ]);

            $this->slot = 1; // default slot 1
            $this->order = null; // pastikan order kosong

            // reset modal + tampilkan flash message
            $this->reset(['payment_proof']);



            // bisa juga close modal via event ke Alpine
            $this->dispatch('close-payment-modal');
        } catch (Exception $e) {
            Log::info('gagak', ['message' => $e->getMessage()]);

            session()->flash('error', 'Data Gagal dikirim.');


            $this->dispatch('close-payment-modal');
        }
    }

    public function back()
    {
        $this->order = null;
    }

    public function makeOrder()
    {   
        $this->invoice = 'INV-' . strtoupper(uniqid());
        $this->order = collect($this->prices)->firstWhere('id', $this->selectedPriceId);
    }

    public function updatedSlot($value)
    {
        if ($value < 1) {
            $this->slot = 1;
        } elseif ($value > 100) {
            $this->slot = 100;
        }
    }

    public function render()
    {
        return view('livewire.box-paket');
    }
}
