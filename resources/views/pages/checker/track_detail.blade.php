@extends('layouts.guest')
@section('title', 'Detail Pesanan — ' . $order->invoice_number)
@section('content')

<style>
.detail-bg { background: linear-gradient(135deg, #161616 0%, #1e1e1e 60%, #0d0d0d 100%); min-height: 100vh; }
.timeline-dot {
    position: absolute;
    left: -1.25rem;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid white;
}
</style>

@php
$statusConfig = [
    'waiting_payment' => ['label'=>'Menunggu Pembayaran', 'bg'=>'bg-yellow-50',  'text'=>'text-yellow-700', 'border'=>'border-yellow-200', 'badge_bg'=>'rgba(234,179,8,0.12)',   'badge_color'=>'#a16207', 'dot_bg'=>'#fef9c3'],
    'pending'         => ['label'=>'Menunggu Konfirmasi', 'bg'=>'bg-blue-50',    'text'=>'text-blue-700',   'border'=>'border-blue-200',   'badge_bg'=>'rgba(59,130,246,0.12)',  'badge_color'=>'#1d4ed8', 'dot_bg'=>'#dbeafe'],
    'processing'      => ['label'=>'Sedang Diproses',     'bg'=>'bg-orange-50',  'text'=>'text-orange-700', 'border'=>'border-orange-200', 'badge_bg'=>'rgba(249,115,22,0.12)', 'badge_color'=>'#c2410c', 'dot_bg'=>'#ffedd5'],
    'completed'       => ['label'=>'Selesai',              'bg'=>'bg-green-50',   'text'=>'text-green-700',  'border'=>'border-green-200',  'badge_bg'=>'rgba(34,197,94,0.12)',   'badge_color'=>'#15803d', 'dot_bg'=>'#dcfce7'],
    'cancelled'       => ['label'=>'Dibatalkan',           'bg'=>'bg-red-50',     'text'=>'text-red-700',    'border'=>'border-red-200',    'badge_bg'=>'rgba(239,68,68,0.12)',   'badge_color'=>'#b91c1c', 'dot_bg'=>'#fee2e2'],
];
$cfg = $statusConfig[$order->status] ?? ['label'=>$order->status,'badge_bg'=>'rgba(255,255,255,0.1)','badge_color'=>'#9ca3af','dot_bg'=>'#f3f4f6'];
@endphp

<div class=" app_checker_form detail-bg py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        {{-- Top Nav --}}
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('checker.track') }}" class="inline-flex items-center gap-2 text-white/50 hover:text-white text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Pencarian
            </a>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-bold border {{ $cfg['bg'] ?? '' }} {{ $cfg['text'] ?? '' }} {{ $cfg['border'] ?? '' }}">
                <span class="w-2 h-2 rounded-full {{ $order->status === 'processing' ? 'animate-pulse' : '' }}" style="background:{{ $cfg['badge_color'] }}"></span>
                {{ $cfg['label'] }}
            </span>
        </div>

        {{-- Invoice Card --}}
        <div class="bg-white rounded-3xl overflow-hidden mb-6" style="box-shadow:0 25px 50px rgba(0,0,0,0.3)">

            <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" style="background:linear-gradient(135deg,#161616,#2b2c2f)">
                <div>
                    <p class="text-white/40 text-xs uppercase tracking-widest font-medium mb-2">Nomor Invoice</p>
                    <p class="text-white font-mono text-2xl font-extrabold tracking-widest">{{ $order->invoice_number }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-white/40 text-xs uppercase tracking-widest font-medium mb-2">Dibuat</p>
                    <p class="text-white font-semibold">{{ $order->created_at->format('d M Y') }}</p>
                    <p class="text-white/40 text-sm">{{ $order->created_at->format('H:i') }} WIB</p>
                </div>
            </div>

            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Order Info --}}
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background:rgba(255,60,95,0.1)">
                            <svg class="w-3.5 h-3.5" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        Informasi Pesanan
                    </h3>
                    <dl class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <dt class="text-gray-500 text-sm">Layanan</dt>
                            <dd class="font-semibold text-gray-900 text-sm">{{ $order->service->name }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <dt class="text-gray-500 text-sm">Nama Pemesan</dt>
                            <dd class="font-semibold text-gray-900 text-sm">{{ $order->customer->name ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <dt class="text-gray-500 text-sm">Total Bayar</dt>
                            <dd class="font-bold text-base" style="color:#FF3C5F">
                                @if($order->total_price > 0)
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                @else
                                    <span class="text-amber-500 font-medium text-sm">Ditinjau Admin</span>
                                @endif
                            </dd>
                        </div>
                        @if($order->estimated_finish)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <dt class="text-gray-500 text-sm">Est. Selesai</dt>
                            <dd class="font-semibold text-gray-900 text-sm">{{ $order->estimated_finish->format('d M Y, H:i') }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                {{-- Result Files --}}
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </div>
                        Hasil Pengecekan
                    </h3>

                    @php $resultFiles = $order->files->where('category', 'result'); @endphp

                    @if($order->status === 'completed' && $resultFiles->count() > 0)
                        <div class="space-y-3">
                            @foreach($resultFiles as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                               class="flex items-center gap-3 p-4 transition-all rounded-2xl border group hover:shadow-md"
                               style="background:rgba(255,60,95,0.04); border-color:rgba(255,60,95,0.15)">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background:#FF3C5F">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-gray-900 text-sm truncate">{{ $file->original_name }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($file->file_size / 1024, 1) }} KB · Klik untuk unduh</p>
                                </div>
                                <svg class="w-4 h-4 flex-shrink-0" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endforeach
                        </div>
                    @elseif($order->status === 'completed')
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                            <p class="text-sm text-gray-500">Pengecekan selesai, tidak ada file yang dilampirkan.</p>
                        </div>
                    @else
                        <div class="p-6 rounded-2xl text-center border border-dashed" style="background:rgba(255,60,95,0.03); border-color:rgba(255,60,95,0.2)">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full mb-3" style="background:rgba(255,60,95,0.08)">
                                <svg class="w-6 h-6" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700 mb-1">Masih dalam proses</p>
                            <p class="text-xs text-gray-400">File hasil akan tersedia di sini setelah selesai.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8" style="box-shadow:0 10px 30px rgba(0,0,0,0.15)">
            <h3 class="text-lg font-bold text-gray-900 mb-8 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:rgba(255,60,95,0.1)">
                    <svg class="w-4 h-4" style="color:#FF3C5F" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                Riwayat Status
            </h3>

            <ol class="relative border-l-2 border-gray-100 ml-5 space-y-8">
                @forelse($order->statusLogs as $log)
                @php $logCfg = $statusConfig[$log->status] ?? ['label'=>$log->status,'dot_bg'=>'#f3f4f6','badge_color'=>'#6b7280','bg'=>'bg-gray-50','border'=>'border-gray-100']; @endphp
                <li class="ml-6 relative">
                    <span class="timeline-dot" style="background:{{ $logCfg['dot_bg'] }}; {{ $loop->first ? 'box-shadow:0 0 0 4px rgba(255,60,95,0.15)' : '' }}">
                        @if($log->status === 'completed')
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @elseif($log->status === 'processing')
                            <svg class="w-4 h-4 text-orange-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        @elseif($log->status === 'cancelled')
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @else
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </span>
                    <div class="rounded-2xl p-4 border {{ $logCfg['bg'] }} {{ $logCfg['border'] }}">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-gray-900 text-sm">{{ $logCfg['label'] }}</h4>
                            <time class="text-xs text-gray-400 font-medium">{{ $log->created_at->format('d M Y, H:i') }}</time>
                        </div>
                        @if($log->notes)
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $log->notes }}</p>
                        @endif
                    </div>
                </li>
                @empty
                <li class="ml-6">
                    <span class="timeline-dot bg-gray-100">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <p class="font-semibold text-gray-700 text-sm">Menunggu Update</p>
                        <p class="text-xs text-gray-400 mt-1">Belum ada riwayat status untuk pesanan ini.</p>
                    </div>
                </li>
                @endforelse
            </ol>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('checker.landing') }}" class="text-white/30 hover:text-white/60 text-sm transition-colors">← Kembali ke Beranda</a>
        </div>

    </div>
</div>
@endsection
