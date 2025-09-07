 <!-- Skema Berlangganan -->
 <div
     class="bg-white backdrop-blur-xl border border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 transition-all duration-500 group relative overflow-hidden">
     <div
         class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-light via-primary to-primary-dark animate-pulse">
     </div>
     <div class=" relative">
         <div class="absolute bottom-6 left-6 w-20 h-20 bg-primary/20 rounded-full blur-2xl animate-pulse"
             style="animation-delay: 1s;"></div>
         <div class="relative z-10">
             <div class="flex  border-b-[1.5px] border-gray-300 justify-center   items-center gap-6">
                 <div class="md:p-4 p-3">
                     <div class="flex  gap-5 items-center">
                         <h2
                             class="text-sm lg:text-3xl bg-primary text-gray-100 px-4 rounded-lg  font-bold md:font-bold text-gray-100 py-3 group-hover:text-primary-light transition-colors duration-300">
                             Skema Berlangganan
                         </h2>
                         <div class="text-dark font-bold text-sm md:text-3xl">
                             Informasi
                         </div>
                     </div>
                 </div>
             </div>
             <div class="prose p-3 md:p-5  pt-0 pb-7 md:text-base text-xs  max-w-none text-gray-900 dark:prose-invert">
                 {!! $product->description !!}
             </div>
         </div>
     </div>
 </div>
