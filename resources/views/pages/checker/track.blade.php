@extends('layouts.guest')
@section('title', 'Lacak Pesanan — KomfyChecker')
@section('content')

<style>
.kc-track-bg {
    background-color: #161616;
    background-image: 
        radial-gradient(at 50% 0%, rgba(43, 44, 47, 0.6) 0px, transparent 70%),
        radial-gradient(at 100% 100%, rgba(255, 60, 95, 0.05) 0px, transparent 50%);
}
.kc-grid-pattern {
    background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                      linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 32px 32px;
}
.track-input {
    background: rgba(22, 22, 22, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: white;
    transition: all 0.2s ease;
}
.track-input::placeholder { color: rgba(255, 255, 255, 0.35); }
.track-input:focus {
    outline: none;
    border-color: #FF3C5F;
    box-shadow: 0 0 0 3px rgba(255, 60, 95, 0.15);
}
.track-btn {
    background-color: #FF3C5F;
    transition: all 0.2s ease;
}
.track-btn:hover {
    background-color: #e02e4d;
    box-shadow: 0 6px 20px rgba(255, 60, 95, 0.3);
}
</style>

<div class="kc-track-bg bg-dark min-h-screen pt-20 pb-16 px-4 sm:px-6 lg:px-8 text-gray-100 relative overflow-hidden font-sans flex items-center justify-center">
    {{-- Subtle Grid Pattern Overlay --}}
    <div class="absolute inset-0 kc-grid-pattern pointer-events-none opacity-60"></div>

    <div class="relative z-10 w-full max-w-xl my-8">

        @livewire('checker.track-search')

        <div class="text-center mt-8">
            <a href="{{ route('checker.landing') }}" class="text-gray-400 hover:text-white text-sm transition-colors font-medium">← Kembali ke Beranda</a>
        </div>

    </div>
</div>
@endsection
