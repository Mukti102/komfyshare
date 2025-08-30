@push('styles')
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css');

        .details-arrow {
            transition: transform 0.2s ease;
        }

        details[open] .details-arrow {
            transform: rotate(45deg);
        }

        .nav-button {
            transition: all 0.2s ease;
        }

        .nav-button:hover {
            transform: translateY(-1px);
        }

        .indicator-dot {
            transition: all 0.3s ease;
        }
    </style>
@endpush
<div class="relative py-40 md:py-40  overflow-hidden">
    {{-- Left Decoration --}}
    <div class="absolute  md:block md:scale-110 md:-left-52 -left-32 top-5 md:top-20 z-10">
        <img src="https://framerusercontent.com/images/3uVPAqMRqV6jKuatzLLj3Z9bNnQ.png" alt=""
            class="w-[60%] md:w-full h-full object-cover">
    </div>

    {{-- Right Decoration --}}
    <div class="absolute  md:block md:scale-110 -right-32 md:right-0 md:top-20 top-5 z-10">
        <img src="{{ asset('assets/right.png') }}" class="w-[50%] md:w-full h-full object-cover" alt="">
    </div>

    {{-- Content --}}
    <div class="relative z-50 max-w-4xl w-[90%] mx-auto text-center">
        <h1 class="font-bold text-3xl  md:text-6xl leading-snug text-gray-800">
            Yuk, Kenali KomfyShare <br class="hidden md:block" /> Lebih Dekat!
        </h1>

        <div class="mx-auto mt-10 md:mt-16 rounded-3xl bg-white/90 backdrop-blur-md p-6 md:p-10 shadow-lg">
            <div x-data="{
                faqs: @js($faqs),
                current: 0
            }"
                class="w-full max-w-2xl mx-auto bg-white rounded-2xl p-6 space-y-3 border border-gray-100 shadow-sm">

                {{-- FAQ Content --}}
                <template x-for="(faq, index) in faqs" :key="index">
                    <div x-show="current === index" class="transition-all duration-300">
                        <details class="group bg-gray-50 rounded-xl border border-gray-200 p-1 open">
                            <summary
                                class="flex justify-between items-center cursor-pointer py-4 px-4 text-lg font-semibold text-gray-800 hover:bg-gray-100 rounded-xl transition-colors">
                                <span x-text="faq.question" class="pr-4"></span>
                                <span class="transition-transform group-open:rotate-45 text-gray-600">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                            </summary>
                            <div class="px-4 pb-4 pt-1">
                                <p class="text-gray-600 leading-relaxed" x-text="faq.answer"></p>
                            </div>
                        </details>
                    </div>
                </template>

                {{-- Navigation --}}
                <div class="flex justify-center items-center gap-4 pt-6">
                    {{-- Prev --}}
                    <button @click="current = (current - 1 + faqs.length) % faqs.length"
                        class="flex items-center justify-center bg-slate-600 hover:bg-slate-700 text-white rounded-full w-10 h-10 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                        <!-- Heroicon: chevron-left -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    {{-- Indicator --}}
                    <div class="flex gap-2">
                        <template x-for="(faq, index) in faqs" :key="index">
                            <button @click="current = index"
                                class="w-3 h-3 rounded-full transition-all duration-200 focus:outline-none"
                                :class="current === index ? 'bg-slate-600' : 'bg-gray-300 hover:bg-gray-400'"
                                :aria-label="`Go to FAQ ${index + 1}`">
                            </button>
                        </template>
                    </div>

                    {{-- Next --}}
                    <button @click="current = (current + 1) % faqs.length"
                        class="flex items-center justify-center bg-slate-600 hover:bg-slate-700 text-white rounded-full w-10 h-10 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                        <!-- Heroicon: chevron-right -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
