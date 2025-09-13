 <!-- Detail Harga -->
 <div
     class="bg-gray-50 backdrop-blur-xl border border-primary/30 p-8 rounded-3xl shadow-2xl hover:border-primary/60  transition-all duration-500 group relative overflow-hidden">
     <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-light via-primary to-primary-dark">
     </div>
     <div class="flex items-start gap-2 md:gap-3 mb-8">
         <div>
             <h2
                 class="text-xl lg:text-4xl font-bold md:font-black text-dark mb-3 group-hover:text-primary-light transition-colors duration-300">
                 Detail Harga
             </h2>
             <p class="text-gray-800 text-sm md:text-lg font-medium">Transparan & Kompetitif</p>
         </div>
     </div>
     <div class="text-green-900 prose  pt-0 pb-7 prose-black md:text-base text-xs max-w-none  ">
         {!! $product->priceDetails !!}
     </div>
 </div>

