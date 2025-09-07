 @push('styles')
     <style>
         /* .gradient-bg {
                                                        background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
                                                    } */

         .floating-animation {
             animation: float 3s ease-in-out infinite;
         }

         .floating-animation-delayed {
             animation: float 3s ease-in-out infinite 1.5s;
         }

         @keyframes float {

             0%,
             100% {
                 transform: translateY(0px);
             }

             50% {
                 transform: translateY(-10px);
             }
         }

         .pulse-glow {
             animation: pulse-glow 2s ease-in-out infinite alternate;
         }

         @keyframes pulse-glow {
             from {
                 box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
             }

             to {
                 box-shadow: 0 0 30px rgba(255, 255, 255, 0.6);
             }
         }

         .card-hover {
             transition: all 0.3s ease;
         }

         .card-hover:hover {
             transform: translateY(-5px);
             box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
         }

         .text-shadow {
             text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         }
     </style>
 @endpush
 <!-- Hero Section -->
 <section
     class="bg-[url('https://i.pinimg.com/1200x/38/9a/39/389a39ad3a2e8005f2cd2330170694e5.jpg')] bg-no-repeat bg-cover md:min-h-screen h-[17rem] md:h-[40rem] md:mt-0 mt-10 relative overflow-hidden">
     <!-- Background Elements -->
     <div class="absolute inset-0">
         <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl floating-animation"></div>
         <div class="absolute top-40 right-20 w-24 h-24 bg-white/10 rounded-full blur-xl floating-animation-delayed">
         </div>
         <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-white/10 rounded-full blur-2xl floating-animation"></div>
     </div>


     <div
         class="h-full w-[90%] md:w-[70%] px-2 md:px-20  bg-gradient-to-r from-[30%] md:from-[40%]  from-black/80 to-transparent   relative z-50 flex items-center justify-center">
         <div class="flex  flex-col lg:flex-row items-center justify-center h-full md:min-h-screen py-20">
             <!-- Right Content - Feature Cards -->
             <div class="w-[90%]">
                 <h1 class="text-2xl lg:text-6xl font-bold text-white mb-2 md:mb-6 leading-tight text-shadow">
                     Nikmati Layanan
                     <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                         Premium
                     </span>
                     Harga Terjangkau
                 </h1>

                 <p class="text-white/90 text-xs lg:text-xl mb-4 md:mb-8 leading-relaxed">
                     Dapatkan pengalaman menarik yang akan menginspirasi potensi diri,
                     menciptakan perubahan positif, melatihkan solusi inovatif, dan
                     membangun Indonesia yang lebih gemilang.
                 </p>

                 <div class="flex flex-col sm:flex-row gap-4">

                     <a href="{{route('article.show', $article->slug)}}"
                         class="bg-primary w-max shadow-md text-white font-semibold px-3 md:px-8 py-2 md:py-4 md:rounded-xl rounded-md hover:bg-white hover:text-pink-600 text-xs md:text-base transition-all duration-300">
                         Lihat Selengkapnya
                     </a>
                 </div>
             </div>
         </div>
        </div>
 </section>
