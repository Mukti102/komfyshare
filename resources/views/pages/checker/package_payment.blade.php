@extends('layouts.guest')
@section('title', 'Detail Pembayaran — ' . $order->invoice_number)
@section('content')

<style>
.payment-bg { background: linear-gradient(135deg, #161616 0%, #1e1e1e 60%, #0d0d0d 100%); min-height: 100vh; }
.card-glass {
    background: #ffffff;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    border-radius: 1.5rem;
}
.header-glass {
    background: linear-gradient(135deg, #161616, #2b2c2f);
}
.primary-text { color: #FF3C5F; }
.primary-bg { background-color: #FF3C5F; }
.primary-gradient { background: linear-gradient(135deg, #FF3C5F, #ff6b85); }
.primary-shadow { box-shadow: 0 4px 20px rgba(255,60,95,0.4); }
</style>

<div class="app_checker_form payment-bg py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-white mb-2">Selesaikan Pembayaran</h1>
            <p class="text-white/50">Invoice: <span class="font-mono text-white/80">{{ $order->invoice_number }}</span></p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            
            {{-- Main Payment Area --}}
            <div class="lg:col-span-2">
                <div class="card-glass overflow-hidden">
                    
                    {{-- Method Header --}}
                    <div class="header-glass px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-white text-xl font-bold">
                                    {{ $order->paymentMethod->name ?? 'Pembayaran' }}
                                </h2>
                                <p class="text-white/60 text-sm mt-1">
                                    @if (isset($data['data']['nomor_va']))
                                        {{ isset($data['data']['checkout_url']) ? 'Retail Payment' : 'Virtual Account' }}
                                    @elseif(isset($data['data']['qr_link']))
                                        QRIS Payment
                                    @elseif(isset($data['data']['checkout_url']))
                                        @if (strpos($data['data']['checkout_url'], 'wallet') !== false)
                                            E-Wallet Payment
                                        @else
                                            Online Payment
                                        @endif
                                    @else
                                        Digital Payment
                                    @endif
                                </p>
                            </div>
                            <div class="px-4 py-1.5 rounded-full" style="background:rgba(255,60,95,0.2); border:1px solid rgba(255,60,95,0.4)">
                                <span class="text-white text-sm font-bold tracking-wider">{{ strtoupper($order->paymentMethod->code ?? 'PAY') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Content based on Type --}}
                    @if (isset($data['data']['nomor_va']))
                        <div class="p-6 sm:p-8 border-b border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ isset($data['data']['checkout_url']) ? 'Kode Pembayaran' : 'Nomor Virtual Account' }}
                                </h3>
                                <button onclick="copyToClipboard('{{ $data['data']['nomor_va'] }}')" class="primary-text hover:opacity-80 text-sm font-semibold flex items-center gap-1.5 transition-opacity">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Salin
                                </button>
                            </div>
                            <div class="rounded-2xl p-6 text-center border-2 border-dashed" style="background:rgba(255,60,95,0.03); border-color:rgba(255,60,95,0.2)">
                                <p class="text-3xl font-mono font-black text-gray-900 tracking-widest">
                                    {{ $data['data']['nomor_va'] }}
                                </p>
                            </div>
                        </div>
                    @elseif(isset($data['data']['qr_link']))
                        <div class="p-6 sm:p-8 border-b border-gray-100 text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Scan QR Code untuk Membayar</h3>
                            <div class="inline-block p-4 rounded-2xl bg-white shadow-sm border border-gray-100 mb-6">
                                <img src="{{ $data['data']['qr_link'] }}" alt="QR Code" class="w-56 h-56 object-contain">
                            </div>
                            <p class="text-sm font-medium text-gray-500 mb-3">Gunakan aplikasi yang mendukung QRIS</p>
                            <div class="flex justify-center gap-4 text-xs text-gray-400 font-semibold">
                                <span>GoPay</span> • <span>OVO</span> • <span>DANA</span> • <span>ShopeePay</span>
                            </div>
                        </div>
                    @elseif(isset($data['data']['checkout_url']))
                        <div class="p-6 sm:p-8 border-b border-gray-100 text-center">
                            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5" style="background:rgba(255,60,95,0.1)">
                                <svg class="w-10 h-10 primary-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Pembayaran Online</h3>
                            <p class="text-gray-500 mb-8">Selesaikan pembayaran Anda secara aman melalui payment gateway.</p>
                            
                            <a href="{{ $data['data']['checkout_url'] }}" target="_blank" class="primary-gradient primary-shadow w-full inline-block text-white font-bold py-4 px-6 rounded-2xl transition-transform hover:-translate-y-1 text-lg">
                                Lanjutkan Pembayaran
                            </a>
                        </div>
                    @endif

                    {{-- Amount Details --}}
                    <div class="p-6 sm:p-8 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-5">Detail Tagihan</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                                <span class="text-gray-500 font-medium">Total Harga Layanan</span>
                                <span class="text-lg font-semibold text-gray-900">Rp {{ number_format($data['data']['total_bayar'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Total yang harus dibayar</span>
                                <span class="text-xl font-black primary-text">Rp {{ number_format($data['data']['total_diterima'], 0, ',', '.') }}</span>
                            </div>
                            @php $fee = $data['data']['total_bayar'] - $data['data']['total_diterima']; @endphp
                            @if ($fee > 0)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-400">Biaya Admin</span>
                                    <span class="text-gray-400">Rp {{ number_format($fee, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center text-sm pt-4 border-t border-gray-50">
                                <span class="text-gray-400">ID Transaksi</span>
                                <span class="text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">{{ $data['data']['trx_id'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Instructions --}}
                    @if (!empty($data['data']['panduan_pembayaran']))
                        <div class="p-6 sm:p-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Panduan Pembayaran
                            </h3>
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {!! $data['data']['panduan_pembayaran'] !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Quick Actions --}}
                <div class="card-glass p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                    @if (isset($data['data']['checkout_url']))
                        <a href="{{ $data['data']['checkout_url'] }}" target="_blank" class="primary-gradient primary-shadow block w-full text-white font-bold py-3.5 px-4 rounded-xl text-center mb-3 hover:opacity-90 transition-opacity">
                            Buka Halaman Pembayaran
                        </a>
                    @endif
                    <a href="{{ $data['data']['pay_url'] ?? '#' }}" target="_blank" class="block w-full bg-gray-900 text-white hover:bg-black font-bold py-3.5 px-4 rounded-xl transition-colors text-center shadow-md">
                        Bayar via Tokopay
                    </a>
                </div>

                {{-- Status --}}
                @livewire('check-status', ['data' => $data, 'order' => $order])

                {{-- Order Summary Sidebar --}}
                <div class="card-glass p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pesanan</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Layanan</span>
                            <span class="font-bold text-gray-900 text-right">{{ $order->package->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Dibuat</span>
                            <span class="font-bold text-gray-900">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <span class="text-gray-500 font-medium">Status</span>
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold capitalize">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Action Back to Track --}}
                <a href="{{ route('checker.landing') }}" class="block w-full card-glass p-4 text-center font-bold text-sm transition-colors hover:bg-gray-50" style="color:#FF3C5F; border:1px solid rgba(255,60,95,0.2)">
                    Kembali ke Beranda &rarr;
                </a>

            </div>
        </div>

        {{-- Notice --}}
        <div class="mt-8 rounded-2xl p-5 border border-dashed text-center max-w-3xl mx-auto" style="background:rgba(255,255,255,0.03); border-color:rgba(255,255,255,0.2)">
            <p class="text-white/60 text-sm">
                Harap selesaikan pembayaran sesuai nominal yang tertera. Pesanan Anda akan otomatis diproses setelah pembayaran berhasil diverifikasi oleh sistem.
            </p>
        </div>
        
        <div class="text-center mt-6">
            <a href="{{ route('checker.landing') }}" class="text-white/30 hover:text-white/60 text-sm font-medium transition-colors">← Kembali ke Beranda</a>
        </div>

    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            Toastify({
                text: "Berhasil disalin!",
                duration: 3000,
                gravity: "top",
                position: "center",
                style: {
                    background: "#FF3C5F",
                    borderRadius: "10px",
                    fontWeight: "bold"
                }
            }).showToast();
        });
    }
</script>

@endsection
