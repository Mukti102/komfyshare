 {{-- <div
     class="bg-gray-900/60 backdrop-blur-xl border-2 border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 hover:shadow-primary/20 transition-all duration-500 group overflow-hidden relative">

     <div class="p-8 text-center border-b border-primary/30">
         <div
             class="w-14 h-14 bg-primary rounded-xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/50 group-hover:shadow-primary/80 group-hover:scale-110 transition-all duration-300">
             <i class="fa-solid fa-bolt text-white text-3xl"></i>
         </div>
         <h2
             class="text-3xl lg:text-3xl font-black text-white mb-2 group-hover:text-primary-light transition-colors duration-300">
             PILIH PAKET
         </h2>
         <p class="text-primary-light text-lg font-medium">Mulai Sekarang</p>
     </div>

     <div class="p-6 gap-3 grid grid-cols-2">
         @foreach ($prices as $price)
             <!-- Paket 1 Bulan -->
             <div class="relative">
                 @if ($price->discount)
                     <div
                         class="absolute z-50 -top-2 -right-1 bg-red-500 text-white px-2 py-1 rounded-full text-[10px] font-black shadow-lg shadow-red-500/20 ">
                         ⚡ Hemat 5%
                     </div>
                 @endif
                 <button wire:click="selectPrice({{$price->id}})"  class="w-full group/button">
                     <div
                         class="{{$selectedPriceId == $price->id ? "bg-primary shadow-xl shadow-primary/25 " :  "bg-primary/10 hover:bg-primary/20"}}  border-2 border-primary/50 hover:border-primary text-white p-4 rounded-xl transition-all duration-300 group-hover/button:scale-105 group-hover/button:shadow-lg group-hover/button:shadow-primary/25 relative overflow-hidden">
                         <div
                             class="absolute inset-0 bg-primary/0 hover:bg-primary/10 translate-x-[-100%] group-hover/button:translate-x-[100%] transition-transform duration-1000">
                         </div>
                         <div class="relative z-10">
                             <div class="flex items-center justify-center gap-2 mb-2">
                                 <h3 class="text-lg font-black">{{ $price->duration}}</h3>
                             </div>
                             <div class="flex flex-col justify-center items-center mb-2">
                                 <span class="text-red-400 text-xs line-through font-semibold">
                                     Rp {{ number_format($price->price * 2, 0, ',', '.') }}
                                 </span>
                                 <p class="text-sm font-bold text-primary-light">
                                     Rp {{ number_format($price->price, 0, ',', '.') }}
                                 </p>
                             </div>
                         </div>


                     </div>
                 </button>
             </div>
         @endforeach
     </div>
     <div class="p-4">
         <button
             class="w-full bg-primary text-white font-bold px-6 py-4 rounded-2xl hover:bg-primary/80 focus:ring-4 focus:outline-none focus:ring-primary/30 transition-all duration-300 text-lg">
             Buat Pesanan
         </button>
     </div>
 </div> --}}



  <div
     class="bg-gray-900/60 backdrop-blur-xl border-2 border-primary/50 rounded-3xl shadow-2xl hover:border-primary/80 hover:shadow-primary/20 transition-all duration-500 group overflow-hidden relative">

     <div class="p-8 text-center border-b border-primary/30">
         <div
             class="w-full h-14 bg-primary text-start rounded-xl p-2 mx-auto mb-6 shadow-sm shadow-primary/50 group-hover:shadow-primary/80  transition-all duration-300">
             <h4>Pket Netflix 0199</h4>
         </div>
         <h2
             class="text-3xl lg:text-3xl font-black text-white mb-2 group-hover:text-primary-light transition-colors duration-300">
             PILIH PAKET
         </h2>
         <p class="text-primary-light text-lg font-medium">Mulai Sekarang</p>
     </div>

     <div class="p-6 gap-3 grid grid-cols-2">
         @foreach ($prices as $price)
             <!-- Paket 1 Bulan -->
             <div class="relative">
                 @if ($price->discount)
                     <div
                         class="absolute z-50 -top-2 -right-1 bg-red-500 text-white px-2 py-1 rounded-full text-[10px] font-black shadow-lg shadow-red-500/20 ">
                         ⚡ Hemat 5%
                     </div>
                 @endif
                 <button wire:click="selectPrice({{$price->id}})"  class="w-full group/button">
                     <div
                         class="{{$selectedPriceId == $price->id ? "bg-primary shadow-xl shadow-primary/25 " :  "bg-primary/10 hover:bg-primary/20"}}  border-2 border-primary/50 hover:border-primary text-white p-4 rounded-xl transition-all duration-300 group-hover/button:scale-105 group-hover/button:shadow-lg group-hover/button:shadow-primary/25 relative overflow-hidden">
                         <div
                             class="absolute inset-0 bg-primary/0 hover:bg-primary/10 translate-x-[-100%] group-hover/button:translate-x-[100%] transition-transform duration-1000">
                         </div>
                         <div class="relative z-10">
                             <div class="flex items-center justify-center gap-2 mb-2">
                                 <h3 class="text-lg font-black">{{ $price->duration}}</h3>
                             </div>
                             <div class="flex flex-col justify-center items-center mb-2">
                                 <span class="text-red-400 text-xs line-through font-semibold">
                                     Rp {{ number_format($price->price * 2, 0, ',', '.') }}
                                 </span>
                                 <p class="text-sm font-bold text-primary-light">
                                     Rp {{ number_format($price->price, 0, ',', '.') }}
                                 </p>
                             </div>
                         </div>


                     </div>
                 </button>
             </div>
         @endforeach
     </div>
     <div class="p-4">
         <button
             class="w-full bg-primary text-white font-bold px-6 py-4 rounded-2xl hover:bg-primary/80 focus:ring-4 focus:outline-none focus:ring-primary/30 transition-all duration-300 text-lg">
             Buat Pesanan
         </button>
     </div>
 </div>

