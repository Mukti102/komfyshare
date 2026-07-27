<div class="grid grid-cols-1 md:grid-cols-12 gap-8">
    <!-- Form Kiri -->
    <div class="md:col-span-7 space-y-6">
        <div class="glass-dark rounded-3xl p-8 border border-gray-800 relative overflow-hidden" style="background: rgba(20,20,20,0.7)">
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-[#FF3C5F] rounded-full blur-[60px] opacity-10"></div>
            
            <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                <span class="w-8 h-8 rounded-full bg-[#FF3C5F]/20 text-[#FF3C5F] flex items-center justify-center mr-3 text-sm">1</span>
                Data Pelanggan
            </h2>

            @if (session()->has('error'))
                <div class="p-4 mb-4 text-sm text-red-400 rounded-lg bg-red-900/20 border border-red-900/50">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Nomor WhatsApp Aktif</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model.live.debounce.500ms="phone" class="flex-1 bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#FF3C5F] focus:ring-1 focus:ring-[#FF3C5F] transition-all" placeholder="Contoh: 08123456789">
                        <button type="button" wire:click="checkWhatsApp" class="px-6 py-3 bg-[#2b2c2f] hover:bg-[#FF3C5F] text-white rounded-xl font-semibold transition-colors flex items-center shrink-0">
                            <span wire:loading.remove wire:target="checkWhatsApp">Cek Nomor</span>
                            <span wire:loading wire:target="checkWhatsApp">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    
                    @if($whatsapp_check_status === 'found')
                        <p class="text-green-400 text-xs mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Nomor ditemukan! Halo, {{ $name }}
                        </p>
                    @elseif($whatsapp_check_status === 'not_found')
                        <p class="text-yellow-400 text-xs mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Nomor belum terdaftar. Silakan lengkapi nama Anda di bawah.
                        </p>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">Nomor WA ini akan digunakan sebagai identitas kepemilikan token Anda.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" wire:key="name_{{ $whatsapp_check_status ?? 'init' }}" wire:model="name" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#FF3C5F] focus:ring-1 focus:ring-[#FF3C5F] transition-all" placeholder="Masukkan nama lengkap Anda">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <!-- Hanya Support QRIS Sesuai Request -->
                <div class="pt-4">
                    <label class="block text-sm font-semibold text-gray-300 mb-3">Metode Pembayaran</label>
                    <div class="p-4 rounded-xl border border-[#FF3C5F] bg-[#FF3C5F]/5 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-white p-1 flex items-center justify-center mr-4">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="w-full object-contain">
                            </div>
                            <div>
                                <p class="font-bold text-white">QRIS (Otomatis)</p>
                                <p class="text-xs text-gray-400">Scan dengan aplikasi e-Wallet atau m-Banking</p>
                            </div>
                        </div>
                        <div class="text-[#FF3C5F]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full flex items-center justify-center py-4 px-6 rounded-xl text-white font-bold text-lg bg-[#FF3C5F] hover:bg-[#e63555] transition-all glow-btn group">
                        <span wire:loading.remove wire:target="submit">Bayar & Dapatkan Token</span>
                        <span wire:loading wire:target="submit" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                        <svg wire:loading.remove wire:target="submit" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Ringkasan Kanan -->
    <div class="md:col-span-5">
        <div class="glass-dark rounded-3xl p-6 border border-gray-800 sticky top-24" style="background: rgba(20,20,20,0.7)">
            <h3 class="text-lg font-bold text-white mb-6 pb-4 border-b border-gray-800">Ringkasan Pesanan</h3>
            
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h4 class="font-bold text-white text-lg">{{ $package->name }}</h4>
                    <p class="text-sm text-gray-400 mt-1">{{ $package->description ?? 'Paket Token KomfyChecker' }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-[#FF3C5F]/10 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-[#FF3C5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-gray-900/50 rounded-xl p-4 mb-6 border border-gray-800">
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between items-center text-gray-300">
                        <span>Total Saldo Didapat</span>
                        <span class="font-bold text-white">{{ $package->total_token }} Token</span>
                    </li>
                    <li class="flex justify-between items-center text-gray-300">
                        <span>Masa Aktif</span>
                        <span class="font-bold text-white">{{ $package->expired_day }} Hari</span>
                    </li>
                </ul>
            </div>

            <div class="bg-gray-900/50 rounded-xl p-4 mb-6 border border-gray-800">
                <h5 class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-3">Layanan yang Didukung</h5>
                <ul class="space-y-2">
                    @forelse($package->packageServices as $ps)
                        <li class="flex items-center justify-between text-sm text-gray-300">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-[#FF3C5F] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $ps->service->name }}
                            </div>
                            <span class="text-xs font-semibold bg-[#FF3C5F]/20 text-[#FF3C5F] px-2 py-0.5 rounded">{{ $ps->token_cost }} Token</span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Semua layanan</li>
                    @endforelse
                </ul>
            </div>

            <div class="pt-4 border-t border-gray-800 flex justify-between items-end">
                <div>
                    <span class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Pembayaran</span>
                </div>
                <div class="text-right">
                    <span class="text-2xl font-extrabold text-[#FF3C5F]">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
