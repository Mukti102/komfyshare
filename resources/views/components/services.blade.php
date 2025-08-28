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

<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-black text-dark mb-4">
                Benefit Bergabung <span class="text-primary">Pesan Bicara</span>
            </h2>
            <p class="text-xl text-gray-500 max-w-3xl mx-auto">
                Bergabunglah dengan ribuan pembelajar yang telah mengembangkan potensi mereka bersama kami
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8  card-hover text-center">
                <div class="w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                    <img src="https://framerusercontent.com/images/x4tFKUXpEVZBMqqkCSNJw2nAOo.png" alt="">
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Hemat Lebih Banyak</h3>
                <p class="text-gray-600 text-sm">
                    Akses Layanan Premium Kini Jadi Lebih Terjangkau. Dengan Komfy Share, Anda Dapat Menikmati Fitur
                    Terbaik Tanpa Harus Membayar Penuh Cukup Patungan Untuk Kenyamanan Bersama
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8  card-hover text-center">
                <div class="w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                    <img src="https://framerusercontent.com/images/5xq7JHowMVgB5vYW9hj2PEoSY.png" alt="">
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Legal Dan Aman</h3>
                <p class="text-gray-600">
                    Gunakan Layanan Premium Tanpa Rasa Khawatir. Komfy Share Memastikan Semua Langganan Berasal Dari
                    Sumber Resmi, Menghadirkan Pengalaman
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8  card-hover text-center">
                <div class="w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                    <img src="https://framerusercontent.com/images/GqzbAcs3Ig2igd9Ojmtc0tTZmmo.png" alt="">
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Layanana Responsive</h3>
                <p class="text-gray-600">
                    Kenyamanan Anda Adalah Prioritas Kami. Tim Customer Service Komfy Share Siap Memberikan Solusi
                    Cepat Dan Ramah Untuk Setiap Kebutuhan Anda
                </p>
            </div>
        </div>
    </div>
</section>
<x-anvantage/>
