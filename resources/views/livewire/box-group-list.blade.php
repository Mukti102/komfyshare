<div
    class="bg-gray-50 backdrop-blur-xl border-2 border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 hover:shadow-primary/20 transition-all duration-500 group overflow-hidden relative">

    <div class="p-8 text-center border-b border-primary/30">
        <div
            class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-primary/50 group-hover:shadow-primary/80 group-hover:scale-110 transition-all duration-300">
            <i class="fa-solid fa-people-group text-gray-100 text-2xl"></i>
        </div>
        <h2
            class="text-3xl lg:text-2xl font-black text-gray-900  group-hover:text-primary-light transition-colors duration-300">
            Nextflix Group List
        </h2>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading wire:target="loadGroups" class="absolute inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="text-gray-900 text-lg font-bold animate-pulse">Loading...</div>
    </div>

    <div class="p-6 overflow-y-auto space-y-4 max-h-80 custom-scroll">
        @forelse ($groups as $group)
            <div class="w-full border border-gray-300 p-3 rounded-lg">
                <div class="space-y-2">
                    <h3 class="text-base text-gray-900 font-semibold mb-1">{{ $group->name }}</h3>
                    @php
                        $isFull = $group->slots->count() == (float) $group->max_slot;
                    @endphp
                    <span
                        class="{{ $isFull ? 'text-red-100 bg-red-700' : 'text-green-100 bg-green-700' }} text-[11px] font-medium me-2 px-2 py-0.5 rounded-full ">{{ $isFull ? 'Penuh' : 'Tersedia' }}</span>
                </div>
                @php
                    $maxSlot = $group?->max_slot ?? 5;
                    $slotCount = $group->slots->count();
                @endphp
                <ol class="list-decimal mt-3 text-sm list-inside capitalize space-y-2">
                    @foreach ($group->slots ?? [] as $slot)
                        <li
                            class="flex items-center justify-between px-3 py-1 bg-green-700 dark:bg-green-600 rounded-lg">
                            <span class="font-medium text-gray-100">{{ optional($slot->costumer)->name ?? '-' }}</span>
                            <span class="text-green-100 text-xs font-semibold">Terisi</span>
                        </li>
                    @endforeach

                    @for ($i = $slotCount; $i < $maxSlot; $i++)
                        <li
                            class="flex items-center justify-between px-3 py-1 bg-gray-300 dark:bg-gray-300 rounded-lg">
                            <span class="font-medium text-gray-500 dark:text-gray-500">- Tersedia -</span>
                            <span class="text-gray-500 text-xs italic">Kosong</span>
                        </li>
                    @endfor
                </ol>
            </div>
        @empty
            <h1 class="text-center text-gray-700">Tidak Ada Group</h1>
        @endforelse
    </div>

    <div class="p-4">
        <a href="/groups"
            
            class="w-full flex text-center justify-center bg-primary text-gray-100 font-bold px-6 py-4 rounded-2xl hover:bg-primary/80 focus:ring-4 focus:outline-none focus:ring-primary/30 transition-all duration-300 text-lg">
            Lihat Detail
        </a>
    </div>
</div>
