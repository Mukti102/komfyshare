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
                         <div class="mt-8 pt-8 border-t border-gray-600">
                             <h4 class="text-sm font-semibold text-gray-100 mb-4">Bagikan artikel ini:</h4>
                             <div class="flex flex-wrap gap-3 md:space-x-4">
                                 <button
                                     class="share-button text-sm md:text-base bg-blue-600 text-white md:px-6 md:py-3 px-3 py-1.5 rounded-lg flex items-center space-x-2 hover:bg-blue-700">
                                     <svg class="md:w-5 md:h-5 w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                         <path
                                             d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                     </svg>
                                     <span>Twitter</span>
                                 </button>
                                 <button
                                     class="share-button text-sm md:text-base bg-blue-800 text-white md:px-6 md:py-3 px-3 py-1.5 rounded-lg flex items-center space-x-2 hover:bg-blue-900">
                                     <svg class="md:w-5 md:h-5 w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                         <path
                                             d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                                     </svg>
                                     <span>Facebook</span>
                                 </button>
                                 <button
                                     class="share-button text-sm md:text-base bg-green-600 text-white md:px-6 md:py-3 px-3 py-1.5 rounded-lg flex items-center space-x-2 hover:bg-green-700">
                                     <svg class="md:w-5 md:h-5 w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                         <path
                                             d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                     </svg>
                                     <span>WhatsApp</span>
                                 </button>
                                 <button id="copyLink"
                                     class="share-button text-sm md:text-base bg-gray-600 text-white md:px-6 md:py-3 px-3 py-1.5 rounded-lg flex items-center space-x-2 hover:bg-gray-700">
                                     <svg class="md:w-5 md:h-5 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                         </path>
                                     </svg>
                                     <span>Salin Link</span>
                                 </button>
                             </div>
                         </div>
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
