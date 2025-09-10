<!-- Tabs Container -->
<div 
    x-data="{ tab: 'skema' }" 
    class="bg-white backdrop-blur-xl border border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 transition-all duration-500 group relative overflow-hidden"
>
    <!-- Top border animation -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-light via-primary to-primary-dark animate-pulse"></div>

    <div class="relative">
        <!-- background circle -->
        <div class="absolute bottom-6 left-6 w-20 h-20 bg-primary/20 rounded-full blur-2xl animate-pulse"
             style="animation-delay: 1s;"></div>

        <div class="relative z-10">
            <!-- Tab Buttons -->
            <div class="flex border-b-[1.5px] border-gray-300 justify-center items-center gap-6">
                <div class="md:p-4 p-3">
                    <div class="flex gap-5 items-center">
                        <button 
                            @click="tab = 'skema'"
                            :class="tab === 'skema' ? 'bg-primary text-gray-100' : 'text-gray-900 hover:text-primary'"
                            class="text-sm lg:text-3xl px-4 py-3 rounded-lg font-bold transition-colors duration-300"
                        >
                            Skema Berlangganan
                        </button>
                        <button 
                            @click="tab = 'informasi'"
                            :class="tab === 'informasi' ? 'bg-primary text-gray-100' : 'text-gray-900 hover:text-primary'"
                            class="text-sm lg:text-3xl px-4 py-3 rounded-lg font-bold transition-colors duration-300"
                        >
                            Informasi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="prose p-3 md:p-5 pt-0 pb-7 md:text-base text-xs max-w-none text-gray-900 dark:prose-invert">
                <div x-show="tab === 'skema'" x-transition>
                    {!! $product->description !!}
                </div>
                <div x-show="tab === 'informasi'" x-transition>
                    {!! $product->information !!}
                </div>
            </div>
        </div>
    </div>
</div>
