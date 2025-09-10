<x-filament::page>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Slots untuk Group: {{ $record->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola slot pelanggan untuk grup ini
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <x-filament::button color="success" icon="heroicon-o-plus" size="sm" x-data=""
                    x-on:click="$dispatch('open-modal', {id: 'create-slot-modal'})">
                    Tambah Slot
                </x-filament::button>

                <x-filament::button color="gray" icon="heroicon-o-arrow-left" size="sm"
                    href="{{ route('filament.admin.resources.groups.index') }}">
                    Kembali
                </x-filament::button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $maxSlot = $record->max_slot ?? 5;
                $slotCount = $record->slots->count();
                $availableSlots = $maxSlot - $slotCount;
                $occupancyRate = $maxSlot > 0 ? round(($slotCount / $maxSlot) * 100) : 0;
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-user-group class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Slot</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $maxSlot }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-users class="w-5 h-5 text-green-600 dark:text-green-400" />
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Terisi</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $slotCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 bg-orange-100 dark:bg-orange-900/50 rounded-lg flex items-center justify-center">
                            <x-heroicon-o-clock class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tersedia</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $availableSlots }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slots Table -->
        <div class="overflow-hidden rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
            <div class="bg-white dark:bg-gray-800">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                #
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Slot ID
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nama Customer
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tanggal Bergabung
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Slot terisi --}}
                        @foreach ($record->slots as $index => $slot)
                            <tr class=" transition-colors">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-gray-100">#{{ $slot->id }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $slot->costumer->name }}
                                            </div>
                                            @if ($slot->costumer->email)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $slot->costumer->email }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-filament::badge icon="heroicon-s-check-circle" color="success">
                                        Aktif
                                    </x-filament::badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $slot->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center gap-2 justify-end space-x-2">
                                        <x-filament::button color="warning" icon="heroicon-o-pencil" size="xs"
                                            wire:click="loadEditSlot({{ $slot->id }})"
                                            x-on:click="$dispatch('open-modal', {id: 'edit-slot-modal'})">
                                            Edit
                                        </x-filament::button>

                                        <x-filament::button color="danger" icon="heroicon-o-trash" size="xs"
                                            x-data=""
                                            x-on:click="$dispatch('open-modal', {id: 'delete-slot-modal', slotId: {{ $slot->id }}, customerName: '{{ $slot->costumer->name }}'})">
                                            Hapus
                                        </x-filament::button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Slot kosong --}}
                        @for ($i = $slotCount; $i < $maxSlot; $i++)
                            <tr class="bg-gray-50/50 dark:bg-gray-900/50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">
                                    {{ $i + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full mr-2"></div>
                                        <span class="text-sm text-gray-400">-</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    <div class="flex gap-1 items-center">
                                        <div
                                            class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mr-3">
                                            <x-heroicon-o-user class="w-4 h-4 text-gray-400" />
                                        </div>
                                        <span>Slot Tersedia</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 gap-1 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                        <x-heroicon-s-minus-circle class="w-3 h-3 mr-1" />
                                        <span>
                                            Kosong
                                        </span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">-</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <x-filament::button color="success" icon="heroicon-o-plus" size="xs"
                                        x-data=""
                                        x-on:click="$dispatch('open-modal', {id: 'create-slot-modal'})">
                                        Isi Slot
                                    </x-filament::button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Slot Modal --}}
    <x-filament::modal id="create-slot-modal" width="2xl">
        <x-slot name="heading">
            <div class="flex items-center">
                <x-heroicon-o-plus class="w-5 h-5 mr-2 text-green-500" />
                Tambah Slot Baru
            </div>
        </x-slot>

        <form wire:submit.prevent="createSlot" class="space-y-6">
            <div>
                <label for="customer_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Pilih Customer <span class="text-red-500">*</span>
                </label>
                <select id="customer_select" name="customer_id" wire:model.defer="selectedCustomerId"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors duration-200"
                    required>
                    <option class="text-white dark:text-white" value="">-- Pilih Customer --</option>
                    {{-- You'll need to add this property to your Livewire component --}}
                    @foreach ($customers as $customer)
                        <option class="text-white dark:text-white" value="{{ $customer->id }}">{{ $customer->name }}
                            ({{ $customer->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="order_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Pilih Customer <span class="text-red-500">*</span>
                </label>
                <select id="order_select" name="order_id" wire:model.defer="selectedOrderId"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors duration-200"
                    required>
                    <option class="text-white dark:text-white" value="">-- Pilih Invoice --</option>
                    {{-- You'll need to add this property to your Livewire component --}}
                    @foreach ($orders as $order)
                        <option class="text-white dark:text-white" value="{{ $order->id }}">{{ $order->invoice }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Catatan (Opsional)
                </label>
                <textarea id="notes" wire:model.defer="slotNotes" rows="3"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors duration-200 resize-none"
                    placeholder="Tambahkan catatan untuk slot ini..."></textarea>
            </div>

            <div class="flex justify-end space-x-3 gap-2 pt-4 border-t border-gray-200 dark:border-gray-600">
                <x-filament::button color="gray" x-on:click="$dispatch('close-modal', {id: 'create-slot-modal'})">
                    Batal
                </x-filament::button>
                <x-filament::button type="submit" color="success" icon="heroicon-o-check"
                    wire:loading.attr="disabled" wire:target="createSlot">
                    <span wire:loading.remove wire:target="createSlot">Simpan Slot</span>
                    <span wire:loading wire:target="createSlot">Menyimpan...</span>
                </x-filament::button>
            </div>
        </form>
    </x-filament::modal>

    {{-- Edit Slot Modal --}}
    <x-filament::modal id="edit-slot-modal" width="2xl">
        <x-slot name="heading">
            <div class="flex items-center">
                <x-heroicon-o-pencil class="w-5 h-5 mr-2 text-orange-500" />
                Edit Slot
            </div>
        </x-slot>

        <form wire:submit.prevent="updateSlot" class="space-y-6">
            <div>
                <label for="edit_customer_select"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Pilih Customer <span class="text-red-500">*</span>
                </label>
                <select id="edit_customer_select" wire:model.defer="editCustomerId"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors duration-200"
                    required>
                    <option class="text-white dark:text-white" value="">-- Pilih Customer --</option>
                    {{-- You'll need to add this property to your Livewire component --}}
                    @foreach ($customers as $customer)
                        <option {{ $editCustomerId == $customer->id ? 'selected' : '' }}
                            value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="order_select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Pilih Customer <span class="text-red-500">*</span>
                </label>
                <select id="order_select" name="order_id" wire:model.defer="selectedOrderId"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors duration-200"
                    required>
                    <option class="text-white dark:text-white" value="">-- Pilih Invoice --</option>
                    {{-- You'll need to add this property to your Livewire component --}}
                    @foreach ($orders as $order)
                        <option {{$selectedOrderId == $order->id ? 'selected' : ''}} class="text-white dark:text-white" value="{{ $order->id }}">{{ $order->invoice }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="edit_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Catatan
                </label>
                <textarea id="edit_notes" wire:model.defer="editSlotNotes" rows="3"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors duration-200 resize-none"
                    placeholder="Catatan untuk slot ini..."></textarea>
            </div>

            <div class="flex justify-end space-x-3 gap-2 pt-4 border-t border-gray-200 dark:border-gray-600">
                <x-filament::button color="gray" x-on:click="$dispatch('close-modal', {id: 'edit-slot-modal'})">
                    Batal
                </x-filament::button>
                <x-filament::button type="submit" color="warning" icon="heroicon-o-check"
                    wire:loading.attr="disabled" wire:target="updateSlot">
                    <span wire:loading.remove wire:target="updateSlot">Update Slot</span>
                    <span wire:loading wire:target="updateSlot">Mengupdate...</span>
                </x-filament::button>
            </div>
        </form>
    </x-filament::modal>

    {{-- Delete Slot Modal --}}
    <x-filament::modal id="delete-slot-modal" width="lg">
        <x-slot name="heading">
            <div class="flex items-center">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5 mr-2 text-red-500" />
                Konfirmasi Hapus Slot
            </div>
        </x-slot>

        <div class="space-y-4">
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-red-400 mr-3 mt-0.5 flex-shrink-0" />
                    <div>
                        <h4 class="text-sm font-medium text-red-800 dark:text-red-400">
                            Peringatan!
                        </h4>
                        <p class="mt-1 text-sm text-red-700 dark:text-red-300">
                            Tindakan ini akan menghapus slot dan tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
            </div>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Anda yakin ingin menghapus slot untuk customer:
                <strong class="text-gray-900 dark:text-gray-100" x-text="$store.modal.customerName"></strong>?
            </p>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                <x-filament::button color="gray" x-on:click="$dispatch('close-modal', {id: 'delete-slot-modal'})">
                    Batal
                </x-filament::button>
                <x-filament::button color="danger" icon="heroicon-o-trash" wire:loading.attr="disabled"
                    wire:target="deleteSlot"
                    x-on:click="$wire.deleteSlot($store.modal.slotId); $dispatch('close-modal', {id: 'delete-slot-modal'})">
                    <span wire:loading.remove wire:target="deleteSlot">Hapus Slot</span>
                    <span wire:loading wire:target="deleteSlot">Menghapus...</span>
                </x-filament::button>
            </div>
        </div>
    </x-filament::modal>

    {{-- Alpine.js Store for Modal Data --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('modal', {
                slotId: null,
                customerName: '',

                setSlotData(data) {
                    this.slotId = data.slotId || null;
                    this.customerName = data.customerName || '';
                }
            });
        });

        // Listen for modal events
        document.addEventListener('open-modal', (event) => {
            if (event.detail.slotId) {
                Alpine.store('modal').setSlotData(event.detail);
            }
        });
    </script>
</x-filament::page>
