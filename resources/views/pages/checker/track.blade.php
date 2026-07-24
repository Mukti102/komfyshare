@extends('layouts.guest')
@section('title', 'Lacak Pesanan — KomfyChecker')
@section('content')

<style>
.track-bg { background: linear-gradient(135deg, #161616 0%, #1e1e1e 60%, #0d0d0d 100%); }
.track-input {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.12);
    color: white;
    transition: all 0.3s ease;
}
.track-input::placeholder { color: rgba(255,255,255,0.25); }
.track-input:focus {
    outline: none;
    border-color: rgba(255,60,95,0.6);
    background: rgba(255,60,95,0.05);
    box-shadow: 0 0 0 4px rgba(255,60,95,0.12);
}
.track-btn {
    background: linear-gradient(135deg, #FF3C5F, #ff6b85);
    box-shadow: 0 4px 20px rgba(255,60,95,0.4);
    transition: all 0.3s ease;
}
.track-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(255,60,95,0.6);
}
.floating { animation: floating 6s ease-in-out infinite; }
@keyframes floating {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
}
</style>

<div class="app_checker_form track-bg min-h-screen flex items-center justify-center px-4 py-16 relative overflow-hidden">

    <div class="absolute top-1/4 left-1/4 w-72 h-72 rounded-full filter blur-3xl opacity-8 floating" style="background:#FF3C5F"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 rounded-full filter blur-3xl opacity-5 floating" style="background:#2b2c2f; animation-delay:3s"></div>

    <div class="relative z-10 w-full max-w-lg">

        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6" style="background:rgba(255,60,95,0.12); border:1px solid rgba(255,60,95,0.25)">
                <svg class="w-8 h-8" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h1 class="text-4xl font-extrabold text-white mb-3">Lacak Pesanan</h1>
            <p class="text-gray-400">Masukkan nomor invoice untuk melihat status terkini pengecekan Anda.</p>
        </div>

        <div class="rounded-3xl p-8" style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); backdrop-filter:blur(20px)">
            <form onsubmit="event.preventDefault(); const v = document.getElementById('invoice_input').value.trim(); if(v) window.location.href = '{{ url('checker/track') }}/' + v;">
                <div class="mb-5">
                    <label for="invoice_input" class="block text-sm font-medium text-gray-300 mb-2">Nomor Invoice</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <input type="text" id="invoice_input" class="track-input w-full pl-12 pr-4 py-4 rounded-2xl text-lg font-mono uppercase tracking-widest" placeholder="CHK-20240101-XXXXX" required>
                    </div>
                </div>
                <button type="submit" class="track-btn w-full text-white font-bold rounded-2xl text-base px-5 py-4 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Lacak Sekarang
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/5 text-center">
                <p class="text-gray-500 text-sm">Lupa nomor invoice? <span style="color:#FF3C5F">Hubungi Admin via WhatsApp</span> untuk bantuan.</p>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('checker.landing') }}" class="text-white/30 hover:text-white/60 text-sm transition-colors">← Kembali ke Beranda</a>
        </div>

    </div>
</div>
@endsection
