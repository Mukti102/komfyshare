@extends('layouts.guest')
@section('title', 'Detail Pesanan — ' . $order->invoice_number)
@section('content')

<style>
.kc-detail-bg {
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
.timeline-dot {
    position: absolute;
    left: -1.25rem;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #161616;
}
</style>

@php
$statusConfig = [
    'waiting_payment' => ['label'=>'Menunggu Pembayaran', 'bg'=>'bg-amber-500/10',  'text'=>'text-amber-400', 'border'=>'border-amber-500/20', 'badge_color'=>'#f59e0b', 'dot_bg'=>'#451a03'],
    'pending'         => ['label'=>'Menunggu Konfirmasi', 'bg'=>'bg-blue-500/10',   'text'=>'text-blue-400',  'border'=>'border-blue-500/20',  'badge_color'=>'#3b82f6', 'dot_bg'=>'#172554'],
    'paid'            => ['label'=>'Pembayaran Berhasil', 'bg'=>'bg-emerald-500/10','text'=>'text-emerald-400','border'=>'border-emerald-500/20','badge_color'=>'#10b981', 'dot_bg'=>'#064e3b'],
    'processing'      => ['label'=>'Sedang Diproses',     'bg'=>'bg-orange-500/10', 'text'=>'text-orange-400','border'=>'border-orange-500/20', 'badge_color'=>'#f97316', 'dot_bg'=>'#431407'],
    'completed'       => ['label'=>'Selesai',             'bg'=>'bg-emerald-500/10','text'=>'text-emerald-400','border'=>'border-emerald-500/20','badge_color'=>'#10b981', 'dot_bg'=>'#064e3b'],
    'cancelled'       => ['label'=>'Dibatalkan',          'bg'=>'bg-rose-500/10',   'text'=>'text-rose-400',   'border'=>'border-rose-500/20',  'badge_color'=>'#f43f5e', 'dot_bg'=>'#4c0519'],
];
$cfg = $statusConfig[$order->status] ?? ['label'=>$order->status,'badge_color'=>'#9ca3af','bg'=>'bg-white/5','text'=>'text-gray-300','border'=>'border-white/10','dot_bg'=>'#1f2937'];
@endphp

<div class="kc-detail-bg bg-dark min-h-screen pt-20 pb-16 px-4 sm:px-6 lg:px-8 text-gray-100 relative overflow-hidden font-sans">
    {{-- Subtle Grid Pattern Overlay --}}
    <div class="absolute inset-0 kc-grid-pattern pointer-events-none opacity-60"></div>

    <div class="relative z-10 max-w-4xl mx-auto">

        {{-- Top Nav --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('checker.track') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Pencarian
            </a>
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md text-xs font-bold border uppercase tracking-wider {{ $cfg['bg'] }} {{ $cfg['text'] }} {{ $cfg['border'] }}">
                <span class="w-2 h-2 rounded-full {{ $order->status === 'processing' ? 'animate-pulse' : '' }}" style="background:{{ $cfg['badge_color'] }}"></span>
                {{ $cfg['label'] }}
            </span>
        </div>

        {{-- Invoice Header Card --}}
        <div class="bg-secondary border border-white/10 rounded-2xl overflow-hidden mb-6 shadow-xl">
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-dark/50 border-b border-white/10">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-widest font-semibold mb-1">Nomor Invoice</p>
                    <p class="text-white font-mono text-2xl font-black tracking-wider">{{ $order->invoice_number }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-gray-400 text-xs uppercase tracking-widest font-semibold mb-1">Waktu Pemesanan</p>
                    <p class="text-white text-sm font-semibold">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>

            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Order Info --}}
                <div>
                    <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        Informasi Pesanan
                    </h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center py-2.5 border-b border-white/10">
                            <dt class="text-gray-400 text-sm">Layanan</dt>
                            <dd class="font-semibold text-white text-sm">{{ $order->service->name }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-white/10">
                            <dt class="text-gray-400 text-sm">Nama Pemesan</dt>
                            <dd class="font-semibold text-white text-sm">{{ $order->customer->name ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-white/10">
                            <dt class="text-gray-400 text-sm">Total Bayar</dt>
                            <dd class="font-black text-base text-primary">
                                @if($order->total_price > 0)
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                @else
                                    <span class="text-amber-400 font-medium text-sm">0 (Token)</span>
                                @endif
                            </dd>
                        </div>
                        @if($order->estimated_finish)
                        <div class="flex justify-between items-center py-2.5 border-b border-white/10">
                            <dt class="text-gray-400 text-sm">Est. Selesai</dt>
                            <dd class="font-semibold text-white text-sm">{{ $order->estimated_finish->format('d M Y, H:i') }}</dd>
                        </div>
                        @endif
                        @if($order->score)
                        <div class="flex justify-between items-center py-2.5 px-3 rounded-xl bg-blue-500/10 border border-blue-500/20">
                            <dt class="text-blue-300 font-medium text-sm flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                Score / Hasil
                            </dt>
                            <dd class="font-black text-blue-400 text-base">{{ $order->score }}%</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                {{-- Result Files --}}
                <div>
                    <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </div>
                        Hasil Pengecekan
                    </h3>

                    @php $resultFiles = $order->files->where('category', 'result'); @endphp

                    @if($order->status === 'completed' && $order->is_file_expired)
                        <div class="p-5 bg-rose-500/10 rounded-xl border border-rose-500/20 text-center">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-full mb-2 bg-rose-500/20 text-rose-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </div>
                            <p class="text-sm font-semibold text-rose-400 mb-1">File Telah Dihapus</p>
                            <p class="text-xs text-gray-400">Demi keamanan & efisiensi server, file hasil pengecekan telah dihapus permanen karena melebihi batas waktu 7 hari.</p>
                        </div>
                    @elseif($order->status === 'completed' && $resultFiles->count() > 0)
                        
                        {{-- Warning & Countdown --}}
                        <div class="mb-4 p-3.5 rounded-xl border border-amber-500/20 bg-amber-500/10 flex items-start gap-3 text-xs">
                            <svg class="w-4 h-4 text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <div>
                                <p class="font-semibold text-amber-300">Segera Unduh File Anda!</p>
                                <p class="text-gray-400 mt-0.5">Terhapus otomatis dalam: <span id="countdown" class="font-bold text-amber-400 bg-amber-500/20 px-1.5 py-0.5 rounded ml-1" data-expiry="{{ $order->file_expiry_date->format('Y-m-d H:i:s') }}">Menghitung...</span></p>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            @foreach($resultFiles as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                               class="flex items-center gap-3 p-3.5 transition-all rounded-xl border border-white/10 bg-dark/70 hover:bg-dark hover:border-primary/40 group">
                                <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 text-primary border border-primary/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-white text-sm truncate">{{ $file->original_name }}</p>
                                    <p class="text-xs text-gray-400">{{ number_format($file->file_size / 1024, 1) }} KB · Unduh File</p>
                                </div>
                                <svg class="w-4 h-4 flex-shrink-0 text-primary group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endforeach
                        </div>
                    @elseif($order->status === 'completed')
                        <div class="p-4 bg-dark/60 rounded-xl border border-white/10 text-center">
                            <p class="text-xs text-gray-400">Pengecekan selesai, tidak ada file yang dilampirkan.</p>
                        </div>
                    @else
                        <div class="p-6 rounded-xl text-center border border-dashed border-white/15 bg-dark/40">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-full mb-2 bg-white/5 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-200 mb-0.5">Masih dalam proses</p>
                            <p class="text-xs text-gray-400">File hasil akan tersedia di sini setelah pengerjaan selesai.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Status Logs Timeline --}}
        <div class="bg-secondary border border-white/10 rounded-2xl p-6 sm:p-8 shadow-xl">
            <h3 class="text-base font-bold text-white mb-6 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-primary border border-primary/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                Riwayat Status Pengerjaan
            </h3>

            <ol class="relative border-l-2 border-white/10 ml-5 space-y-6">
                @forelse($order->statusLogs as $log)
                @php $logCfg = $statusConfig[$log->status] ?? ['label'=>$log->status,'dot_bg'=>'#1f2937','badge_color'=>'#6b7280','bg'=>'bg-dark/60','border'=>'border-white/10']; @endphp
                <li class="ml-6 relative">
                    <span class="timeline-dot" style="background:{{ $logCfg['dot_bg'] }}">
                        @if($log->status === 'completed')
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @elseif($log->status === 'processing')
                            <svg class="w-4 h-4 text-orange-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        @elseif($log->status === 'cancelled')
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @else
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </span>
                    <div class="rounded-xl p-4 bg-dark/60 border border-white/10">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-white text-sm">{{ $logCfg['label'] }}</h4>
                            <time class="text-xs text-gray-400 font-medium">{{ $log->created_at->format('d M Y, H:i') }}</time>
                        </div>
                        @if($log->notes)
                        <p class="text-xs text-gray-300 mt-1 leading-relaxed">{{ $log->notes }}</p>
                        @endif
                    </div>
                </li>
                @empty
                <li class="ml-6">
                    <span class="timeline-dot bg-dark">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <div class="bg-dark/60 rounded-xl p-4 border border-white/10">
                        <p class="font-semibold text-gray-300 text-sm">Menunggu Update</p>
                        <p class="text-xs text-gray-400 mt-1">Belum ada riwayat status untuk pesanan ini.</p>
                    </div>
                </li>
                @endforelse
            </ol>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('checker.landing') }}" class="text-gray-400 hover:text-white text-sm transition-colors font-medium">← Kembali ke Beranda</a>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const countdownEl = document.getElementById('countdown');
    if (!countdownEl) return;

    const expiryDateStr = countdownEl.getAttribute('data-expiry');
    const expiryDate = new Date(expiryDateStr.replace(/-/g, "/"));

    function updateCountdown() {
        const now = new Date();
        const diff = expiryDate - now;

        if (diff <= 0) {
            countdownEl.textContent = 'Kedaluwarsa';
            window.location.reload();
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        countdownEl.textContent = `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
@endpush
@endsection
