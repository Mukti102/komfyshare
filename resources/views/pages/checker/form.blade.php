@extends('layouts.guest')
@section('title', 'Form Pengecekan — ' . $service->name)
@section('content')

<style>
.kc-form-bg {
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
</style>

<div class="kc-form-bg bg-dark min-h-screen pt-20 pb-16 px-4 sm:px-6 lg:px-8 text-gray-100 relative overflow-hidden font-sans">
    {{-- Subtle Grid Pattern Overlay --}}
    <div class="absolute inset-0 kc-grid-pattern pointer-events-none opacity-60"></div>

    <div class="relative z-10 max-w-3xl mx-auto">

        {{-- Top Navigation --}}
        <div class="mb-6">
            <a href="{{ route('checker.landing') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Katalog Layanan
            </a>
        </div>

        {{-- Header Service Info --}}
        <div class="mb-8 p-6 rounded-2xl bg-secondary/40 border border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-primary/10 border border-primary/20 text-primary text-xs font-bold uppercase tracking-wider mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Layanan Checker
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">{{ $service->name }}</h1>
                <p class="text-gray-400 text-sm mt-1 leading-relaxed max-w-xl">{{ $service->description }}</p>
            </div>
            @if($service->badge)
                <span class="px-3 py-1 rounded-full bg-primary/10 text-primary border border-primary/20 text-xs font-semibold shrink-0">
                    {{ $service->badge }}
                </span>
            @endif
        </div>

        {{-- Form Container Card --}}
        <div class="bg-secondary/50 border border-white/10 rounded-2xl overflow-hidden shadow-2xl backdrop-blur-sm">
            @livewire('checker.service-form', ['service' => $service])
        </div>

        {{-- Trust Badges --}}
        <div class="mt-8 flex items-center justify-center gap-6 flex-wrap text-gray-400 text-xs font-medium border-t border-white/5 pt-6">
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg> 100% No Repository</span>
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Privasi Terjaga</span>
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Pemrosesan Cepat</span>
        </div>

    </div>
</div>
@endsection
