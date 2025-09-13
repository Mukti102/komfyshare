<div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Status</h3>
    <div class="">
        <div wire:loading.remove wire:target="checkStatus" class="flex items-center gap-3">
            @if ($status == 'Unpaid')
            <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
            <span class="text-yellow-600 font-medium">{{ 'Belum Bayar' }}</span>
            @elseif ($status == 'Completed')
            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-green-600 font-medium">{{ 'Sudah Bayar' }}</span>
            @else
            <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
            <span class="text-yellow-600 font-medium">{{ 'Waiting for Payment' }}</span>
            @endif
        </div>
        <div wire:loading wire:target="checkStatus" class="animate-pulse">
            Mengecek...
        </div>
    </div>
    <div class="mt-4 pt-4 border-t border-gray-100">
        <button wire:click="checkStatus"
            class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">

            <!-- Ikon default -->
            <svg wire:loading.remove wire:target="checkStatus" class="w-4 h-4" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                </path>
            </svg>

            <!-- Ikon loading -->
            <svg wire:loading wire:target="checkStatus" class="w-4 animate-spin h-4" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                </path>
            </svg>
            <span wire:loading.remove wire:target="checkStatus">
                Check Status
            </span>
            <span wire:loading wire:target="checkStatus">
                Check Status...
            </span>
        </button>
    </div>
</div>
