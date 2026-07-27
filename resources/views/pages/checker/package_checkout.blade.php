@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-[#0a0a0a] text-white pt-32 pb-20">
    <div class="container mx-auto px-4 md:px-6">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-8">
                <a href="{{ route('checker.landing') }}" class="inline-flex items-center text-sm text-gray-400 hover:text-[#FF3C5F] transition-colors mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Checkout Paket Token</h1>
                <p class="text-gray-400">Lengkapi data di bawah ini untuk memproses pembelian Paket Token Anda.</p>
            </div>

            <!-- Livewire Form Component -->
            @livewire('checker.package-checkout', ['package' => $package])
            
        </div>
    </div>
</div>
@endsection