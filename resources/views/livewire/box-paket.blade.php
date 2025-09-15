    @php use Illuminate\Support\Str; @endphp
    @php
        $status = $prices->first()->product->status;
        $product = $prices->first()->product;
    @endphp

    <div id="form">
        <x-alert />
        @if ($order)
            <div x-data="{ showModal: false, agree: false }" x-on:show-payment-modal.window="showModal = true"
                x-on:close-payment-modal.window="showModal = false">
                <form wire:submit.prevent="checkout" method="POST"
                    class="bg-gray-100 backdrop-blur-xl border-2 border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 hover:shadow-primary/20 transition-all duration-500 group overflow-hidden relative max-w-lg mx-auto">

                    @csrf

                    <div class="p-8">
                        <!-- Product Info Section -->
                        @php
                            $normalPrice = $order->price ?? 0;
                            $discount = $order->product->discount ?? 0;
                            // $finalPrice = $normalPrice - ($normalPrice * $discount) / 100;
                        @endphp
                        <div
                            class="w-full h-max bg-primary rounded-xl p-6 mb-8 shadow-sm shadow-primary/50 group-hover:shadow-primary/80 transition-all duration-300">
                            <div class="space-y-3">
                                <h4 class="text-xl font-semibold text-gray-100">
                                    {{ $order ? $order->product['title'] . ' ' . '(' . $order->duration . ')' : '' }}
                                </h4>
                                <div class="grid grid-cols-2 gap-4 text-gray-100/90">
                                    <div>
                                        <span class="text-sm opacity-75">Harga</span>
                                        <p class="font-medium">
                                            {{ $order ? 'Rp ' . number_format($this->finalPrice($normalPrice, $discount), 0, ',', '.') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-sm opacity-75">Slot</span>
                                        <p class="font-medium">{{ $slot ? $slot : '' }}</p>
                                    </div>
                                </div>
                                <div class="pt-3 border-t border-white/20">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-100/90">Invoice</span>
                                        <span class="font-mono text-sm">{{ $invoice ? $invoice : '' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-gray-100 font-medium">Total</span>
                                        <span
                                            class="font-bold text-lg">{{ $order ? 'Rp ' . number_format($this->totalPrice($normalPrice, $discount), 0, ',', '.') : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slot Selection -->
                        <div class="flex items-center gap-4 mb-6">
                            <x-input-label for="slot" value="Jumlah Slot"
                                class="text-gray-900 text-sm font-medium whitespace-nowrap" />
                            <div class="flex items-center gap-2">
                                <input type="number" name="slot" wire:model.live.number="slot" min="1"
                                    max="100"
                                    class="bg-gray-200 text-gray-900 w-20 text-center rounded-md border-gray-300 focus:border-primary focus:ring-primary/30" />
                                <span class="text-gray-900/70 text-sm">slot</span>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="space-y-4 mb-6">
                            <div>
                                <input type="text" wire:model="name" name="name" required
                                    placeholder="Nama Lengkap"
                                    class="bg-gray-200 text-gray-900 w-full placeholder:text-gray-500 focus:border-primary rounded-md border-gray-400 py-3 px-4" />
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror

                            </div>

                            <div>
                                <input type="email" wire:model="email" name="email" required
                                    placeholder="Alamat Email"
                                    class="bg-gray-200 text-gray-900 w-full placeholder:text-gray-500 focus:border-primary rounded-md border-gray-400 py-3 px-4" />
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="grid grid-cols-3 gap-2">
                                <select wire:model="countryCode" id="countryCode"
                                    class="col-span-1 bg-gray-200 text-gray-900 placeholder:text-gray-500
           focus:border-primary rounded-md border-gray-400 py-3 px-4">
                                    <option value="">Pilih kode</option>
                                    @foreach ($codes as $c)
                                        <option value="{{ $c['code'] }}"
                                            {{ $c['code'] === '+62' ? 'selected' : '' }}>
                                            ({{ $c['code'] }})
                                            {{ $c['label'] }}
                                        </option>
                                    @endforeach
                                </select>


                                <input type="tel" wire:model="phone" name="phone" required x-data
                                    x-on:input="$el.value = $el.value.replace(/^\+62|^62|^0/, '')"
                                    placeholder="Nomor Telepon"
                                    class="bg-gray-200 col-span-2 text-gray-900  placeholder:text-gray-500 focus:border-primary rounded-md border-gray-400 py-3 px-4" />
                                @error('phone')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="flex gap-2">
                                <input type="tel" wire:model="coupon" name="coupon"
                                    placeholder="Masukkan Kode Kupon"
                                    class="bg-gray-200 text-gray-900 uppercase placeholder:capitalize w-full placeholder:text-gray-500 focus:border-primary rounded-md border-gray-400 py-3 px-4" />
                                <button type="button" wire:loading.attr="disabled" wire:target="checkout"
                                    wire:click="checkCoupon" class="bg-primary px-5 py-1 rounded-md">
                                    <span wire:loading.remove wire:target="checkCoupon">Cek</span>
                                    <span wire:loading wire:target="checkCoupon">Mengecek...</span>

                                </button>

                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="mb-6">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" x-model="agree"
                                    class="h-4 w-4 mt-1 rounded border-gray-300 text-primary focus:ring-primary/30">
                                <span class="text-gray-900 text-sm leading-relaxed">
                                    Saya menyetujui <a href="{{ route('term') }}"
                                        class="text-primary underline hover:no-underline">syarat dan ketentuan</a> yang
                                    berlaku
                                </span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" wire:click="back"
                                class="bg-black/20 border border-gray-400 text-gray-900 font-medium py-3 px-4 rounded-md transition-all duration-200 focus:ring-4 focus:outline-none focus:ring-gray-500/30">
                                Batal
                            </button>

                            <button type="submit" :disabled="!agree"
                                class="bg-primary hover:bg-primary/90 disabled:bg-black/20 disbaled:border disabled:border-gray-400 disabled:cursor-not-allowed text-gray-100 font-medium py-3 px-4 rounded-md transition-all duration-200 focus:ring-4 focus:outline-none focus:ring-primary/30"
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
                @include('includes.paymentModal')
            </div>
        @else
            <div>
                <div
                    class="bg-gray-50 backdrop-blur-xl border-2 border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 hover:shadow-primary/20 transition-all duration-500 group overflow-hidden relative">

                    <div class="p-8 text-center border-b border-primary/30">
                        <div
                            class="w-14 h-14 bg-primary rounded-xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/50 group-hover:shadow-primary/80 group-hover:scale-110 transition-all duration-300">
                            <i class="fa-solid fa-bolt text-gray-100 text-3xl"></i>
                        </div>
                        <h2
                            class="text-3xl lg:text-3xl font-black text-gray-900 mb-2 group-hover:text-primary-light transition-colors duration-300">
                            PILIH PAKET {{ $selectedPriceId ? '(' . $selectedPriceId . ')' : '' }}
                        </h2>
                        <p class="text-gray-700 text-lg font-medium">Mulai Sekarang</p>
                    </div>

                    <div class="p-6 gap-3 grid grid-cols-2">
                        @foreach ($prices as $price)
                            <!-- Paket 1 Bulan -->
                            <div class="relative" wire:key="price-{{ $price->id }}">
                                @if ($price->product->discount)
                                    <div
                                        class="absolute z-50 -top-2 -right-1 bg-red-500 text-white px-2 py-1 rounded-full text-[10px] font-black shadow-lg shadow-red-500/20">
                                        ⚡ Hemat {{ $price->product->discount }}%
                                    </div>
                                @endif

                                <button type="button" wire:click.stop="selectPrice({{ $price->id }})"
                                    class="w-full" @disabled(!$price->status)>

                                    <div
                                        class="{{ $selectedPriceId == $price->id && $price->status
                                            ? 'bg-primary text-gray-100 shadow-xl shadow-primary/25'
                                            : ($price->status
                                                ? 'bg-primary/10 hover:bg-primary/20  border-2 border-primary/50 text-gray-900'
                                                : 'bg-gray-300  border-2 border-gray-400 text-gray-500 cursor-not-allowed') }}
                p-4 rounded-xl transition-all duration-300 relative overflow-hidden">

                                        <div class="relative z-10">
                                            <div class="flex items-center justify-center gap-2 mb-2">
                                                <h3 class="text-lg font-black">{{ $price->duration }}</h3>
                                            </div>
                                            <div class="flex flex-col justify-center items-center mb-2">
                                                @if ($price->product->discount > 0 && $price->status)
                                                    <span class="text-red-400 text-xs line-through font-semibold">
                                                        Rp {{ number_format($this->normalPrice($price), 0, ',', '.') }}
                                                    </span>
                                                @endif
                                                <p
                                                    class="text-sm font-bold {{ $price->status ? 'text-primary-light' : 'text-gray-500' }}">
                                                    Rp {{ number_format($this->finalPrice($price), 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </button>

                            </div>
                        @endforeach

                    </div>

                    <div class="p-4 flex flex-col gap-3">
                        <button wire:click="makeOrder" @disabled(!$selectedPriceId || !$status) wire:loading.attr="disabled"
                            class="w-full  {{ !$selectedPriceId || !$status ? 'bg-black/10 border text-black/30 border-gray-400' : 'bg-primary hover:bg-primary/80 text-gray-100' }}  font-bold px-6 py-4 rounded-2xl  focus:ring-4 focus:outline-none focus:ring-primary/30 transition-all duration-300 text-lg flex items-center justify-center gap-2">
                            <div wire:loading.remove wire:target="makeOrder">
                                {{ !$status ? 'Pesanan Tidak Tersedia' : 'Buat Pesanan' }}
                            </div>
                            <div wire:loading wire:target="makeOrder" class="flex items-center gap-2">
                                <span>
                                    Memproses...
                                </span>
                            </div>
                        </button>
                        <button wire:click="setShareModal"
                            class="w-full  bg-primary/80 hover:bg-primary/70 text-gray-100  font-bold px-6 py-4 rounded-2xl  focus:ring-4 focus:outline-none focus:ring-primary/30 transition-all duration-300 text-lg flex items-center justify-center gap-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                </svg>
                                <span>
                                    Bagikan
                                </span>
                            </div>
                        </button>
                    </div>
                </div>
                @include('includes.shareModal')


            </div>

        @endif


    </div>

    
