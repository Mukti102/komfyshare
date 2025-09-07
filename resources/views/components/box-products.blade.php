<div id="stepByStep" class="bg-dark rounded-[2rem] overflow-x-hidden md:rounded-[3rem] shadow-md text-gray-50 relative z-50 p-5">
  <div class="md:px-10 mx-2 mx-auto mb-8">
    <div class="flex  flex-col md:flex-row items-center gap-5">
          <!-- Left content -->
          <div class="w-full md:w-[80%] space-y-2  md:space-y-4">
              <h2 class="text-xl md:text-4xl font-bold leading-snug">
                  Langkah Berlangganan di Komfyshare
              </h2>
              <p class="text-gray-300 text-xs md:text-base">
                  Nikmati layanan premium dengan mudah melalui langkah-langkah berikut.
              </p>
          </div>
  
          <!-- Right content (grid) -->
          <div class="w-full grid grid-cols-2 sm:grid-cols-4 gap-2">
              <div class="h-40">
                  <img src="{{asset('assets/step1.png')}}"
                      alt="Step 1" class="w-full h-full object-contain" />
              </div>
              <div class="h-40">
                  <img src="{{asset('assets/step2.png')}}"
                      alt="Step 2" class="w-full h-full object-contain" />
              </div>
              <div class="h-40">
                  <img src="{{asset('assets/step3.png')}}"
                      alt="Step 3" class="w-full h-full object-contain" />
              </div>
              <div class="h-40">
                  <img src="{{asset('assets/step4.png')}}"
                      alt="Step 4" class="w-full h-full object-contain" />
              </div>
          </div>
      </div>
      {{-- cards --}}
      @livewire('products-tab')
    </div>  
</div>
