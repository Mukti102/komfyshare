@extends('layouts.guest')
@section('title', 'Checkout — ' . $order->invoice_number)
@section('content')

<style>
.checkout-bg { background: linear-gradient(135deg, #161616 0%, #1e1e1e 60%, #0d0d0d 100%); }
.pay-btn {
    background: linear-gradient(135deg, #FF3C5F, #ff6b85);
    box-shadow: 0 4px 24px rgba(255,60,95,0.45);
    transition: all 0.3s ease;
}
.pay-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(255,60,95,0.65);
}
.success-ring {
    animation: success-pulse 2.5s ease-in-out infinite;
}
@keyframes success-pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(255,60,95,0.4); }
    50% { box-shadow: 0 0 0 16px rgba(255,60,95,0); }
}
</style>

<div class="app_checker_form checkout-bg min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        {{-- Success Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4 success-ring" style="background:#FF3C5F">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-white mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-white/40 text-sm">Selesaikan pembayaran untuk mulai diproses.</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-3xl overflow-hidden" style="box-shadow: 0 30px 60px rgba(0,0,0,0.35)">

            {{-- Invoice Header --}}
            <div class="p-6 sm:p-8" style="background: linear-gradient(135deg, #161616, #2b2c2f)">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/40 text-xs font-medium uppercase tracking-widest mb-1">Nomor Invoice</p>
                        <p class="text-white font-mono text-xl font-extrabold tracking-widest">{{ $order->invoice_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-white/40 text-xs font-medium uppercase tracking-widest mb-1">Status</p>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold" style="background:rgba(255,60,95,0.15); color:#FF3C5F; border:1px solid rgba(255,60,95,0.3)">
                            <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:#FF3C5F"></span>
                            Menunggu Pembayaran
                        </span>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="p-6 sm:p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Ringkasan Pesanan
                </h2>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Layanan</span>
                        <span class="font-semibold text-gray-900 text-sm">{{ $order->service->name }}</span>
                    </div>
                    @if($order->package)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Paket</span>
                        <span class="font-semibold text-gray-900 text-sm">{{ $order->package->name }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-500 text-sm">Estimasi Pengerjaan</span>
                        <span class="font-semibold text-gray-900 text-sm">~{{ $order->service->estimated_hours }} Jam</span>
                    </div>
                    <div class="flex justify-between items-center py-4 rounded-2xl px-4" style="background:rgba(255,60,95,0.06); border:1px solid rgba(255,60,95,0.12)">
                        <span class="text-gray-700 font-bold text-base">Total Pembayaran</span>
                        <span class="text-3xl font-black" style="color:#FF3C5F">
                            @if($order->total_price > 0)
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            @else
                                <span class="text-lg text-amber-500">Ditinjau Admin</span>
                            @endif
                        </span>
                    </div>
                </div>

                @if($order->total_price > 0)
                <a href="{{ route('checker.payment', $order->invoice_number) }}" class="pay-btn w-full text-white font-bold rounded-2xl text-lg px-5 py-4 flex items-center justify-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Bayar Sekarang
                </a>
                @else
                <div class="rounded-2xl p-4 mb-4 text-center" style="background:#fffbeb; border:1px solid #fde68a">
                    <p class="text-amber-700 font-medium text-sm">⏳ Harga sedang ditinjau oleh Admin. Anda akan dihubungi segera.</p>
                </div>
                @endif

                <a href="{{ route('checker.track.detail', $order->invoice_number) }}" class="w-full font-semibold text-sm py-3 flex items-center justify-center gap-1.5 transition-colors border rounded-2xl hover:bg-gray-50" style="color:#FF3C5F; border-color:rgba(255,60,95,0.25)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat Detail Status Pesanan
                </a>
            </div>

            <div class="bg-gray-50 px-6 sm:px-8 py-4 border-t border-gray-100">
                <p class="text-center text-xs text-gray-400">🔒 Pembayaran Anda terlindungi dan diproses dengan aman.</p>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('checker.landing') }}" class="text-white/30 hover:text-white/60 text-sm transition-colors">← Kembali ke Halaman Utama</a>
        </div>

    </div>
</div>
@endsection
