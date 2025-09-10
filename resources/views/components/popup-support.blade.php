<!-- Floating Customer Support -->
<div x-data="{ open: true }" class="fixed bottom-8 right-8 z-[10000]">
    <!-- Popup Gambar -->
    <template x-if="open">
        <div x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 scale-95"
            class="relative">
            
            <!-- Tombol Close -->
            <button @click="open = false" 
                class="absolute -top-3 -right-3 bg-red-500 w-5 h-5 text-white rounded-full  z-[10001] flex justify-center items-center">
                    <i class="fa-solid fa-xmark text-xs"></i>
            </button>

            <!-- Gambar Poster -->
            <a href="{{'https://wa.me/'.setting('general.phone')}}">
                <img class="w-40 rounded-lg shadow-lg" 
                     src="{{ asset('storage/' . setting('popup.costumer.support')) }}" 
                     alt="Support">
            </a>
        </div>
    </template>
</div>
