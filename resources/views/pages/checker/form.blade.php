@extends('layouts.guest')
@section('title', 'Form — ' . $service->name)
@section('content')

<style>
.form-bg { background: linear-gradient(135deg, #161616 0%, #1e1e1e 60%, #0d0d0d 100%); }
</style>

<div class="app_checker_form form-bg min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

        <div class="mb-6">
            <a href="{{ route('checker.landing') }}" class="inline-flex items-center gap-2 text-white/50 hover:text-white transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Layanan
            </a>
        </div>

        <div class="mb-6 text-center">
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-semibold mb-3" style="background:rgba(255,60,95,0.12); color:#FF3C5F; border:1px solid rgba(255,60,95,0.25)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                {{ $service->name }}
            </div>
            <p class="text-white/50 text-sm max-w-lg mx-auto">{{ $service->description }}</p>
        </div>

        <div class="bg-white rounded-3xl overflow-hidden" style="box-shadow: 0 25px 50px rgba(0,0,0,0.4)">
            @livewire('checker.service-form', ['service' => $service])
        </div>

        <div class="mt-6 flex items-center justify-center gap-6 flex-wrap">
            @foreach(['🔒 100% Aman','📄 No Repository','⚡ Proses Cepat','✅ Terpercaya'] as $badge)
            <span class="text-white/30 text-xs font-medium">{{ $badge }}</span>
            @endforeach
        </div>

    </div>
</div>
@endsection
