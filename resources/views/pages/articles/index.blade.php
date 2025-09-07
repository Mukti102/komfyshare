@extends('layouts.guest')
@section('title', 'Article')
@section('content')
@php
    $firstArticle = $articles->first();
@endphp
    @livewire('hero-article',['article' => $firstArticle])
    <section id="articles" class="py-10 md:py-20 bg-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="relative max-w-md mx-auto mb-12 animate-slide-up">
                <input type="text" placeholder="Cari artikel inspiratif..."
                    class="w-full placeholder:text-sm placeholder:md:text-base px-4 md:px-6 py-3 md:py-4 rounded-full border-2 border-white bg-white/80 backdrop-blur-sm shadow-lg focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                    id="searchInput">
                <button
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary text-white p-2 rounded-full hover:shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="articlesGrid">
                @foreach ($articles as $article)
                    <x-card-article :article="$article"  />
                @endforeach
            </div>

            <!-- Load More Button -->
            {{-- <div class="text-center mt-12">
                <button id="loadMoreBtn"
                    class="bg-primary shadow-sm text-white px-8 py-4 rounded-full font-medium hover:shadow-lg transform hover:scale-105 transition-all">
                    Lihat Artikel Lainnya
                </button>

            </div> --}}
        </div>
    </section>
@endsection
