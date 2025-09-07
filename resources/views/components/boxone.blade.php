 <!-- All packages include -->
 <div
     class="bg-gray-50 backdrop-blur-xl border border-primary/30 p-5 md:p-8 rounded-3xl shadow-2xl hover:border-primary/60  transition-all duration-500 group relative overflow-hidden">
     <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-light via-primary to-primary-dark">
     </div>
     <div class="flex items-start gap-6 mb-3 md:mb-8">
         <div>
             <h2
                 class="text-lg lg:text-4xl font-bold md:font-black text-dark mb-3 group-hover:text-primary-light transition-colors duration-300">
                 Semua Paket Termasuk
             </h2>
         </div>
     </div>
     <ul class="gap-2 space-y-2 md:space-y-4">
         @foreach ($product->listOfBenefits as $benefit)
             <li class="flex  items-center gap-2 md:gap-3 rounded-xl">
                 <div
                     class="md:w-7 md:h-7 w-4 h-4 bg-primary rounded-full flex items-center justify-center shadow-lg group-hover/item:scale-110 transition-transform duration-300">
                     <i class="fa-solid fa-check md:text-base text-xs text-white"></i>
                 </div>
                 <span
                     class="text-xl font-semibold md:font-bold md:text-base text-xs  text-dark group-hover/item:text-primary-light transition-colors duration-300">Akses
                     {{$benefit}}</span>
             </li>
         @endforeach
     </ul>
 </div>
