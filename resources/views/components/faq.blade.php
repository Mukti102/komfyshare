<div class="relative py-40 md:py-40  overflow-hidden">
    {{-- Left Decoration --}}
    <div class="absolute  md:block md:scale-110 md:-left-52 -left-32 top-5 md:top-20 z-10">
        <img src="https://framerusercontent.com/images/3uVPAqMRqV6jKuatzLLj3Z9bNnQ.png" alt="" class="w-[60%] md:w-full h-full object-cover">
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
            <div 
                x-data="{
                    faqs: @js($faqs), 
                    current: 0
                }" 
                class="w-full max-w-2xl mx-auto bg-gray-100 rounded-2xl p-6 space-y-2"
            >
                {{-- FAQ Content --}}
                <template x-for="(faq, index) in faqs" :key="index">
                    <div x-show="current === index" class="transition-all duration-300">
                        <details class="group border-b border-gray-200 open">
                            <summary class="flex justify-between items-center cursor-pointer py-3 text-lg font-semibold text-gray-800">
                                <span x-text="faq.question"></span>
                                <span class="transition-transform group-open:rotate-45 text-gray-600">+</span>
                            </summary>
                            <p class="text-gray-600 pb-3 px-1" x-text="faq.answer"></p>
                        </details>
                    </div>
                </template>
            
                {{-- Navigation --}}
                <div class="flex justify-center items-center gap-4 pt-6">
                    {{-- Prev --}}
                    <button 
                        @click="current = (current - 1 + faqs.length) % faqs.length" 
                        class="bg-pink-400 text-white rounded-full px-4 py-2 hover:bg-pink-500 transition"
                    >
                        &lt;
                    </button>
            
                    {{-- Indicator --}}
                    <div class="flex gap-2">
                        <template x-for="(faq, index) in faqs" :key="index">
                            <span 
                                class="w-3 h-3 rounded-full transition"
                                :class="current === index ? 'bg-pink-500' : 'bg-gray-300'"
                            ></span>
                        </template>
                    </div>
            
                    {{-- Next --}}
                    <button 
                        @click="current = (current + 1) % faqs.length" 
                        class="bg-pink-500 text-white rounded-full px-4 py-2 hover:bg-pink-600 transition"
                    >
                        &gt;
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
