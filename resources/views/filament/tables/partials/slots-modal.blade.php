<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-300">ID</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-300">Nama Group</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-300">Nama Costumer</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @php
            $group = $slots->first()?->group; // ambil group dari slot pertama
            $maxSlot = $group?->max_slot ?? 5; // default 5 kalau kosong
            $slotCount = $slots->count();
        @endphp

        {{-- Tampilkan slot yang ada --}}
        @foreach ($slots as $slot)
            <tr>
                <td class="px-4 py-2 text-sm text-green-400">{{ $slot->id }}</td>
                <td class="px-4 py-2 text-sm text-green-400">{{ $slot->group->name }}</td>
                <td class="px-4 py-2 text-sm text-green-400">{{ $slot->costumer->name }}</td>
            </tr>
        @endforeach

        {{-- Tampilkan baris "Tersedia" untuk slot kosong --}}
        @for ($i = $slotCount; $i < $maxSlot; $i++)
            <tr class="bg-green-50">
                <td class="px-4 py-2 text-sm text-gray-500">-</td>
                <td class="px-4 py-2 text-sm text-gray-500">{{ $group?->name ?? '-' }}</td>
                <td class="px-4 py-2 text-sm text-gray-500">Tersedia</td>
            </tr>
        @endfor
    </tbody>
</table>
