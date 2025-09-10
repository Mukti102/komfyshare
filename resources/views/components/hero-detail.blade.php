<section
    class="md:min-h-screen h-[40rem] bg-black relative overflow-hidden ">
    <img src="{{asset('storage/'. $product->thumbnail)}}" alt=""
        class="absolute md:scale-[1.50]  scale-[1.40] -rotate-[10deg] top-10 md:top-0 -right-[5rem] z-20 ">
    <!-- Left Content -->
    <div class="mx-auto px-6 lg:px-0 relative z-30">
        <div class="min-h-screen relative overflow-hidden grid lg:grid-cols-2">

            <!-- Left Content -->
            <div
                class="h-full   bg-gradient-to-r from-[10%] md:from-[70%]  from-black to-transparent   relative z-50 flex items-center justify-center">
                <div class="max-w-xl space-y-6 lg:space-y-14 py-20 lg:py-0">
                    <h1 class="text-4xl lg:text-6xl font-black text-white mb-6 leading-tight text-shadow">

                        <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                            {{ $product->title }}
                        </span>

                    </h1>

                    <p class="text-white/90 text-lg lg:text-3xl mb-8 leading-relaxed">
                        Nikmati Drama & Film Eksklusif, Bebas Iklan! WeTV VIP 1 Bulan cuma Rp 28.500
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#form"
                            class="bg-primary w-max shadow-md text-white font-bold px-5 md:px-8 py-2.5 md:py-4 rounded-full hover:bg-white hover:text-pink-600 transition-all duration-300 text-sm md:text-xl">
                            Dapatkan Premium
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 z-30 left-0 w-full h-32 md:h-52 bg-gradient-to-t from-black to-transparent">
    </div>
</section>
