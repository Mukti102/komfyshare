<div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-cloak>

    <form wire:submit.prevent="confirmation" enctype="multipart/form-data"
        class="bg-gray-100 rounded-lg overflow-y-auto max-h-2xl shadow-xl w-full max-w-md mx-4 relative"
        x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition transform ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

        <div class="p-6  overflow-y-auto">
            <button type="button" @click="showModal = false"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h2 class="text-lg font-semibold text-gray-800 mb-6 pr-8">Pembayaran</h2>

            <div class="space-y-4 mb-6">
                <div class="flex justify-between items-center py-2 border-b border-gray-500">
                    <span class="text-gray-700">Invoice</span>
                    <span class="font-medium text-gray-800">{{ $invoice }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-500">
                    <span class="text-gray-700">Total</span>
                    <span class="font-semibold text-lg text-gray-800">Rp
                        {{ number_format($cart['amount'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mb-4" x-data="{
                metode: '{{ $paymentMethods[0]->name ?? 'qris' }}',
                category: '{{ $paymentMethods[0]->category ?? '' }}'
            }">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Metode Pembayaran
                </label>

                {{-- Tab Buttons --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach ($paymentMethods->pluck('category')->unique() as $cat)
                        <button type="button" @click="category = '{{ $cat }}'"
                            :class="category === '{{ $cat }}'
                                ?
                                'bg-primary text-xs text-white ring-2 ring-primary border-primary' :
                                'border border-black/10 text-gray-700'"
                            class="px-2 rounded-lg transition">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                {{-- Pilihan Metode --}}
                <div class="grid grid-cols-3 gap-3">
                    @foreach ($paymentMethods as $paymentMethod)
                        <template x-if="category === '{{ $paymentMethod->category }}'">
                            <button class="h-32 h-32 rounded-md overflow-hidden" type="button" @click="metode = '{{ $paymentMethod->name }}'"
                                wire:click="setPaymentMethodId({{ $paymentMethod->id }})"
                                :class="metode === '{{ $paymentMethod->name }}'
                                    ?
                                    'ring-2 ring-primary border-primary' :
                                    'border border-black/10'"
                                class="rounded-lg p-1 transition">
                                <img src="{{ asset('storage/' . $paymentMethod->logo) }}"
                                    alt="{{ $paymentMethod->name }}" class="w-full h-full object-contain">
                            </button>
                        </template>
                    @endforeach
                </div>
            </div>


            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-black/20 disabled:text-gray-400 text-gray-200 font-medium py-3 px-4 rounded-md transition-colors duration-200"
                wire:loading.attr="disabled" wire:target="confirmation, payment_proof">
                <span wire:loading.remove wire:target="confirmation">Konfirmasi Pembayaran</span>
                <span wire:loading wire:target="confirmation" class="flex items-center justify-center">

                    Memproses...
                </span>
            </button>
        </div>
    </form>
</div>
