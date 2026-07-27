<?php

namespace App\Livewire\Checker;
use App\Models\PaymentMetods;


use Livewire\Component;

class PackageCheckout extends Component
{
    public $package;
    public $name;
    public $phone;
    public $whatsapp_check_status = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'phone.required' => 'Nomor WhatsApp wajib diisi.',
    ];

    public function updatedPhone($value)
    {
        if (strlen($value) >= 9) {
            $this->checkWhatsApp();
        } else {
            $this->whatsapp_check_status = null;
        }
    }

    public function checkWhatsApp()
    {
        $this->validate(['phone' => 'required|string']);
        $customer = \App\Models\Costumer::where('phone', $this->phone)->first();
        
        if ($customer) {
            $this->name = $customer->name;
            $this->whatsapp_check_status = 'found';
        } else {
            $this->whatsapp_check_status = 'not_found';
            $this->name = ''; // Reset name if not found
        }
    }

    public function submit()
    {
        $this->validate();

        // Cari atau buat customer
        $customer = \App\Models\Costumer::firstOrCreate(
            ['phone' => $this->phone],
            ['name' => $this->name]
        );

        // Update nama jika sudah ada tapi namanya beda
        if ($customer->name !== $this->name) {
            $customer->update(['name' => $this->name]);
        }

        // Cari payment method QRIS
        

            $qrisMethod = PaymentMetods::where('name', 'QRIS')->first();

        if (!$qrisMethod) {
            session()->flash('error', 'Metode pembayaran QRIS tidak tersedia saat ini.');
            return;
        }

        // Buat Invoice
        $invoice = 'TKN-' . date('YmdHis') . strtoupper(uniqid());

        $order = \App\Models\CheckerTokenOrder::create([
            'invoice_number' => $invoice,
            'customer_id' => $customer->id,
            'checker_package_id' => $this->package->id,
            'payment_method_id' => $qrisMethod->id,
            'total_price' => $this->package->price,
            'status' => 'waiting_payment',
        ]);

        return redirect()->route('checker.package.payment', $order->invoice_number);
    }

    public function render()
    {
        return view('livewire.checker.package-checkout');
    }
}
