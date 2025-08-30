    @php use Illuminate\Support\Str; @endphp

    <div>
        <x-alert />
        @if ($order)
            <div x-data="{ showModal: false, agree: false }" x-on:show-payment-modal.window="showModal = true"
                x-on:close-payment-modal.window="showModal = false">
                <form wire:submit.prevent="checkout" method="POST"
                    class="bg-gray-900/60 backdrop-blur-xl border-2 border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 hover:shadow-primary/20 transition-all duration-500 group overflow-hidden relative max-w-lg mx-auto">

                    @csrf

                    <div class="p-8">
                        <!-- Product Info Section -->
                        <div
                            class="w-full h-max bg-primary rounded-xl p-6 mb-8 shadow-sm shadow-primary/50 group-hover:shadow-primary/80 transition-all duration-300">
                            <div class="space-y-3">
                                <h4 class="text-xl font-semibold text-white">
                                    {{ $order ? $order->product['title'] . ' ' . '(' . $order->duration . ')' : '' }}
                                </h4>
                                <div class="grid grid-cols-2 gap-4 text-white/90">
                                    <div>
                                        <span class="text-sm opacity-75">Harga</span>
                                        <p class="font-medium">{{ $order ? $order->price : '' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm opacity-75">Slot</span>
                                        <p class="font-medium">{{ $slot ? $slot : '' }}</p>
                                    </div>
                                </div>
                                <div class="pt-3 border-t border-white/20">
                                    <div class="flex justify-between items-center">
                                        <span class="text-white/90">Invoice</span>
                                        <span class="font-mono text-sm">{{ $invoice ? $invoice : '' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-white font-medium">Total</span>
                                        <span
                                            class="font-bold text-lg">{{ $order ? 'Rp ' . number_format($order->price * $slot, 0, ',', '.') : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slot Selection -->
                        <div class="flex items-center gap-4 mb-6">
                            <x-input-label for="slot" value="Jumlah Slot"
                                class="text-white text-sm font-medium whitespace-nowrap" />
                            <div class="flex items-center gap-2">
                                <input type="number" name="slot" wire:model.live.number="slot" min="1"
                                    max="100"
                                    class="bg-gray-800 text-white w-20 text-center rounded-md border-gray-500 focus:border-primary focus:ring-primary/30" />
                                <span class="text-white/70 text-sm">slot</span>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="space-y-4 mb-6">
                            <div>
                                <input type="text" wire:model="name" name="name" required
                                    placeholder="Nama Lengkap"
                                    class="bg-gray-800 text-white w-full placeholder:text-gray-500 focus:border-primary rounded-md border-gray-500 py-3 px-4" />
                            </div>

                            <div>
                                <input type="email" wire:model="email" name="email" required
                                    placeholder="Alamat Email"
                                    class="bg-gray-800 text-white w-full placeholder:text-gray-500 focus:border-primary rounded-md border-gray-500 py-3 px-4" />
                            </div>

                            <div>
                                <input type="tel" wire:model="phone" name="phone" required
                                    placeholder="Nomor Telepon"
                                    class="bg-gray-800 text-white w-full placeholder:text-gray-500 focus:border-primary rounded-md border-gray-500 py-3 px-4" />
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="mb-6">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" x-model="agree"
                                    class="h-4 w-4 mt-1 rounded border-gray-300 text-primary focus:ring-primary/30">
                                <span class="text-white text-sm leading-relaxed">
                                    Saya menyetujui <a href="#"
                                        class="text-primary underline hover:no-underline">syarat dan ketentuan</a> yang
                                    berlaku
                                </span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" wire:click="back"
                                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-md transition-all duration-200 focus:ring-4 focus:outline-none focus:ring-gray-500/30">
                                Batal
                            </button>

                            <button type="submit" :disabled="!agree"
                                class="bg-primary hover:bg-primary/90 disabled:bg-gray-500 disabled:cursor-not-allowed text-white font-medium py-3 px-4 rounded-md transition-all duration-200 focus:ring-4 focus:outline-none focus:ring-primary/30"
                                wire:loading.attr="disabled" wire:target="checkout">
                                <span wire:loading.remove wire:target="checkout">Bayar Sekarang</span>
                                <span wire:loading wire:target="checkout"
                                    class="flex items-center justify-center gap-2">
                                    
                                    <span>Memproses...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Modal -->
                <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-cloak>

                    <form wire:submit.prevent="confirmation" enctype="multipart/form-data"
                        class="bg-dark rounded-lg shadow-xl w-full max-w-md mx-4 relative"
                        x-transition:enter="transition transform ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition transform ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                        <div class="p-6">
                            <button type="button" @click="showModal = false"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <h2 class="text-lg font-semibold text-gray-100 mb-6 pr-8">Pembayaran</h2>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between items-center py-2 border-b border-gray-500">
                                    <span class="text-gray-200">Invoice</span>
                                    <span class="font-medium">{{ $invoice }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-500">
                                    <span class="text-gray-200">Total</span>
                                    <span class="font-semibold text-lg">Rp
                                        {{ number_format($cart['amount'] ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-200 mb-2">Bukti Pembayaran</label>
                                <input type="file" wire:model="payment_proof"
                                    class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            @error('payment_proof')
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-md">
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                </div>
                            @enderror

                            @if ($payment_proof)
                                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-md">
                                    <p class="text-green-700 text-sm">
                                        File terpilih: {{ Str::of($payment_proof->getClientOriginalName())->ascii() }}
                                    </p>
                                </div>
                            @else
                                <div class="mb-4 p-3 bg-gray-500 border border-gray-400 rounded-md">
                                    <p class="text-gray-200 text-sm">Belum ada file yang dipilih</p>
                                </div>
                            @endif

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-medium py-3 px-4 rounded-md transition-colors duration-200"
                                wire:loading.attr="disabled" wire:target="confirmation, payment_proof">
                                <span wire:loading.remove wire:target="confirmation">Konfirmasi Pembayaran</span>
                                <span wire:loading wire:target="confirmation"
                                    class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        @else
            <div
                class="bg-gray-900/60 backdrop-blur-xl border-2 border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 hover:shadow-primary/20 transition-all duration-500 group overflow-hidden relative">

                <div class="p-8 text-center border-b border-primary/30">
                    <div
                        class="w-14 h-14 bg-primary rounded-xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/50 group-hover:shadow-primary/80 group-hover:scale-110 transition-all duration-300">
                        <i class="fa-solid fa-bolt text-white text-3xl"></i>
                    </div>
                    <h2
                        class="text-3xl lg:text-3xl font-black text-white mb-2 group-hover:text-primary-light transition-colors duration-300">
                        PILIH PAKET {{ $selectedPriceId ? '(' . $selectedPriceId . ')' : '' }}
                    </h2>
                    <p class="text-primary-light text-lg font-medium">Mulai Sekarang</p>
                </div>

                <div class="p-6 gap-3 grid grid-cols-2">
                    @foreach ($prices as $price)
                        <!-- Paket 1 Bulan -->
                        <div class="relative">
                            @if ($price->discount)
                                <div
                                    class="absolute z-50 -top-2 -right-1 bg-red-500 text-white px-2 py-1 rounded-full text-[10px] font-black shadow-lg shadow-red-500/20 ">
                                    ⚡ Hemat 5%
                                </div>
                            @endif
                            <button wire:click="selectPrice({{ $price->id }})" class="w-full">
                                <div
                                    class="{{ $selectedPriceId == $price->id ? 'bg-primary shadow-xl shadow-primary/25 ' : 'bg-primary/10 hover:bg-primary/20' }}  border-2 border-primary/50 hover:border-primary text-white p-4 rounded-xl transition-all duration-300 group-hover/button:scale-105 group-hover/button:shadow-lg group-hover/button:shadow-primary/25 relative overflow-hidden">
                                    <div
                                        class="absolute inset-0 bg-primary/0 hover:bg-primary/10 translate-x-[-100%] group-hover/button:translate-x-[100%] transition-transform duration-1000">
                                    </div>
                                    <div class="relative z-10">
                                        <div class="flex items-center justify-center gap-2 mb-2">
                                            <h3 class="text-lg font-black">{{ $price->duration }}</h3>
                                        </div>
                                        <div class="flex flex-col justify-center items-center mb-2">
                                            <span class="text-red-400 text-xs line-through font-semibold">
                                                Rp {{ number_format($price->price * 2, 0, ',', '.') }}
                                            </span>
                                            <p class="text-sm font-bold text-primary-light">
                                                Rp {{ number_format($price->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="p-4">
                    <button wire:click="makeOrder" @disabled(!$selectedPriceId) wire:loading.attr="disabled"
                        class="w-full  {{ !$selectedPriceId ? 'bg-gray-400' : 'bg-primary hover:bg-primary/80' }} text-white font-bold px-6 py-4 rounded-2xl  focus:ring-4 focus:outline-none focus:ring-primary/30 transition-all duration-300 text-lg flex items-center justify-center gap-2">
                        <div wire:loading.remove wire:target="makeOrder">
                            Buat Pesanan
                        </div>
                        <div wire:loading wire:target="makeOrder" class="flex items-center gap-2">
                            <span>
                                Memproses...
                            </span>
                        </div>
                    </button>
                </div>

            </div>
        @endif


    </div>
