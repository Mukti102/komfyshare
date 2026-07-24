@extends('layouts.guest')
@section('title', 'KomfyChecker — Layanan Pengecekan Profesional')
@section('content')

<style>
.checker-hero {
    background: linear-gradient(135deg, #161616 0%, #1e1e1e 50%, #0d0d0d 100%);
}
.service-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    backdrop-filter: blur(10px);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.service-card:hover {
    transform: translateY(-6px);
    background: rgba(255,60,95,0.05);
    border-color: rgba(255,60,95,0.35);
    box-shadow: 0 20px 40px rgba(255,60,95,0.15);
}
.glow-btn {
    background: linear-gradient(135deg, #FF3C5F, #ff6b85);
    box-shadow: 0 4px 20px rgba(255,60,95,0.4);
    transition: all 0.3s ease;
}
.glow-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(255,60,95,0.6);
}
.floating { animation: floating 6s ease-in-out infinite; }
@keyframes floating {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
}
.badge-pulse { animation: pulse 2s cubic-bezier(0.4,0,0.6,1) infinite; }
.glass-dark {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
}
</style>

<div class="app_checker checker-hero min-h-screen relative overflow-hidden">

    {{-- Decorative blobs --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 rounded-full filter blur-3xl opacity-10 floating" style="background:#FF3C5F"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 rounded-full filter blur-3xl opacity-8 floating" style="background:#2b2c2f; animation-delay:3s"></div>
    <div class="absolute top-1/2 right-0 w-64 h-64 rounded-full filter blur-3xl opacity-5" style="background:#FF3C5F"></div>

    <div class="relative z-10 pt-20 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        {{-- Hero --}}
        <div class="text-center mb-20">
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 mb-6" style="background:rgba(255,60,95,0.1); border:1px solid rgba(255,60,95,0.2)">
                <span class="w-2 h-2 rounded-full badge-pulse" style="background:#FF3C5F"></span>
                <span class="text-sm font-medium" style="color:#FF3C5F">Layanan Tersedia 24/7</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                KomfyChecker
                <span class="block" style="background: linear-gradient(135deg, #FF3C5F, #ff8fa3); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Platform
                </span>
            </h1>
            <p class="text-gray-400 text-xl max-w-2xl mx-auto leading-relaxed">
                Solusi pengecekan dokumen cepat, aman, dan profesional.<br>
                100% No Repository. Privasi terjaga.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10">
                <a href="#layanan" class="glow-btn text-white font-bold px-8 py-4 rounded-2xl text-lg inline-flex items-center gap-2">
                    Mulai Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('checker.track') }}" class="text-white/70 hover:text-white font-semibold px-8 py-4 rounded-2xl text-lg border border-white/10 hover:border-white/25 transition-all inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Lacak Pesanan
                </a>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="grid grid-cols-3 gap-4 max-w-2xl mx-auto mb-20">
            @foreach([['500+','Dokumen Diproses'],['98%','Kepuasan Pelanggan'],['<24 Jam','Estimasi Selesai']] as $s)
            <div class="text-center p-4 glass-dark rounded-2xl">
                <p class="text-2xl font-extrabold text-white mb-1">{{ $s[0] }}</p>
                <p class="text-gray-400 text-xs">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Services --}}
        <div id="layanan" class="scroll-mt-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-white mb-2">Pilih Layanan</h2>
                <p class="text-gray-400">Semua layanan diproses oleh tim profesional kami.</p>
            </div>

            @if($services->isEmpty())
            <div class="text-center py-16 glass-dark rounded-3xl">
                <svg class="w-12 h-12 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-gray-400 font-medium">Belum ada layanan tersedia.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                <div class="service-card rounded-3xl p-6 flex flex-col group">
                    <div class="w-full h-0.5 rounded-full mb-6 opacity-80" style="background: linear-gradient(90deg, #FF3C5F, transparent)"></div>

                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:rgba(255,60,95,0.12)">
                            <svg class="w-7 h-7" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        @if($service->badge)
                        <span class="text-xs font-bold px-3 py-1 rounded-full" style="background:rgba(255,60,95,0.12); color:#FF3C5F; border:1px solid rgba(255,60,95,0.2)">
                            {{ $service->badge }}
                        </span>
                        @endif
                    </div>

                    <h3 class="text-white font-bold text-xl mb-2 group-hover:text-red-300 transition-colors">{{ $service->name }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed flex-1 mb-4 line-clamp-3">{{ $service->description }}</p>

                    <div class="flex items-center justify-between pt-4 border-t border-white/5">
                        <div class="flex items-center gap-1.5 text-gray-500 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            ~{{ $service->estimated_hours }} Jam
                        </div>
                        <a href="{{ route('checker.form', $service->slug) }}" class="glow-btn inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-xl text-white transition-all">
                            Mulai
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Track CTA --}}
        <div class="mt-24 rounded-3xl overflow-hidden glass-dark" style="border:1px solid rgba(255,60,95,0.15)">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-10 lg:p-14 flex flex-col justify-center">
                    <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 mb-6 w-max" style="background:rgba(255,60,95,0.1); border:1px solid rgba(255,60,95,0.2)">
                        <svg class="w-4 h-4" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span class="text-sm font-medium" style="color:#FF3C5F">Lacak Status</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-white mb-4">Sudah membuat pesanan?</h2>
                    <p class="text-gray-400 mb-8 leading-relaxed">Pantau status pengerjaan checker Anda secara real-time dan unduh hasilnya langsung ketika selesai.</p>
                    <a href="{{ route('checker.track') }}" class="glow-btn text-white font-bold px-6 py-3 rounded-2xl w-max inline-flex items-center gap-2">
                        Lacak Pesanan Saya
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>
                <div class="hidden md:flex items-center justify-center p-10">
                    <div class="glass-dark rounded-3xl p-6 space-y-4 w-72">
                        @foreach([['Pesanan Diterima','check'],['Sedang Diproses','refresh'],['Menunggu Review','clock']] as $item)
                        <div class="flex items-center gap-4 {{ $loop->last ? 'opacity-40' : '' }}">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="{{ $loop->first ? 'background:rgba(255,60,95,0.15)' : ($loop->index===1 ? 'background:rgba(255,255,255,0.06)' : 'background:rgba(255,255,255,0.04)') }}">
                                @if($item[1]==='check')<svg class="w-5 h-5" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @elseif($item[1]==='refresh')<svg class="w-5 h-5 text-white/50 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                @else<svg class="w-5 h-5 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-white text-sm font-semibold">{{ $item[0] }}</p>
                                <p class="text-gray-500 text-xs">{{ now()->subHours($loop->index * 2)->format('d M, H:i') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
