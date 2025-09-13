<!-- Floating Customer Support -->
<div x-data="{ open: true, modalServices: false }" class="fixed bottom-8 right-8 z-[10000]">
    <!-- Popup Gambar -->
    <template x-if="open">
        <div x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 scale-95" class="relative">

            <!-- Tombol Close -->
            <button @click="open = false"
                class="absolute -top-3 -right-3 bg-red-500 w-5 h-5 text-white rounded-full  z-[10001] flex justify-center items-center">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>

            <!-- Gambar Poster -->
            <button @click="modalServices = true">
                <img class="w-40 " src="{{ asset('storage/' . setting('popup.costumer.support')) }}"
                    alt="Support">
            </button>
        </div>
    </template>
    {{-- modal  --}}
    {{-- popup poster --}}
    <div x-show="modalServices" x-transition:enter="transition ease-out duration-500 z-50"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-400" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50">
        <div class="bg-white md:max-h-[800vh] rounded-2xl shadow-2xl md:max-w-xl w-[80%] mx-auto  text-center relative">
            <!-- Tombol Close -->
            <button @click="modalServices = false"
                class="absolute md:-top-3 md:-right-3 -top-6 -right-6  rounded-full w-5 h-5 md:w-6 md:h-6 right-3 text-white hover:bg-black/60 bg-black/70 hover:text-gray-200 flex justify-center items-center">
                <span class="md:text-sm text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </span>
            </button>

            <div class="p-6 bg-white rounded-2xl shadow-lg">
                <h2 class="text-lg text-start font-semibold text-gray-800 mb-6">Pengaduan Layanan</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach (setting('popup.support.type') as $item)
                        <a href="{{ $item['link_support'] }}"
                            class="flex flex-col items-center justify-center bg-white rounded-xl border border-gray-300 shadow-md hover:shadow-lg transition-shadow duration-300 p-6 text-center">

                            <!-- Gambar -->
                            <div
                                class="w-24 h-24 mb-4 flex items-center justify-center bg-gray-50  ">
                                <img src="{{ asset('storage/' . $item['image_support']) }}"
                                    alt="{{ $item['name_support'] }}"
                                    class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>

                            <!-- Text -->
                            <h3 class="text-sm font-medium text-gray-700 group-hover:text-primary transition">
                                {{ $item['name_support'] }}
                            </h3>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>
