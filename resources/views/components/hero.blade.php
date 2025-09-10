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
 <section class="bg-dark min-h-screen relative overflow-hidden md:pb-32  pb-20">
     <!-- Background Elements -->
     <div class="absolute inset-0">
         <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl floating-animation"></div>
         <div class="absolute top-40 right-20 w-24 h-24 bg-white/10 rounded-full blur-xl floating-animation-delayed">
         </div>
         <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-white/10 rounded-full blur-2xl floating-animation"></div>
     </div>

     <div class="mx-auto md:pt-0 pt-24   px-6 lg:px-8 relative z-10">
         <div class="flex flex-col   lg:flex-row items-center md:justify-between md:min-h-screen h-[82vh]  py-0 md:py-20">
             <!-- Left Content -->

             <div class="lg:w-1/2   lg:pl-12 ">
                 <div class="relative w-full">
                     <!-- Hero -->
                     <img class="w-full h-auto object-cover" src="{{ asset('assets/hero.png') }}" alt="">

                     <!-- Assets (pakai % biar proporsional) -->
                     <img src="{{ asset('assets/2.png') }}"
                         class="absolute md:w-max w-24 top-[15%] right-[20%] md:right-[18%] " alt="">
                     <img src="{{ asset('assets/1.png') }}" class="absolute md:w-max w-24  bottom-[25%] right-[10%] "
                         alt="">
                     <img src="{{ asset('assets/3.png') }}"
                         class="absolute md:w-max w-40  bottom-[10%] left-[3%] md:left-[0%]" alt="">
                 </div>
             </div>



             <!-- Right Content - Feature Cards -->
             <div class="lg:w-1/2 mb-0   lg:mb-0  ">
                 <div class="max-w-xl h-full  space-y-2">
                     <div class="md:mb-10 mb-2">
                         <h1
                             class="text-4xl lg:text-7xl md:text-start text-center font-bold text-white mb-2 md:mb-6 leading-tight text-shadow">
                             Nikmati Layanan
                         </h1>
                         <span class="bg-red-900">
                             <img src="{{ asset('assets/premium.png') }}" class="md:w-96 w-80" alt="">
                         </span>
                         <h1
                             class="text-4xl lg:text-6xl md:text-start text-center font-bold text-white mb-6 leading-tight text-shadow">
                             Harga Terjangkau
                         </h1>
                     </div>


                     <div
                         class="flex flex-col justify-center items-center bg-white p-1 md:p-3 md:w-max w-full rounded-lg sm:flex-row gap-4">
                         <div class="flex gap-3 items-center">
                             <div
                                 class="text-center flex justify-center items-center w-16 h-16 md:w-32 md:h-28 md:text-2xl text-xs bg-black rounded-lg text-white font-black">
                                 <div>
                                     <h4 class="md:text-3xl text-xl">{{$products}}+</h4>
                                     <h4>Layanan</h4>
                                 </div>
                             </div>
                             <div
                                 class="text-center flex justify-center items-center w-16 h-16 md:w-32 md:h-28 md:text-2xl text-xs bg-black rounded-lg text-white font-black">
                                 <div>
                                     <h4 class="md:text-3xl text-xl">{{$category}}</h4>
                                     <h4>Kategory</h4>
                                 </div>
                             </div>
                             <button
                                 class="bg-primary h-max shadow-md text-white font-bold md:px-8 px-4 py-2 md:py-5 md:rounded-xl rounded-md hover:shadow-md text-lg md:text-2xl transition-all duration-300">
                                 Berlangganan
                             </button>
                         </div>
                     </div>
                 </div>
             </div>

         </div>
     </div>

     <x-caraosel />

     <x-marquee-logo />


     <!-- Bottom Wave -->
     {{-- <div class="absolute -bottom-1 md:bottom-0 left-0 right-0">
         <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
             <path
                 d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                 fill="#f9fafb" />
         </svg>
     </div> --}}
 </section>
