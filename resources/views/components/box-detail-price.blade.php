 <!-- Detail Harga -->
            <div
                class="bg-gray-50 backdrop-blur-xl border border-primary/30 p-8 rounded-3xl shadow-2xl hover:border-primary/60  transition-all duration-500 group relative overflow-hidden">
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-light via-primary to-primary-dark">
                </div>
                <div class="flex items-start gap-2 md:gap-3 mb-8">
                    <div>
                        <h2
                            class="text-xl lg:text-4xl font-bold md:font-black text-dark mb-3 group-hover:text-primary-light transition-colors duration-300">
                            Detail Harga
                        </h2>
                        <p class="text-gray-800 text-sm md:text-lg font-medium">Transparan & Kompetitif</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($product->priceDetails as $item)
                    <div
                        class="flex items-center gap-2 md:gap-4 p-4 md:p-4 rounded-lg border border-primary/20 hover:border-primary/40 bg-primary/10 transition-all duration-300">
                        <div
                            class="md:w-4 md:h-4 w-2 h-2 bg-primary rounded-full shadow-lg shadow-primary/50">
                        </div>
                        <span
                            class="md:text-lg text-sm font-semibold text-gray-900 hover:text-dark transition-colors duration-300">{{$item}}</span>
                    </div>
                    @endforeach
                </div>
            </div>