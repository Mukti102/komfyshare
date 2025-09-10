@push('styles')
<style>
    .card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    .card:hover {
        transform: scale(1.05) translateY(-5px) !important;
        z-index: 50 !important;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
    }
    .card-container {
        perspective: 1200px;
        transform-style: preserve-3d;
    }
    .floating-animation {
        animation: float 6s ease-in-out infinite;
    }
    .floating-animation:nth-child(2) { animation-delay: -1.5s; }
    .floating-animation:nth-child(3) { animation-delay: -3s; }
    .floating-animation:nth-child(4) { animation-delay: -4.5s; }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(var(--rotate, 0deg)); }
        50% { transform: translateY(-10px) rotate(var(--rotate, 0deg)); }
    }
    .section-container::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }
    .content-wrapper { position: relative; z-index: 1; }
    .card-backdrop {
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.1);
    }
    @media (max-width: 768px) {
        .card { width: 160px !important; height: 240px !important; }
    }
</style>
@endpush

<section class="bg-gray-50 mb-10 md:mb-0">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-0    w-full md:py-12 lg:pb-10 px-4 lg:px-0 mx-auto items-center">
        <!-- Left - Floating Cards -->
        <div class="w-full  lg:w-[40%] h-96 lg:h-[300px] relative order-2 lg:order-1 hidden md:hidden sm:hidden lg:flex items-center justify-center z-0">
            <div class="relative -top-32 left-20 items-center justify-center gap-6">
                <div class="floating-animation absolute top-2 lg:-top-10 right-2 lg:right-6 w-40 lg:w-40 lg:h-72 overflow-hidden z-20" style="--rotate: 0deg;">
                    <img src="{{asset('assets/card1.png')}}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="floating-animation absolute top-2 lg:top-6 right-2 lg:right-40 w-40 lg:w-40 lg:h-72 overflow-hidden z-10" style="--rotate: 8deg;">
                    <img src="{{asset('assets/card2.png')}}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="floating-animation absolute top-2 lg:-top-24 right-2 lg:-right-36 w-40 lg:w-52 lg:h-72 overflow-hidden z-10" style="--rotate: -10deg;">
                    <img src="{{asset('assets/card3.png')}}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="floating-animation absolute top-2 lg:top-24 right-2 lg:-right-32 w-40 lg:w-52 lg:h-72 overflow-hidden z-30" style="--rotate: -0deg;">
                    <img src="{{asset('assets/card4.png')}}" class="w-full h-full object-cover" alt="">
                </div>
            </div>
        </div>

        <!-- Right - Content -->
        <div class="w-full lg:w-1/2 px-4 text-center lg:px-0 space-y-6 order-1 lg:order-2 flex flex-col justify-center relative z-30">
            <img src="{{asset('assets/komfybayarnya.png')}}" alt="">
            <p class="text-sm lg:text-lg text-gray-600  leading-relaxed">
                Nikmati kemudahan bertransaksi dengan berbagai metode pembayaran yang nyaman dan terjangkau. Komfy Share mendukung pembayaran melalui DANA, QRIS, ShopeePay, dan OVO, sehingga Anda bisa memilih cara yang paling praktis sesuai kebutuhan.
            </p>
            <h3 class="uppercase text-sm lg:text-2xl font-black text-primary">
                #kami pastikan setiap pembayaran berjalan cepat, aman, dan bebas ribet !!!
            </h3>
        </div>

    </div>
</section>
