<a href="{{route('article.show', $article->slug)}}">
    <!-- Article 1 -->
    <article class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover group">
        <div class="h-52 bg-primary relative overflow-hidden">
            <img src="{{asset('storage/'.$article->thumbnail)}}" class="w-full h-full object-cover" alt="">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute bottom-4 left-4 right-4">
                <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
                    Category
                </span>
            </div>
        </div>
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">
                {{ $article->title }}
            </h3>
            @php
                use Illuminate\Support\Str;
            @endphp

            <p class="text-gray-600 mb-4">
                {!! Str::limit(strip_tags($article->content), 100) !!}
            </p>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-primary to-pink-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold">G</span>
                    </div>
                    <div class="text-sm">
                        <div class="font-medium text-gray-900">Admin</div>
                        <div class="text-gray-500">
                            {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
                <button class="text-primary hover:text-blue-700 font-medium text-sm flex items-center space-x-1">
                    <span>Baca</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </article>
</a>
