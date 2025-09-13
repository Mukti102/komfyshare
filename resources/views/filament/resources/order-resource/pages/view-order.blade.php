<x-filament::page>
    <div class="space-y-6">
        <!-- Header Section -->
        <x-filament::section>
            <x-slot name="heading">
                Detail Order
            </x-slot>
            <x-slot name="description">
                Invoice #{{ $record->invoice }}
            </x-slot>
            <x-slot name="headerEnd">
                @if ($record->status == 'completed')
                    <x-filament::badge color="success" size="lg">
                        {{ ucfirst($record->status) }}
                    </x-filament::badge>
                @elseif ($record->status == 'pending')
                    <x-filament::badge color="warning" size="lg">
                        {{ ucfirst($record->status) }}
                    </x-filament::badge>
                @else
                    <x-filament::badge color="danger" size="lg">
                        {{ ucfirst($record->status) }}
                    </x-filament::badge>
                @endif
            </x-slot>
        </x-filament::section>

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer & Product Information -->
                <x-filament::section icon="heroicon-o-user-circle" icon-color="primary">
                    <x-slot name="heading">
                        Informasi Customer & Produk
                    </x-slot>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Customer Info -->
                        <div class="space-y-4">
                            <x-filament::card color="info">
                                <div class="p-4">
                                    <div class="flex gap-2 items-center space-x-3 mb-3">
                                        <x-filament::icon icon="heroicon-o-user" class="w-5 h-5 text-primary-600" />
                                        <h4 class="font-medium text-gray-900 dark:text-white">Customer</h4>
                                    </div>
                                    <p class="text-lg capitalize font-semibold text-gray-900 dark:text-white">
                                        {{ $record->costumer->name }}
                                    </p>
                                </div>
                            </x-filament::card>

                            <x-filament::card>
                                <div class="p-4">
                                    <div class="flex gap-2 items-center space-x-3 mb-3">
                                        <x-filament::icon icon="heroicon-o-cube" class="w-5 h-5 text-purple-600" />
                                        <h4 class="font-medium text-gray-900 dark:text-white">Produk</h4>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $record->product->title }}
                                    </p>
                                </div>
                            </x-filament::card>
                        </div>

                        <!-- Price & Duration -->
                        <div class="space-y-4">
                            <x-filament::card class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border-emerald-200 dark:border-emerald-700">
                                <div class="p-4">
                                    <div class="flex gap-2 items-center space-x-3 mb-3">
                                        <x-filament::icon icon="heroicon-o-banknotes" class="w-5 h-5 text-emerald-600" />
                                        <h4 class="font-medium text-emerald-900 dark:text-emerald-100">Total Harga</h4>
                                    </div>
                                    <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">
                                        Rp {{ number_format($record->amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </x-filament::card>

                            <x-filament::card>
                                <div class="p-4">
                                    <div class="flex gap-2 items-center space-x-3 mb-3">
                                        <x-filament::icon icon="heroicon-o-clock" class="w-5 h-5 text-orange-600" />
                                        <h4 class="font-medium text-gray-900 dark:text-white">Durasi</h4>
                                    </div>
                                    <div class="flex gap-2 items-center space-x-2">
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $record->productPrice->duration_day }}
                                        </p>
                                        <x-filament::badge color="gray">
                                            hari
                                        </x-filament::badge>
                                    </div>
                                </div>
                            </x-filament::card>
                        </div>
                    </div>
                </x-filament::section>

               
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Payment Method -->
                <x-filament::section icon="heroicon-o-credit-card" icon-color="info">
                    <x-slot name="heading">
                        Metode Pembayaran
                    </x-slot>

                    <x-filament::card>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Metode</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $record->paymentMethod->name }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $record->paymentMethod->logo) }}"
                                         alt="{{ $record->paymentMethod->name }}" 
                                         class="h-10 w-auto rounded-lg shadow-sm">
                                </div>
                            </div>
                        </div>
                    </x-filament::card>
                </x-filament::section>

                <!-- Timeline -->
                <x-filament::section icon="heroicon-o-calendar-days" icon-color="success">
                    <x-slot name="heading">
                        Periode Aktif
                    </x-slot>
                    <x-slot name="description">
                        Tanggal mulai dan berakhir layanan
                    </x-slot>

                    <div class="space-y-4  grid grid-cols-2 gap-2">
                        <x-filament::card class="bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-700">
                            <div class="p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="space-y-2">
                                         <x-filament::badge color="info">
                                            Tanggal Mulai
                                        </x-filament::badge>
                                        <p class="text-sm font-semibold text-green-900 dark:text-green-100">
                                            {{ $record->start_date->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </x-filament::card>

                        <x-filament::card>
                            <div class="p-4">
                                <div class="flex items-center space-x-3">
                                    <div  class="space-y-2">
                                        <x-filament::badge color="danger">
                                            Tanggal Berakhir
                                        </x-filament::badge>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $record->end_date ? $record->end_date->format('d M Y') : 'Tidak Ada' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </x-filament::card>
                    </div>
                </x-filament::section>

                <!-- Quick Stats -->
                <x-filament::section icon="heroicon-o-chart-bar" icon-color="warning">
                    <x-slot name="heading">
                        Ringkasan Order
                    </x-slot>

                    <x-filament::card class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 border-blue-200 dark:border-blue-700">
                        <div class="p-4 space-y-4">
                            <!-- Status -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Status:</span>
                                @if ($record->status == 'completed')
                                    <x-filament::badge color="success">
                                        {{ ucfirst($record->status) }}
                                    </x-filament::badge>
                                @elseif ($record->status == 'pending')
                                    <x-filament::badge color="warning">
                                        {{ ucfirst($record->status) }}
                                    </x-filament::badge>
                                @else
                                    <x-filament::badge color="danger">
                                        {{ ucfirst($record->status) }}
                                    </x-filament::badge>
                                @endif
                            </div>

                            <!-- Duration -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Durasi:</span>
                                <div class="flex items-center gap-2 space-x-2">
                                    <span class="text-sm font-semibold text-blue-900 dark:text-blue-100">
                                        {{ $record->productPrice->duration_day }}
                                    </span>
                                    <x-filament::badge color="gray" size="sm">
                                        hari
                                    </x-filament::badge>
                                </div>
                            </div>

                            <!-- Total Amount -->
                            <div class="flex items-center justify-between pt-2 border-t border-blue-200 dark:border-blue-700">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Total:</span>
                                <span class="text-lg font-bold text-blue-900 dark:text-blue-100">
                                    Rp {{ number_format($record->amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </x-filament::card>
                </x-filament::section>
                
                
                     <!-- Payment Response -->
                @if ($record->payment_data)
                <x-filament::section icon="heroicon-o-document-text" icon-color="warning">
                    <x-slot name="heading">
                        Response Payment
                    </x-slot>
                    <x-slot name="description">
                        Data respons dari payment gateway
                    </x-slot>

                    <x-filament::card class="bg-gray-900 dark:bg-gray-950 border-gray-700">
                        <div class="p-4">
                            <pre class="text-sm text-gray-100 dark:text-gray-300 whitespace-pre-wrap overflow-x-auto font-mono">{{ json_encode(json_decode($record->payment_data), JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </x-filament::card>
                </x-filament::section>
                @endif
                
            </div>
        </div>
    </div>
</x-filament::page>