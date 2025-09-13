{{-- popup poster --}}
<div x-data="{ open: false }" x-init="setTimeout(() => open = true, 1500)" x-show="open"
    x-transition:enter="transition ease-out duration-500 z-50" x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-400"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50">
    <div class="bg-white md:max-h-[800vh] rounded-2xl shadow-2xl md:max-w-md w-[80%] mx-auto  text-center relative">
        <!-- Tombol Close -->
        <button @click="open = false"
            class="absolute md:-top-8 md:-right-8 -top-6 -right-6  rounded-full w-5 h-5 md:w-6 md:h-6 right-3 text-primary bg-white hover:text-gray-700 flex justify-center items-center">
            <span class="md:text-sm text-xs">
                <i class="fa-solid fa-xmark"></i>
            </span>
        </button>

        @if (setting('popu.information.link'))
            <a href="{{ setting('popu.information.link') }}">
                <img src="{{ 'storage/' . setting('popup.information') }}"
                    class="w-full rounded-xl h-full object-contain" alt="">
            </a>
        @else
            <div>
                <img src="{{ 'storage/' . setting('popup.information') }}"
                    class="w-full rounded-xl h-full object-contain" alt="">
            </div>
        @endif

    </div>
</div>
