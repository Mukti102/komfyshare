<?php

namespace App\Livewire;

use App\Jobs\SendWhatsapp;
use App\Models\Costumer;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentMetods;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
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
    public $paymentMethodId = null;
    public $shareModal = false;
    public $coupon;
    public $discountPercentase = 0;
    public $discountRupiah = 0;
    public $codes = [];
    public $countryCode;

    // Di BoxPaket.php
    public $testMessage = 'Initial';

    public function testClick()
    {
        $this->testMessage = 'Button clicked at ' . now();
    }


    public function setShareModal()
    {
        $this->shareModal = !$this->shareModal;
    }

    public function mount($prices)
    {
        $this->prices = $prices;
        $this->paymentMethods = PaymentMetods::all();
        $this->paymentMethodId = $this->paymentMethods->first()->id;
        // ✅ Panggil RestCountries API dari server
        $response = Http::get('https://restcountries.com/v3.1/region/asia', [
            'fields' => 'name,idd,cca2',
        ]);

        if ($response->ok()) {
            $this->codes = collect($response->json())
                ->filter(fn($c) => isset($c['idd']['root'])) // ambil hanya yg ada kode telp
                ->map(fn($c) => [
                    'code' => $c['idd']['root'] . ($c['idd']['suffixes'][0] ?? ''),
                    'label' => $c['cca2'] . ' ',
                ])
                ->values()
                ->all();
            $this->countryCode = '+62';
        }
    }

    public function setPaymentMethodId($paymentMethodId)
    {
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


        $this->cart = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => ltrim($this->countryCode, '+') . ltrim($this->phone, '0'),
            'product_id' => $this->order->product->id,
            'product_price_id' => $this->order->id,
            'quantity' => $this->slot,
            'amount' => $this->totalPrice($this->order, $this->order->product->discount),
            'invoice'  => $this->invoice ?? 'INV-' . strtoupper(uniqid()),
            'start_date' => now(),
            'status' => 'pending',
            'payment_proof' => null,
        ];



        // setelah sukses, trigger event JS
        $this->dispatch('show-payment-modal');
    }


    public function checkCoupon()
    {
        $coupon = Coupon::where('code', $this->coupon)->first();

        if (!$coupon) {
            session()->flash('error', 'Kupon tidak ditemukan');
            return;
        }

        if (!$coupon->status) {
            session()->flash('error', 'Kupon sudah tidak aktif');
            return;
        }

        if ($coupon->sisa_stock <= 0) {
            session()->flash('error', 'Penggunaan kupon sudah melebihi batas');
            return;
        }

        if (Carbon::parse($coupon->expired_date)->isPast()) {
            session()->flash('error', 'Kupon sudah kadaluarsa');
            return;
        }

        // Potongan harga
        $this->discountPercentase = (float) $coupon->percentase_discount;

        // Decrement stock hanya jika kupon valid
        $coupon->decrement('sisa_stock');

        session()->flash('success', 'Kupon berhasil digunakan');
    }


    public function selectPrice($priceId)
    {
        $this->selectedPriceId = $priceId;
    }


    public function normalPrice($price)
    {
        if (is_object($price) && isset($price->price)) {

            return $price->price; // kalau object & punya properti price
        } else {
            return $price;
        }
    }

    // Hitung harga setelah diskon
    public function finalPrice($price, $discount = null)
    {
        $discount = $discount ??  $price->product->discount ?? 0;
        return $this->normalPrice($price) - ($this->normalPrice($price) * $discount / 100);
    }

    // Hitung total harga * slot
    public function totalPrice($price, $discount = 0)
    {
        $resultDiscountPercentase = (float) $discount +  (float) $this->discountPercentase;
        return $this->finalPrice($price, $resultDiscountPercentase) * ($this->slot ?? 1);
    }



    public function confirmation()
    {
        try {

            if (!$this->cart) {
                $this->addError('cart', 'Data order tidak ditemukan. Silakan ulangi checkout.');
                return;
            }


            // update cart dengan path bukti pembayaran

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
                'start_date'        => 0,
                'payment_metod_id'  => $this->paymentMethodId,
                'status'            => 'pending',
            ];

            Log::info('oreder', ['message' => $pesanan]);
            // simpan ke database
            $order = Order::create($pesanan);


            // setelah proses create/update data
            session()->flash('success', 'Data berhasil dikirim.');

            // redirect
            return redirect()->route('payment.order', $order->invoice);
        } catch (Exception $e) {
            Log::error('Order confirmation failed', ['error' => $e->getMessage()]);

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
        //  $this->dispatch('show-payment-modal');
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
