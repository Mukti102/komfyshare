   @push('styles')
       <style>
           .service-card {
               transition: all 0.3s ease;
               border-radius: 16px;
               overflow: hidden;
           }

           .service-card:hover {
               transform: translateY(-5px);
           }

           .gradient-bg {
               background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
           }
       </style>
   @endpush

   <div class="container mx-auto px-4">
       <!-- Header Section -->
       <div class="text-center mb-16">
           <h1 class="text-4xl md:text-5xl font-black text-gray-800 mb-4">Layanan Digital <span
                   class="text-primary">Komfyshare</span></h1>
           <p class="text-gray-500 max-w-2xl mx-auto">Temukan layanan digital terbaik untuk kebutuhan Anda dengan harga
               yang terjangkau dan kualitas premium.</p>
       </div>

       <!-- Services Grid -->
       <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
           <!-- Service Card 1 -->
           <div class="service-card bg-gray-50 p-6">
               <div class="mb-4">
                   <img src="https://framerusercontent.com/images/b6gFeM5GuzGFB8qURq0BWRL0gd8.png?scale-down-to=1024&width=1200&height=1599"
                       alt="Web Hosting" class="w-[15rem] h-52 object-cover mx-auto">
               </div>
               <h2 class="text-3xl font-black text-gray-800 mb-2 text-center">Komfyshare</h2>
               <p class="text-gray-600 font-semibold text-center">(Patungan Akun Nyaman)</p>
               <button type="button"
                   class="text-white my-5 w-full bg-primary/90 hover:bg-primary font-black rounded-xl text-3xl px-5 py-3 text-center me-2 mb-2">Mulai</button>
           </div>
           <!-- Service Card 1 -->
           <div class="service-card bg-gray-50 p-6">
               <div class="mb-4">
                   <img src="https://framerusercontent.com/images/gbDRJG1qvtLMrs5mWPHcvRhLE.png?scale-down-to=1024&width=1200&height=1599"
                       alt="Web Hosting" class="w-[15rem] h-52 object-cover mx-auto">
               </div>
               <h2 class="text-3xl font-black text-gray-800 mb-2 text-center">KomfyChecker</h2>
               <p class="text-gray-600 font-semibold text-center">(Cek plagiasi & AI Nyaman)</p>
               <button type="button"
                   class="text-white my-5 w-full bg-primary/90 hover:bg-primary font-black rounded-xl text-3xl px-5 py-3 text-center me-2 mb-2">Mulai</button>
           </div>

       </div>

   </div>
