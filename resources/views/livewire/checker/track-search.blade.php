<div>
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4 bg-primary/10 border border-primary/20 text-primary">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-2">Lacak & Profil</h1>
        <p class="text-gray-400 text-sm">Masukkan nomor WhatsApp Anda untuk mengecek riwayat pesanan dan sisa kuota Token.</p>
    </div>

    {{-- Form Pencarian --}}
    <div class="rounded-2xl p-6 sm:p-8 mb-6 bg-secondary/50 border border-white/10 shadow-2xl backdrop-blur-sm">
        <form wire:submit.prevent="search">
            <div class="mb-5">
                <label for="wa_input" class="block text-sm font-medium text-gray-200 mb-2">Nomor WhatsApp</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <input type="text" id="wa_input" wire:model.defer="phone" class="track-input w-full pl-12 pr-4 py-3.5 rounded-xl text-base font-mono tracking-wider" placeholder="0812XXXXXXXX" required>
                </div>
            </div>
            <button type="submit" class="track-btn w-full text-white font-bold rounded-xl text-base px-5 py-3.5 flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                <span wire:loading.remove wire:target="search" class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cek Nomor WA
                </span>
                <span wire:loading wire:target="search" class="flex items-center gap-2">

                    Memproses...
                </span>
            </button>
        </form>
    </div>

    {{-- Error Message --}}
    @if($errorMsg)
    <div class="mb-6 p-4 rounded-xl border border-rose-500/30 bg-rose-500/10 text-center">
        <p class="text-rose-400 font-medium text-sm">{{ $errorMsg }}</p>
    </div>
    @endif

    {{-- Hasil Pencarian --}}
    @if($hasSearched && $customer)
        <div class="space-y-6">
            
            {{-- Info Customer --}}
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white">Halo, {{ $customer->name }}!</h2>
                <p class="text-gray-400 text-xs mt-1">Berikut ringkasan data profil dan pesanan Anda.</p>
            </div>

            {{-- Saldo Token --}}
            @if(count($wallets) > 0)
            <div class="rounded-2xl p-6 bg-secondary/50 border border-white/10">
                <h3 class="text-white font-bold mb-4 flex items-center gap-2 text-base">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Dompet Token Anda
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($wallets as $wallet)
                    <div class="bg-dark/80 rounded-xl p-4 border border-white/10 relative overflow-hidden">
                        <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Paket Aktif</p>
                        <p class="text-white font-bold text-base truncate">{{ $wallet->package->name }}</p>
                        <div class="mt-3 flex items-end justify-between">
                            <div>
                                <p class="text-3xl font-black leading-none text-primary">{{ $wallet->total_token }}</p>
                                <p class="text-gray-400 text-xs mt-1">Token Tersisa</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-400 text-xs">Aktif Hingga</p>
                                <p class="text-white text-xs font-semibold mt-0.5">{{ \Carbon\Carbon::parse($wallet->expired_at)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Riwayat Pesanan --}}
            <div class="rounded-2xl p-6 bg-secondary/50 border border-white/10">
                <h3 class="text-white font-bold mb-4 flex items-center gap-2 text-base">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Riwayat Pesanan
                </h3>

                @if(count($orders) > 0)
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                        @foreach($orders as $order)
                        <a href="{{ route('checker.track.detail', $order->invoice_number) }}" class="block p-4 rounded-xl border border-white/10 bg-dark/60 hover:bg-dark hover:border-primary/40 transition-all group">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="text-white font-bold text-sm">{{ $order->service->name }}</p>
                                    <p class="text-gray-400 text-xs font-mono mt-0.5">{{ $order->invoice_number }}</p>
                                </div>
                                
                                @php
                                $statusColors = [
                                    'waiting_payment' => 'text-amber-400 bg-amber-500/10 border-amber-500/20',
                                    'pending' => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
                                    'paid' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                                    'processing' => 'text-orange-400 bg-orange-500/10 border-orange-500/20',
                                    'completed' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                                    'cancelled' => 'text-rose-400 bg-rose-500/10 border-rose-500/20',
                                ];
                                $color = $statusColors[$order->status] ?? 'text-gray-400 bg-gray-500/10 border-gray-500/20';
                                @endphp
                                
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-md border {{ $color }} uppercase tracking-wider">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-end mt-3 pt-2 border-t border-white/5">
                                <p class="text-gray-400 text-xs">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <span class="text-primary text-xs font-semibold group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                    Lihat Detail →
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="inline-flex w-10 h-10 rounded-full bg-white/5 items-center justify-center text-gray-500 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-gray-400 text-sm">Belum ada riwayat pesanan.</p>
                    </div>
                @endif
            </div>

        </div>
    @endif

</div>
