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
 <section class="bg-dark min-h-screen relative overflow-hidden">
     <!-- Background Elements -->
     <div class="absolute inset-0">
         <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl floating-animation"></div>
         <div class="absolute top-40 right-20 w-24 h-24 bg-white/10 rounded-full blur-xl floating-animation-delayed">
         </div>
         <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-white/10 rounded-full blur-2xl floating-animation"></div>
     </div>

     <div class="mx-auto  px-6 lg:px-8 relative z-10">
         <div class="flex flex-col lg:flex-row items-center justify-between min-h-screen py-20">
             <!-- Left Content -->

             <div class="lg:w-1/2 lg:pl-12">
                 <!-- Main Profile Card -->
                 <div class="p-0  mb-6">
                     <img class="w-full h-full object-cover" src="{{ asset('assets/hero.png') }}" alt="">
                 </div>
             </div>


             <!-- Right Content - Feature Cards -->
             <div class="lg:w-1/2 mb-12 lg:mb-0">
                 <div class="max-w-xl">
                     <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6 leading-tight text-shadow">
                         Nikmati Layanan
                         <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                             Premium
                         </span>
                         Harga Terjangkau
                     </h1>

                     <p class="text-white/90 text-lg lg:text-xl mb-8 leading-relaxed">
                         Dapatkan pengalaman menarik yang akan menginspirasi potensi diri,
                         menciptakan perubahan positif, melatihkan solusi inovatif, dan
                         membangun Indonesia yang lebih gemilang.
                     </p>

                     <div class="flex flex-col sm:flex-row gap-4">
                         <a href=""
                             class="bg-gray-100 text-secondary hover:text-secondary font-semibold px-8 py-4 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                             Pelajari Lebih Lanjut
                         </a>
                         <button
                             class="bg-primary shadow-md text-white font-semibold px-8 py-4 rounded-xl hover:bg-white hover:text-pink-600 transition-all duration-300">
                             Berlangganan Sekarang
                         </button>
                     </div>
                 </div>
             </div>

         </div>
     </div>

     <x-caraosel />

     <x-marquee-logo/>


     <!-- Bottom Wave -->
     <div class="absolute bottom-0 left-0 right-0">
         <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
             <path
                 d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                 fill="#f9fafb" />
         </svg>
     </div>
 </section>
