<div class="w-full py-10">
    <div class="text-center space-y-2 mb-8">
        <h2 class="font-black text-[2rem] md:text-[4rem]">Share More Pay Less</h2>
        <h3 class="text-base font-medium text-[1.5rem]">Berbagi Langganan, Lebih Hemat!</h3>
    </div>

    {{-- Buttons --}}
    <div class="grid grid-cols-4 md:grid-cols-5 gap-4">
        <button 
            wire:click="$set('activeCategory', 'all')" 
            class="text-white  bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br 
                {{ $activeCategory === 'all' ? 'ring-4 ring-red-300' : '' }}
                font-medium rounded-full text-sm md:text-lg px-4 md:px-5 py-2 md:py-3 text-center">
            Semua
        </button>

        @foreach($categories as $category)
            <button 
                wire:click="$set('activeCategory', {{ $category->id }})"
                class="text-white  bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br 
                    {{ $activeCategory === $category->id ? 'ring-4 ring-red-300' : '' }}
                    font-medium rounded-full text-sm md:text-lg px-4 md:px-5 py-2 md:py-3 text-center">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    {{-- Loading Spinner --}}
    <div wire:loading.flex class="justify-center items-center py-10 col-span-full">
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-red-500"></div>
    </div>

    {{-- Cards --}}
    <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-4 gap-4 py-10">
        @if($activeCategory === 'all')
            @foreach($categories as $category)
                @foreach($category->products as $product)
                    @livewire('card-product', ['product' => $product], key('all-'.$product->id))
                @endforeach
            @endforeach
        @else
            @php
                $selectedCategory = $categories->firstWhere('id', $activeCategory);
            @endphp

            @if($selectedCategory)
                @foreach($selectedCategory->products as $product)
                    @livewire('card-product', ['product' => $product], key('cat-'.$product->id))
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-500">Belum ada produk.</p>
            @endif
        @endif
    </div>
</div>
