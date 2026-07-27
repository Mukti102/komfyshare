@extends('layouts.guest')
@section('title', 'KomfyChecker — Layanan Pengecekan Dokumen & Akademik Profesional')
@section('content')

<style>
.kc-landing-bg {
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
.kc-card {
    background: rgba(43, 44, 47, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.kc-card:hover {
    border-color: rgba(255, 60, 95, 0.4);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px -10px rgba(0, 0, 0, 0.6);
}
.kc-btn-primary {
    background-color: #FF3C5F;
    color: #ffffff;
    transition: all 0.2s ease;
}
.kc-btn-primary:hover {
    background-color: #e02e4d;
    box-shadow: 0 6px 20px rgba(255, 60, 95, 0.3);
    transform: translateY(-1px);
}
</style>

<div class="kc-landing-bg bg-dark min-h-screen text-gray-100 relative overflow-hidden font-sans pt-16">
    {{-- Subtle Grid Pattern Overlay --}}
    <div class="absolute inset-0 kc-grid-pattern pointer-events-none opacity-60"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24">

        {{-- Hero Section --}}
        <div class="max-w-3xl mx-auto text-center pt-8 pb-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-semibold tracking-wide uppercase mb-6">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                100% No Repository & Privasi Terjaga
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
                Layanan Pengecekan Dokumen Akademik Cepat & Akurat
            </h1>

            <p class="text-gray-300 text-base sm:text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
                Solusi terpercaya untuk cek plagiarisme, skor AI, dan koreksi dokumen. Proses transparan, pengerjaan cepat, dan kerahasiaan naskah terjamin sepenuhnya.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#layanan" class="kc-btn-primary bg-primary hover:bg-primary/90 text-white font-bold px-7 py-3.5 rounded-xl text-base w-full sm:w-auto inline-flex items-center justify-center gap-2">
                    Lihat Layanan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
                <a href="{{ route('checker.track') }}" class="w-full sm:w-auto bg-secondary/80 hover:bg-secondary text-gray-200 hover:text-white font-semibold px-7 py-3.5 rounded-xl text-base border border-white/10 transition-all inline-flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Lacak Pesanan / Token
                </a>
            </div>
        </div>

        {{-- Feature Highlights --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
            <div class="p-6 rounded-2xl bg-secondary/40 border border-white/10 flex items-start gap-4">
                <div class="p-3 rounded-xl bg-primary/10 text-primary shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-base mb-1">Aman & Terjaga</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Dokumen tidak masuk ke database repository sehingga bebas dari potensi plagiarisme internal.</p>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-secondary/40 border border-white/10 flex items-start gap-4">
                <div class="p-3 rounded-xl bg-blue-500/10 text-blue-400 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-base mb-1">Proses Cepat</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Estimasi pengerjaan yang jelas dan hasil langsung dapat diunduh begitu proses selesai.</p>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-secondary/40 border border-white/10 flex items-start gap-4">
                <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-400 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-base mb-1">Pembayaran Fleksibel</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Dukung transaksi via Midtrans/Tokopay serta opsi penggunaan saldo Paket Token.</p>
                </div>
            </div>
        </div>

        {{-- Services Section --}}
        <div id="layanan" class="scroll-mt-20 mb-24">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 pb-4 border-b border-white/10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Katalog Layanan Pengecekan</h2>
                    <p class="text-gray-400 text-sm mt-1">Pilih jenis pengecekan yang Anda butuhkan untuk memulai order.</p>
                </div>
            </div>

            @if($services->isEmpty())
                <div class="text-center py-12 rounded-2xl bg-secondary/40 border border-white/10">
                    <svg class="w-12 h-12 text-gray-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-gray-400 font-medium">Belum ada layanan yang aktif saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="kc-card rounded-2xl p-6 flex flex-col justify-between group relative bg-secondary/40 border border-white/10">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-secondary flex items-center justify-center text-primary border border-white/10">
                                        @if($service->icon)
                                            <x-dynamic-component :component="$service->icon" class="w-6 h-6 text-primary" />
                                        @else
                                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        @endif
                                    </div>
                                    @if($service->badge)
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-primary/10 text-primary border border-primary/20">
                                            {{ $service->badge }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-primary transition-colors">
                                    {{ $service->name }}
                                </h3>
                                
                                <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3">
                                    {{ $service->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                                <div class="flex items-center gap-1.5 text-gray-400 text-xs font-medium">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    ~{{ $service->estimated_hours }} Jam Pengerjaan
                                </div>

                                <a href="{{ route('checker.form', $service->slug) }}" class="kc-btn-primary bg-primary hover:bg-primary/90 text-xs font-bold px-4 py-2.5 rounded-lg inline-flex items-center gap-1.5">
                                    Pesan Sekarang
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Token Packages Section --}}
        @if(isset($packages) && $packages->count() > 0)
        <div id="paket" class="scroll-mt-20 mb-24">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full border border-primary/20">Opsi Berlangganan</span>
                <h2 class="text-3xl font-extrabold text-white tracking-tight mt-3 mb-2">Paket Token Hemat</h2>
                <p class="text-gray-400 text-sm leading-relaxed">Beli saldo token untuk kemudahan pemesanan cepat dan tarif lebih terjangkau.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($packages as $package)
                    <div class="kc-card rounded-2xl p-7 flex flex-col justify-between border border-white/10 bg-secondary/50 relative">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-white">{{ $package->name }}</h3>
                                <span class="text-xs font-bold text-primary bg-primary/10 border border-primary/20 px-2.5 py-1 rounded-md">
                                    {{ $package->total_token }} Token
                                </span>
                            </div>

                            <div class="mb-6">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-3xl font-black text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Masa aktif saldo: <span class="text-gray-200 font-semibold">{{ $package->expired_day }} Hari</span></p>
                            </div>

                            @if($package->description)
                                <p class="text-gray-400 text-xs mb-6 leading-relaxed bg-dark/60 p-3 rounded-lg border border-white/5">
                                    {{ $package->description }}
                                </p>
                            @endif

                            @if($package->packageServices && $package->packageServices->count() > 0)
                                <div class="mb-6">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2.5">Layanan Tercover:</p>
                                    <ul class="space-y-2">
                                        @foreach($package->packageServices as $ps)
                                            @if($ps->service)
                                                <li class="flex items-center justify-between text-xs text-gray-300">
                                                    <span class="flex items-center gap-2">
                                                        <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                        {{ $ps->service->name }}
                                                    </span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('checker.package.checkout', $package->id) }}" class="w-full py-3 text-center rounded-xl font-bold text-xs uppercase tracking-wider transition-all border border-primary/40 text-primary hover:bg-primary hover:text-white hover:border-primary">
                            Beli Paket Token
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- How it Works Workflow --}}
        <div class="mb-24 rounded-2xl bg-secondary/40 border border-white/10 p-8 sm:p-10">
            <div class="text-center max-w-xl mx-auto mb-10">
                <h2 class="text-2xl font-bold text-white mb-2">Cara Kerja KomfyChecker</h2>
                <p class="text-gray-400 text-sm">4 langkah sederhana menyelesaikan pengecekan dokumen Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-5 rounded-xl bg-dark/60 border border-white/5">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-sm mb-3">1</span>
                    <h4 class="text-white font-semibold text-base mb-1">Pilih Layanan</h4>
                    <p class="text-gray-400 text-xs leading-relaxed">Tentukan jenis pengecekan dan isi detail informasi naskah Anda.</p>
                </div>

                <div class="p-5 rounded-xl bg-dark/60 border border-white/5">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-sm mb-3">2</span>
                    <h4 class="text-white font-semibold text-base mb-1">Upload & Bayar</h4>
                    <p class="text-gray-400 text-xs leading-relaxed">Unggah file (PDF/DOCX) lalu lakukan pembayaran via QRIS/Bank/Token.</p>
                </div>

                <div class="p-5 rounded-xl bg-dark/60 border border-white/5">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-sm mb-3">3</span>
                    <h4 class="text-white font-semibold text-base mb-1">Pemrosesan Tim</h4>
                    <p class="text-gray-400 text-xs leading-relaxed">Tim profesional memproses dokumen Anda secara teliti dan aman.</p>
                </div>

                <div class="p-5 rounded-xl bg-dark/60 border border-white/5">
                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-sm mb-3">4</span>
                    <h4 class="text-white font-semibold text-base mb-1">Lacak & Unduh</h4>
                    <p class="text-gray-400 text-xs leading-relaxed">Masukkan nomor WA di menu Lacak untuk mengunduh file hasil jadi.</p>
                </div>
            </div>
        </div>

        {{-- Testimonials Section --}}
        @if(isset($testimonials) && $testimonials->count() > 0)
        <div class="mb-24 scroll-mt-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold text-primary tracking-wider uppercase bg-primary/10 px-3 py-1 rounded-full border border-primary/20">Testimoni Pengguna</span>
                <h2 class="text-3xl font-extrabold text-white tracking-tight mt-3 mb-2">Apa Kata Mahasiswa & Peneliti?</h2>
                <p class="text-gray-400 text-sm leading-relaxed">Pengalaman nyata dari berbagai civitas akademika perguruan tinggi yang mempercayakan pengecekan dokumen di KomfyChecker.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($testimonials as $testimonial)
                    <div class="kc-card rounded-2xl p-6 flex flex-col justify-between bg-secondary/40 border border-white/10 relative group">
                        {{-- Quote Icon Accent --}}
                        <div class="absolute top-5 right-5 text-gray-700/30 group-hover:text-primary/20 transition-colors">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>

                        <div class="relative z-10 mb-6">
                            {{-- Rating Stars --}}
                            <div class="flex items-center gap-1 text-amber-400 mb-3">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>

                            {{-- Message --}}
                            <p class="text-gray-300 text-sm leading-relaxed italic">
                                "{{ $testimonial->message }}"
                            </p>
                        </div>

                        {{-- User Info & Logo --}}
                        <div class="pt-4 border-t border-white/10 flex items-center justify-between relative z-10">
                            <div class="flex items-center gap-3">
                                @if($testimonial->logo)
                                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 p-1.5 flex items-center justify-center shrink-0 overflow-hidden">
                                        <img src="{{ Storage::url($testimonial->logo) }}" alt="{{ $testimonial->university }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($testimonial->university, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-white font-bold text-sm group-hover:text-primary transition-colors">{{ $testimonial->name }}</h4>
                                    <p class="text-gray-400 text-xs flex items-center gap-1 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        <span>{{ $testimonial->university }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Track CTA Banner --}}
        <div class="rounded-2xl bg-secondary/80 border border-white/10 p-8 sm:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl">
                <h3 class="text-2xl font-bold text-white mb-2">Ingin Memeriksa Status Pesanan Anda?</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Gunakan fitur Lacak untuk mengecek saldo token atau melihat perkembangan pengerjaan dokumen Anda secara langsung.</p>
            </div>
            <a href="{{ route('checker.track') }}" class="kc-btn-primary bg-primary hover:bg-primary/90 font-bold px-6 py-3.5 rounded-xl text-sm shrink-0 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Buka Halaman Lacak
            </a>
        </div>

    </div>
</div>
@endsection
