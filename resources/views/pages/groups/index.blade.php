@extends('layouts.guest')

@section('title', 'Group Detail')

@section('content')
    <section class="min-h-screen bg-dark py-12">
        <div class="mx-auto px-5 md:px-20 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="md:text-3xl text-2xl font-bold text-slate-100 mb-2">Product Groups</h1>
                <p class="text-slate-300 text-sm md:text-base">Pilih produk untuk melihat grup yang tersedia</p>
            </div>

            <!-- Product Selector -->
            <div class="mb-8">
                <div class="bg-gray-100 backdrop-blur-sm border border-white/10 rounded-xl p-6 shadow-xl">
                    <label class="block text-sm font-medium text-slate-600 mb-3">
                        <i class="fas fa-box-open mr-2"></i>Pilih Produk
                    </label>
                    <form action="{{ route('groups.index') }}" method="GET" class="w-full">
                        <div class="relative">
                            <select name="product_id" onchange="this.form.submit()"
                                class="w-full md:w-96 bg-black/10 border border-black/30 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 ">
                                <option value="" class="bg-slate-800 text-slate-600">-- Pilih Produk --</option>
                                @foreach ($products as $prod)
                                    <option value="{{ $prod->id }}" class="bg-slate-00 text-slate-500"
                                        {{ $product && $product->id == $prod->id ? 'selected' : '' }}>
                                        {{ $prod->title }}
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>
                    </form>
                </div>
            </div>

            <!-- Groups Grid -->
            @if ($product)
                <div class="mb-6">
                    <div class="flex  items-center justify-between mb-6">
                        <h2 class="md:text-2xl text-lg font-semibold text-slate-100">
                            Grup untuk: <span class="text-primary">{{ $product->title }}</span>
                        </h2>
                        <div class="flex items-center space-x-4 text-xs  md:text-sm text-slate-300">
                            <div class="flex items-center ">
                                <div class="md:w-3 md:h-3 w-2 h-2 bg-green-900 rounded-full mr-2"></div>
                                <span>Tersedia</span>
                            </div>
                            <div class="flex items-center">
                                <div class="md:w-3 md:h-3 w-2 h-2 bg-red-800 rounded-full mr-2"></div>
                                <span>Penuh</span>
                            </div>
                        </div>
                    </div>

                    @forelse ($product->groups as $group)
                        @php
                            $isFull = $group->slots->count() == (float) $group->max_slot;
                            $maxSlot = $group?->max_slot ?? 5;
                            $slotCount = $group->slots->count();
                            $availableSlots = $maxSlot - $slotCount;
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4  gap-6 mb-6">
                            <div
                                class="group bg-gray-200 backdrop-blur-sm border border-white/10 rounded-xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                                <!-- Group Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold text-slate-900 truncate">{{ $group->name }}</h3>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-slate-800">{{ $slotCount }}/{{ $maxSlot }}</span>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="mb-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $isFull ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 'bg-green-400/20 text-green-700 border border-green-500/30' }}">
                                        <div
                                            class="w-2 h-2 rounded-full mr-2 {{ $isFull ? 'bg-red-400' : 'bg-green-500' }}">
                                        </div>
                                        {{ $isFull ? 'Penuh' : $availableSlots . ' Slot Tersedia' }}
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs text-slate-900 mb-1">
                                        <span>Kapasitas</span>
                                        <span>{{ round(($slotCount / $maxSlot) * 100) }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-500 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500 {{ $isFull ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-green-500 to-green-600' }}"
                                            style="width: {{ ($slotCount / $maxSlot) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Slots List -->
                                <div class="space-y-2">
                                    <h4 class="text-sm font-medium text-slate-600 mb-3 flex items-center">
                                        <i class="fas fa-users mr-2"></i>Anggota Grup
                                    </h4>

                                    <div
                                        class="max-h-40 overflow-y-auto space-y-2 scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-800">
                                        @foreach ($group->slots ?? [] as $index => $slot)
                                            <div
                                                class="flex items-center justify-between p-3 bg-gradient-to-r from-green-500/10 to-green-600/10 border border-green-500/40 rounded-lg backdrop-blur-sm">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-slate-900 text-xs font-bold">
                                                        {{ $index + 1 }}
                                                    </div>
                                                    <span
                                                        class="font-medium text-green-800">{{ optional($slot->costumer)->name ?? '-' }}</span>
                                                </div>
                                                <span
                                                    class="text-slate-100 text-xs font-semibold bg-green-500 px-2 py-1 rounded-full">
                                                    <i class="fas fa-check mr-1"></i>Terisi
                                                </span>
                                            </div>
                                        @endforeach

                                        @for ($i = $slotCount; $i < $maxSlot; $i++)
                                            <div
                                                class="flex items-center justify-between p-3 bg-slate-400/50 border border-slate-600/50 rounded-lg backdrop-blur-sm">
                                                <div class="flex items-center space-x-3">
                                                    <div
                                                        class="w-8 h-8 bg-slate-400 rounded-full flex items-center justify-center text-slate-700 text-xs font-bold">
                                                        {{ $i + 1 }}
                                                    </div>
                                                    <span class="font-medium text-slate-500">Slot Kosong</span>
                                                </div>
                                                <span
                                                    class="text-slate-700 text-xs italic bg-slate-600/20 px-2 py-1 rounded-full">
                                                    <i class="fas fa-plus mr-1"></i>Tersedia
                                                </span>
                                            </div>
                                        @endfor
                                    </div>
                                </div>


                                <!-- Group Actions -->
                                <div class="mt-4 pt-4 border-t border-slate-600/50">
                                    @if (!$isFull)
                                        <a href="{{ route('product.show', $group->product->id) }}"
                                            class="w-full flex justify-center bg-primary hover:bg-primary/80 text-slate-100 font-medium py-3 px-4 rounded-lg transition-all duration-200 transform  shadow-lg">
                                            <div class="flex gap-1 items-center">
                                                <i class="fas fa-user-plus mr-2"></i>
                                                <span>
                                                    Bergabung Grup
                                                </span>
                                            </div>
                                        </a>
                                    @else
                                        <button disabled
                                            class="w-full bg-slate-500 text-slate-700 font-medium py-2 px-4 rounded-lg cursor-not-allowed">
                                            <i class="fas fa-lock mr-2"></i>Grup Penuh
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="max-w-md mx-auto">
                                <div
                                    class="w-24 h-24 bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-users text-3xl text-slate-700"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum Ada Grup</h3>
                                <p class="text-slate-700 mb-6">Produk ini belum memiliki grup yang tersedia. Periksa kembali
                                    nanti atau hubungi admin.</p>
                                <button
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-slate-900 font-medium py-2 px-6 rounded-lg transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-plus mr-2"></i>Buat Grup Baru
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            @else
                <!-- No Product Selected State -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-box-open text-3xl text-slate-700"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">Pilih Produk</h3>
                        <p class="text-slate-700">Silakan pilih produk dari dropdown di atas untuk melihat grup yang
                            tersedia.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        /* Custom scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.3);
            border-radius: 2px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(71, 85, 105, 0.8);
            border-radius: 2px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(71, 85, 105, 1);
        }

        /* Hover animations */
        .group:hover .fas {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Loading animation for form submission */
        select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    @push('scripts')
        <script>
            // Add loading state for form submission
            document.addEventListener('DOMContentLoaded', function() {
                const selectElement = document.querySelector('select[name="product_id"]');

                selectElement.addEventListener('change', function() {
                    if (this.value) {
                        // Add loading state
                        const loadingDiv = document.createElement('div');
                        loadingDiv.className =
                        'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
                        loadingDiv.innerHTML = `
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-white mx-auto mb-4"></div>
                        <p class="text-slate-900">Memuat grup...</p>
                    </div>
                `;
                        document.body.appendChild(loadingDiv);
                    }
                });
            });

            // Add smooth scroll animation for new content
            function animateNewContent() {
                const groups = document.querySelectorAll('.group');
                groups.forEach((group, index) => {
                    group.style.opacity = '0';
                    group.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        group.style.transition = 'all 0.5s ease';
                        group.style.opacity = '1';
                        group.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }

            // Call animation on page load
            document.addEventListener('DOMContentLoaded', animateNewContent);
        </script>
    @endpush
@endsection
