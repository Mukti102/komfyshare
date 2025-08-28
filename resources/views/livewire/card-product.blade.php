
<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <a href="#">
        <img class="p-8 rounded-t-lg" src="https://flowbite.com/docs/images/products/apple-watch.png"
            alt="product image" />
    </a>
    <div class="px-5 pb-5">
        <a href="#">
            <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Disney+ HotStar</h5>
        </a>
        <a href="#">
            <p class="text-base font-semibold tracking-tight text-gray-700 dark:text-white">Disney+ HotStar</p>
        </a>
        <div class="flex items-center justify-between mt-2.5 mb-5">
            <div class="flex gap-2 items-center space-x-1 text-gray-900 rtl:space-x-reverse">
                <span class="text-xs line-through text-gray-500 dark:text-gray-400">
                    Rp.15.000
                </span>
                <span class="font-bold text-lg text-red-600">
                    Rp.75.000
                </span>
            </div>
            <span
                class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">1
                Bulan</span>
        </div>
        <div class="flex items-center justify-between">
            <a href="{{ route('product.show', $product->id) }}"
                class="text-white bg-primary w-full hover:bg-primary/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Mulai</a>
        </div>
    </div>
</div>
