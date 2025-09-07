<footer class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-100 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60"
            xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff"
            fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
    </div>

    <div class="relative mx-auto w-full max-w-screen-xl p-6 py-12 lg:py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">

            <!-- Brand Section -->
            <div class="lg:col-span-1">
                <div class="">
                    <a href="/" class="flex items-center mb-6 transform transition-transform duration-300 ">
                        <div class="relative">
                            <img src="{{ setting('general.logo')
                                ? asset('storage/' . setting('general.logo'))
                                : 'https://framerusercontent.com/images/oy9SYJ2WmyA8UPfKd9dELJTEbxE.png?scale-down-to=512&width=1131&height=1079' }}"
                                class="h-20 w-20" alt="Khomfyshare Logo" />

                        </div>
                    </a>

                    <div class="space-y-4">
                        <h2
                            class="text-3xl font-bold bg-gradient-to-r from-primary to-red-400 bg-clip-text text-transparent">
                            {{setting('general.brand_name')}}
                        </h2>
                        <p class="text-slate-300 leading-relaxed max-w-sm">
                            Nikmati layanan berbagi langganan premium dengan mudah, aman, dan lebih hemat. Bergabunglah
                            dengan KomfyShare untuk pengalaman berlangganan yang praktis dan terpercaya!
                        </p>

                        <!-- Social Media Icons -->
                        <div class="flex space-x-4 pt-4">
                            <a href="{{ setting('sosialMedia.facebook') }}"
                                class="w-10 h-10 bg-white/10 hover:bg-blue-500/20 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-12">
                                <i class="fab fa-facebook-f text-blue-400"></i>
                            </a>
                            <a href="{{ setting('sosialMedia.instagram') }}"
                                class="w-10 h-10 bg-white/10 hover:bg-pink-500/20 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-12">
                                <i class="fab fa-instagram text-pink-400"></i>
                            </a>
                            <a href="https://wa.me/{{ setting('sosialMedia.whatsaap') }}" target="_blank"
                                class="w-10 h-10 bg-white/10 hover:bg-green-500/20 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-12">
                                <i class="fab fa-whatsapp text-green-400"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Links & Contact Section -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

                <!-- Information Links -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                            <div class="w-1 h-6 bg-gradient-to-b from-blue-400 to-purple-400 rounded-full mr-3"></div>
                            Informasi
                        </h3>
                        <nav class="space-y-4">
                            <a href="#benefit"
                                class="group flex items-center text-slate-300 hover:text-white transition-all duration-300">
                                <i
                                    class="fas fa-arrow-right mr-3 text-blue-400 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                                <span class="group-hover:translate-x-2 transition-transform duration-300">Keunggulan
                                    Kami</span>
                            </a>
                            <a href="#stepByStep"
                                class="group flex items-center text-slate-300 hover:text-white transition-all duration-300">
                                <i
                                    class="fas fa-arrow-right mr-3 text-blue-400 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                                <span class="group-hover:translate-x-2 transition-transform duration-300">Cara
                                    Berlangganan</span>
                            </a>
                            <a href="#service"
                                class="group flex items-center text-slate-300 hover:text-white transition-all duration-300">
                                <i
                                    class="fas fa-arrow-right mr-3 text-blue-400 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                                <span class="group-hover:translate-x-2 transition-transform duration-300">Layanan</span>
                            </a>
                            <a href="#faq"
                                class="group flex items-center text-slate-300 hover:text-white transition-all duration-300">
                                <i
                                    class="fas fa-arrow-right mr-3 text-blue-400 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                                <span class="group-hover:translate-x-2 transition-transform duration-300">Faq</span>
                            </a>
                            <a href="term"
                                class="group flex items-center text-slate-300 hover:text-white transition-all duration-300">
                                <i
                                    class="fas fa-arrow-right mr-3 text-blue-400 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></i>
                                <span class="group-hover:translate-x-2 transition-transform duration-300">Kebijakan
                                    Privasi</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                            <div class="w-1 h-6 bg-gradient-to-b from-green-400 to-blue-400 rounded-full mr-3"></div>
                            Hubungi Kami
                        </h3>

                        <div class="space-y-4">
                            <!-- Email -->
                            <div
                                class="group flex items-center gap-4 p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-envelope text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">Email</p>
                                    <p class="text-white font-medium">{{ setting('general.email') }}</p>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div
                                class="group flex items-center gap-4 p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <i class="fab fa-whatsapp text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-wide font-medium">WhatsApp</p>
                                    <p class="text-white font-medium">{{ setting('general.phone') }}</p>
                                </div>
                            </div>

                            <!-- Operating Hours -->
                            <div
                                class="group p-6 bg-gradient-to-r from-orange-500/10 to-yellow-500/10 border border-orange-500/20 rounded-xl backdrop-blur-sm hover:from-orange-500/15 hover:to-yellow-500/15 transition-all duration-300">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-clock text-white text-lg"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-white mb-2">Jam Operasional</h4>
                                        <p class="text-orange-200 mb-1">{{ setting('operational.text') }}</p>
                                        <p class="text-orange-100 font-semibold">
                                            {{ setting('operational.start-time') }} -
                                            {{ setting('operational.end-time') }} WIB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Separator -->
        <div class="my-12">
            <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
        </div>

        <!-- Bottom Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <span class="text-sm text-slate-400">
                    © 2023
                    <a href="/" class="hover:text-white transition-colors duration-300 font-medium">
                        Komfyshare™
                    </a>.
                    All Rights Reserved.
                </span>
            </div>

            <!-- Trust Badges -->
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2 text-sm text-slate-400">
                    <i class="fas fa-shield-alt text-green-400"></i>
                    <span>Secure</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-slate-400">
                    <i class="fas fa-lock text-blue-400"></i>
                    <span>Trusted</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-slate-400">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span>Premium</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary via-red-500 to-pink-500"></div>
    <div
        class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-tl from-primary/10 to-transparent rounded-full blur-3xl">
    </div>
    <div
        class="absolute top-10 left-10 w-20 h-20 bg-gradient-to-br from-pink-500/10 to-transparent rounded-full blur-2xl">
    </div>
</footer>

<style>
    /* Enhanced hover effects */
    .group:hover .fas,
    .group:hover .fab {
        transform: scale(1.1) rotate(5deg);
        transition: transform 0.3s ease;
    }

    /* Smooth gradient animation */
    @keyframes gradientShift {

        0%,
        100% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }
    }

    .gradient-bg {
        background: linear-gradient(-45deg, #1e293b, #0f172a, #1e293b, #334155);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }

    /* Custom scrollbar for mobile */
    @media (max-width: 768px) {
        .space-y-4 {
            max-height: 300px;
            overflow-y: auto;
        }
    }

    /* Glow effect on hover */
    .group:hover {
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.1);
    }
</style>
