<!-- Additional Content Section -->
@push('styles')
    <style>
        .card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card:hover {
            transform: scale(1.05) !important;
            z-index: 50 !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .card-container {
            perspective: 1000px;
        }
    </style>
@endpush

<section id="benefit" class="md:pt-10 pt-8 bg-gray-50 h-[75rem] md:h-[20rem] relative -top-10 md:-top-20 rounded-[2.5rem] md:rounded-[3rem]">
    <div class=" mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 relative -top-40  md:grid-cols-3 gap-0 md:gap-8">
            <div class=" rounded-2xl  p-8   text-center">
                <div class="w-52 h-52   flex items-center justify-center mx-auto mb-2 md:mb-6">
                    <img src="{{asset('assets/service1.png')}}" class="scale-125" alt="">
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 md:mb-4">Hemat Lebih Banyak</h3>
                <p class="text-gray-600 text-sm">
                    Akses Layanan Premium Kini Jadi Lebih Terjangkau. Dengan Komfy Share, Anda Dapat Menikmati Fitur
                    Terbaik Tanpa Harus Membayar Penuh Cukup Patungan Untuk Kenyamanan Bersama
                </p>
            </div>
            <div class=" rounded-2xl  p-8   text-center">
                <div class="w-52 h-52 flex items-center justify-center mx-auto mb-2 md:mb-6">
                    <img src="{{asset('assets/service2.png')}}" class="scale-125" alt="">
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 md:mb-4">Legal Dan Aman</h3>
                <p class="text-gray-600">
                    Gunakan Layanan Premium Tanpa Rasa Khawatir. Komfy Share Memastikan Semua Langganan Berasal Dari
                    Sumber Resmi, Menghadirkan Pengalaman
                </p>
            </div>
            <div class=" rounded-2xl  p-8   text-center">
                <div class="w-52 h-52 flex items-center justify-center mx-auto mb-2 md:mb-6">
                    <img src="{{asset('assets/service3.png')}}" class="scale-125"  alt="">
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 md:mb-4">Layanan Responsive</h3>
                <p class="text-gray-600">
                    Kenyamanan Anda Adalah Prioritas Kami. Tim Customer Service KomfyShare Siap Memberikan Solusi
                    Cepat Dan Ramah Untuk Setiap Kebutuhan Anda
                </p>
            </div>
        </div>
    </div>
</section>
<x-anvantage/>
