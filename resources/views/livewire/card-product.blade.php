<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <a href="{{ route('product.show', $product->id) }}" class="block w-full max-h-64 overflow-hidden rounded-t-lg">
        <img 
            class="object-contain w-full h-64 p-8" 
            src="{{ asset('storage/' . $product->image) }}" 
            alt="{{ $product->name ?? 'Product image' }}" />
    </a>

    <div class="px-5 pb-5">
        <a href="{{ route('product.show', $product->id) }}">
            <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $product->title ?? 'Nama Produk' }}
            </h5>
        </a>

        <a href="{{ route('product.show', $product->id) }}">
            <p class="text-base font-semibold tracking-tight text-gray-700 dark:text-white">
                {{ $product->subtitle ?? 'Keterangan Produk' }}
            </p>
        </a>

        <div class="flex items-center justify-between mt-2.5 mb-5">
            <div class="flex gap-2 items-center text-gray-900">
                <span class="text-xs line-through text-gray-500 dark:text-gray-400">
                    Rp.{{ number_format($product->prices->first()->price * 1.5 ?? 0, 0, ',', '.') }}
                </span>
                <span class="font-bold text-lg text-red-600">
                    Rp.{{ number_format($product->prices->first()->price ?? 0, 0, ',', '.') }}
                </span>
            </div>
            <span
                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                {{ $product->prices->first()->duration ?? '1 Bulan' }}
            </span>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('product.show', $product->id) }}"
                class="text-white bg-primary w-full hover:bg-primary/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Mulai
            </a>
        </div>
    </div>
</div>
