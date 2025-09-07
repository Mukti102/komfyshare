<section class="bg-black text-white p-5 lg:p-10 space-y-12 min-h-screen relative overflow-hidden">
    <!-- Animated background -->
    <div class="absolute  inset-0 pointer-events-none">
        <!-- Grid lines -->
        <div class="absolute inset-0 opacity-10">
            <div class="grid grid-cols-12 h-full">
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
                <div class="border-r border-gray-400"></div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center relative z-10">
        <div
            class="flex justify-center w-max mx-auto items-center gap-3 mb-8 px-3 md:px-6 py-2 md:py-3 border border-primary/50 rounded-full bg-primary/10 backdrop-blur-sm">
            <div class="md:w-3 md:h-3 w-2 h-2 bg-primary rounded-full animate-pulse shadow-lg shadow-primary/50"></div>
            <span class="text-primary-light text-[11px] md:text-sm font-bold tracking-widest uppercase">Premium Experience</span>
            <div class="w-3 h-3 bg-primary-dark rounded-full animate-pulse shadow-lg shadow-primary-dark/50"
                style="animation-delay: 0.5s;"></div>
        </div>
        <h1 class="font-black text-2xl lg:text-6xl leading-none tracking-tight mb-4">
            <span class="block text-white drop-shadow-lg">Langganan Lebih Ringan</span>
        </h1>
        <p class="md:mt-8 mt-2 text-gray-300 text-xs lg:text-2xl font-light max-w-3xl mx-auto leading-relaxed">
            Nikmati premium dengan harga terbaik di
            <span class="text-primary font-bold">Komfy Share</span><br>
            <span class="text-primary-light font-medium">Batalkan kapan saja</span>
        </p>
    </div>

    <!-- Detail -->
    <div class="grid grid-cols-1  lg:grid-cols-3 gap-5 relative z-10">
        <div class="lg:col-span-2 space-y-6">
           <x-boxone :product="$product"/>

           <x-box-detail-price :product="$product"/>

           <x-box-schema :product="$product"/>
        </div>

        <!-- Pricing Card -->
        <div class="lg:col-span-1 h-max space-y-5">
           @livewire('box-paket', ['prices' => $product->prices])
           @livewire('box-group-list',['product' => $product])
        </div>
    </div>
</section>