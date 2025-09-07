 @php
     use Illuminate\Support\Str;
 @endphp

 @push('style')
     <style>
         @keyframes fadeIn {
             from {
                 opacity: 0;
             }

             to {
                 opacity: 1;
             }
         }

         @keyframes slideUp {
             from {
                 opacity: 0;
                 transform: translateY(30px);
             }

             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         @keyframes zoomIn {
             from {
                 opacity: 0;
                 transform: scale(0.95);
             }

             to {
                 opacity: 1;
                 transform: scale(1);
             }
         }

         .glass-effect {
             background: rgba(255, 255, 255, 0.1);
             backdrop-filter: blur(10px);
             border: 1px solid rgba(255, 255, 255, 0.2);
         }

         .article-content p {
             margin-bottom: 1.5rem;
             line-height: 1.8;
         }

         .article-content h2 {
             font-size: 1.5rem;
             font-weight: 700;
             margin: 2rem 0 1rem 0;
             color: #1f2937;
         }

         .article-content h3 {
             font-size: 1.25rem;
             font-weight: 600;
             margin: 1.5rem 0 0.75rem 0;
             color: #374151;
         }

         .article-content blockquote {
             border-left: 4px solid #3b82f6;
             padding-left: 1.5rem;
             margin: 2rem 0;
             font-style: italic;
             color: #4b5563;
             background: #f8fafc;
             padding: 1.5rem;
             border-radius: 0.5rem;
         }

         .share-button text-sm md:text-base {
             transition: all 0.3s ease;
         }

         .share-button text-sm md:text-base:hover {
             transform: translateY(-2px);
             box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
         }
     </style>
 @endpush
 @extends('layouts.guest')
 @section('title', $article->title)
 @section('content')
     <!-- Main Content -->
     <main class="max-w-8xl  mx-auto px-1 bg-dark sm:px-6 lg:px-8 py-20">
         <div class="grid grid-cols-1  lg:grid-cols-3 gap-5">
             <!-- Article Content -->
             <div class="lg:col-span-2 ">
                 <!-- Article Header -->
                 <article class=" bg-secondary p-0 rounded-2xl shadow-lg overflow-hidden">
                     <!-- Category Badge -->
                     <div class="md:px-8 px-4 pt-8 pb-4">
                         <div class="flex items-center space-x-4 mb-6">
                             <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">
                                 {{-- {{ $article->category->title }} --}}
                             </span>
                         </div>

                         <!-- Title -->
                         <h1 class="text-3xl md:text-4xl font-bold text-gray-50 mb-6 leading-tight">
                             {{ $article->title }}
                         </h1>

                         <!-- Author Info -->
                         <div class="flex items-center justify-between border-b border-gray-600 pb-6 mb-8">
                             <div class="flex items-center space-x-4">
                                 <div
                                     class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                     <span class="text-white font-bold">G</span>
                                 </div>
                                 <div>
                                     <div class="font-semibold text-gray-100">Admin</div>
                                 </div>
                             </div>
                             <div class="text-right">
                                 <div class="text-sm text-gray-200">
                                     {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}</div>
                             </div>
                         </div>
                     </div>

                     <!-- Featured Image -->
                     <div class="md:px-8 px-4 mb-8">
                         <div class="relative rounded-xl overflow-hidden">
                             <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                 alt="Seseorang sedang berbicara di podium" class="w-full h-64 md:h-80 object-cover">
                             <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                         </div>
                     </div>

                     <!-- Article Content -->
                     <div class="md:px-8 px-4 pb-8">
                         <div class="article-content text-gray-100 text-lg leading-relaxed">
                             {!! $article->content !!}
                         </div>

                         <!-- Tags -->
                         <div class="mt-12 pt-8 border-t border-gray-600">
                             <h4 class="text-sm font-semibold text-gray-100 mb-4">Tags:</h4>
                             <div class="flex flex-wrap gap-2">
                                 @foreach ($article->tags as $tag)
                                     <span
                                         class="bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-sm">{{ $tag }}</span>
                                 @endforeach
                             </div>
                         </div>

                         <!-- Share Buttons -->
                        <x-share-buttons/>
                     </div>
                 </article>
             </div>

             <!-- Sidebar -->
             <div class="lg:col-span-1">
                 <!-- Related Articles -->
                 <div class="bg-secondary rounded-2xl shadow-lg p-6 mb-8 animate-slide-up">
                     <h3 class="text-xl font-bold text-gray-100 mb-6 flex items-center">
                         <span class="text-gray-100">Majalah
                             Lainnya...</span>
                     </h3>

                     <div class="space-y-6">
                         @forelse ($others as $item)
                             <!-- Related Article 1 -->
                             <article  class="group cursor-pointer">
                                 <a href="{{route('article.show',$item->slug)}}" class="flex space-x-4">
                                     <div
                                         class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex-shrink-0 overflow-hidden">
                                         <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Article thumbnail"
                                             class="w-full h-full object-cover">
                                     </div>
                                     <div class="flex-1 min-w-0">
                                         <h4
                                             class="font-semibold text-gray-100 group-hover:text-green-600 transition-colors leading-tight mb-2">
                                             {{ $item->title }}
                                         </h4>

                                         <p class="text-sm text-gray-400 mb-2">
                                             {!! Str::limit(strip_tags($item->content), 100) !!}

                                         </p>
                                         <div class="text-xs text-gray-300">
                                             {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                         </div>
                                     </div>
                                 </a>
                             </article>
                         @empty
                             <h1 class="text-gray-500 text-center">Tidak Ada Artikel</h1>
                         @endforelse
                     </div>
                 </div>
             </div>
         </div>
     </main>
 @endsection
