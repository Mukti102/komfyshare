<?php

namespace App\Livewire\Checker;

use Livewire\Component;

class TrackSearch extends Component
{
    public $phone = '';
    public $hasSearched = false;
    public $customer = null;
    public $wallets = [];
    public $orders = [];
    public $errorMsg = '';

    public function search()
    {
        $this->hasSearched = true;
        $this->errorMsg = '';
        $this->customer = null;
        $this->wallets = [];
        $this->orders = [];

        if (empty(trim($this->phone))) {
            $this->errorMsg = 'Silakan masukkan nomor WhatsApp Anda.';
            return;
        }

        // Cari kustomer
        $customer = \App\Models\Costumer::where('phone', $this->phone)->first();

        if (!$customer) {
            $this->errorMsg = 'Nomor WhatsApp tidak ditemukan. Pastikan Anda sudah pernah membuat pesanan.';
            return;
        }

        $this->customer = $customer;

        // Ambil Dompet Token aktif
        $this->wallets = \App\Models\CheckerTokenWallet::where('customer_id', $customer->id)
            ->where('total_token', '>', 0)
            ->where('expired_at', '>=', now())
            ->with('package')
            ->get();

        // Ambil Riwayat Order
        $this->orders = \App\Models\CheckerOrder::where('customer_id', $customer->id)
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.checker.track-search');
    }
}
