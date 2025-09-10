<div class="md:w-full w-[80%] mx-auto bg-white rounded-xl shadow-sm relative flex flex-col">
    <!-- Discount Ribbon -->
    @if ($product->discount > 0)
        <div class="absolute top-2 right-2 z-10">
            <div class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-tl-lg rounded-br-lg shadow-lg">
                <div class="flex flex-col items-center leading-tight">
                    <span class="text-sm font-black">{{ $product->discount }}%</span>
                    <span class="text-[10px] font-medium">OFF</span>
                </div>
            </div>
            <div class="absolute -left-1 bottom-0 w-0 h-0 border-r-[4px] border-r-red-800 border-b-[8px] border-b-transparent"></div>
        </div>
    @endif

    <!-- Gambar -->
    <a href="{{ route('product.show', $product->id) }}" class="block w-full max-h-44 overflow-hidden rounded-t-lg">
        <img class="w-full h-44 object-cover object-center"
             src="{{ asset('storage/' . $product->image) }}"
             alt="{{ $product->name ?? 'Product image' }}" />
    </a>

    <!-- Konten -->
    <div class="px-3 py-4 flex flex-col flex-1">
        <!-- Judul -->
        <a href="{{ route('product.show', $product->id) }}">
            <h5 class="text-xl font-black tracking-tight text-gray-900 line-clamp-2">
                {{ $product->title ?? 'Nama Produk' }}
            </h5>
        </a>

        <!-- Subtitle + Harga -->
        <div class="mt-2 flex-1">
            <a href="{{ route('product.show', $product->id) }}">
                <p class="text-base font-semibold tracking-tight text-gray-700 line-clamp-2">
                    {{ $product->subtitle ?? 'Keterangan Produk' }}
                </p>
            </a>

            @php
                $price = $product->prices->first()?->price ?? 0;
                $discount = $product->discount ?? 0;
                $finalPrice = $price - ($price * $discount) / 100;
            @endphp

            <div class="flex md:flex-row flex-col items-start  md:items-center justify-between mt-3">
                <div class="flex md:order-1 order-2 gap-2 items-center text-gray-900">
                    @if ($discount > 0)
                        <span class="text-xs line-through font-bold text-gray-600 dark:text-gray-600">
                            Rp.{{ number_format($price ?? 0, 0, ',', '.') }}
                        </span>
                    @endif
                    <span class="font-bold text-lg {{ $discount > 0 ? 'text-red-600' : 'text-gray-900' }}">
                        Rp.{{ number_format($finalPrice ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                <span class="bg-blue-100 md:order-2 order-1 text-blue-700 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-100">
                    {{ $product->prices->first()->duration ?? '1 Bulan' }}
                </span>
            </div>
        </div>

        <!-- Tombol -->
        <div class="mt-4">
            <a href="{{ route('product.show', $product->id) }}"
               class="block w-full text-white bg-primary hover:bg-primary/80 focus:ring-4 focus:outline-none focus:ring-blue-300 text-xl font-bold rounded-xl text-sm px-5 py-3 text-center">
                Mulai
            </a>
        </div>
    </div>
</div>
