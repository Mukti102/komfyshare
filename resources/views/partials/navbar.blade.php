<!-- Tambahkan di <head> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<nav class="bg-dark fixed top-0 w-full z-[10000] shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="flex-shrink-0">
                <img src="{{ setting('general.logo')
                    ? asset('storage/' . setting('general.logo'))
                    : 'https://framerusercontent.com/images/oy9SYJ2WmyA8UPfKd9dELJTEbxE.png?scale-down-to=512&width=1131&height=1079' }}"
                    class="w-14" alt="">
                {{-- <span class="text-2xl font-bold text-white">PESAN <span class="text-primary">BICARA</span></span> --}}
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="/"
                        class="text-white hover:text-primary px-3 py-2 text-sm font-medium transition-colors">Beranda</a>
                    <a href="#benefit"
                        class=" hover:text-primary px-3 py-2 text-sm font-medium transition-colors text-white ">Keunggulan
                        Kami</a>
                    <a href="#stepByStep"
                        class=" hover:text-primary px-3 py-2 text-sm font-medium transition-colors text-white ">Cara
                        Langganan</a>
                    <a href="#service"
                        class=" hover:text-primary px-3 py-2 text-sm font-medium transition-colors text-white">Layanan</a>
                    <a href="#faq"
                        class=" hover:text-primary px-3 py-2 text-sm font-medium transition-colors text-white">FAQ</a>
                    <a href="https://wa.me/{{ setting('general.phone') }}" target="_blank"
                        class=" hover:text-primary px-3 py-2 text-sm font-medium transition-colors text-white">Testimoni</a>
                    <a href="{{ route('article.index') }}"
                        class=" hover:text-primary px-3 py-2 text-sm font-medium transition-colors {{ request()->is('article*') ? 'text-primary' : 'text-white' }} ">Artikel</a>

                </div>
            </div>

            {{-- @guest
                <!-- Desktop Auth Buttons -->
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center space-x-4">
                        <a href="/login"
                            class="bg-primary hover:bg-primary/80 text-white px-4 py-2 text-sm font-medium rounded-lg transition-colors shadow-sm">
                            Login
                        </a>
                        <a href="/register"
                            class="bg-white/10 backdrop-blur-sm text-white hover:bg-secondary/70 px-4 py-2 text-sm font-medium border-[1px] hover:border-white border-white/70 hover:border-blue-700 rounded-lg transition-colors shadow-sm">
                            Daftar
                        </a>
                    </div>
                </div>
            @endguest

            @auth
                @php
                    $user = auth()->user();
                @endphp
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="md:flex hidden  items-center space-x-2 focus:outline-none">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                            alt="Avatar"
                            class="md:w-10 md:h-10 w-8 h-8 rounded-full object-cover border-2 border-white shadow-md">
                        <span class="text-white hidden md:inline-block">{{ Auth::user()->name }}</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-50 transition ease-out duration-200"
                        x-transition:enter="transform ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transform ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1">

                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth --}}


            <!-- Mobile Hamburger Button -->
            <div class="md:hidden flex gap-2 items-center">

                {{-- @auth
                    @php
                        $user = auth()->user();
                    @endphp
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                alt="Avatar"
                                class="md:w-10 md:h-10 w-8 h-8 rounded-full object-cover border-2 border-white shadow-md">
                            <span class="text-white hidden md:inline-block">{{ Auth::user()->name }}</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-50 transition ease-out duration-200"
                            x-transition:enter="transform ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transform ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1">

                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth --}}
                <button type="button" class="mobile-menu-button text-white hover:text-primary p-2 focus:outline-none"
                    onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden text-white overflow-hidden rounded-b-lg">
            <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
                <a href="/"
                    class="block px-3 py-2 text-base font-medium transition-colors hover:text-primary">Beranda</a>
                <a href="#benefit"
                    class="block px-3 py-2 text-base font-medium transition-colors hover:text-primary  {{ request()->is('about*') ? 'bg-primary text-white rounded-lg' : '' }}">Keunggulan
                    Kami</a>
                <a href="#stepByStep"
                    class="block px-3 py-2 text-base font-medium transition-colors hover:text-primary  {{ request()->is('majalah*') ? 'bg-primary text-white rounded-lg' : '' }}">Cara
                    Langganan</a>
                <a href="#service"
                    class="block px-3 py-2 text-base font-medium transition-colors hover:text-primary {{ request()->is('programs*') ? 'bg-primary text-white rounded-lg' : '' }} ">Layanan</a>
                <a href="#faq"
                    class="block px-3 py-2 text-base font-medium transition-colors hover:text-primary {{ request()->is('programs*') ? 'bg-primary text-white rounded-lg' : '' }} ">FAQ</a>
                <a href="https://wa.me/{{ setting('general.phone') }}"
                    class="block px-3 py-2 text-base font-medium transition-colors hover:text-primary {{ request()->is('programs*') ? 'bg-primary text-white rounded-lg' : '' }} ">Testimoni</a>
                <a href="{{route('article.index')}}"
                    class="block px-3 py-2 text-base font-medium transition-colors hover:text-primary {{ request()->is('article*') ? 'bg-primary text-white rounded-lg' : '' }} ">Artikel</a>
                {{-- @guest
                    <!-- Auth Buttons -->
                    <div class="pt-4  space-y-2">
                        <a href="/login"
                            class="w-full block text-center text-white px-4 py-2 text-sm font-medium border border-white hover:border-secondary hover:bg-secondary hover:text-white rounded-lg transition-colors">
                            Login
                        </a>
                        <a href="/register"
                            class="w-full block text-center bg-primary hover:bg-primary/70 text-white px-4 py-2 text-sm font-medium rounded-lg transition-colors">
                            Daftar
                        </a>
                    </div>
                @endguest
                @auth
                    <!-- Auth Buttons -->
                    <form action="{{ route('logout') }}" method="POST" class="pt-4  space-y-2">
                        @csrf
                        <button type="submit"
                            class="w-full block text-center text-white bg-red-500 px-4 py-2 text-sm font-medium hover:border-secondary hover:bg-red-500 hover:text-white rounded-lg transition-colors">
                            Logout
                        </button>
                    </form>
                @endauth --}}
            </div>
        </div>
    </div>
</nav>

<script>
    const mobileMenu = document.getElementById("mobile-menu");
    let isOpen = false;

    function toggleMobileMenu() {
        if (isOpen) {
            gsap.to(mobileMenu, {
                height: 0,
                opacity: 0,
                duration: 0.4,
                ease: "power2.inOut",
                onComplete: () => {
                    mobileMenu.classList.add("hidden");
                },
            });
        } else {
            mobileMenu.classList.remove("hidden");
            gsap.set(mobileMenu, {
                height: "auto",
                opacity: 0
            });
            const fullHeight = mobileMenu.offsetHeight;
            gsap.fromTo(
                mobileMenu, {
                    height: 0,
                    opacity: 0
                }, {
                    height: fullHeight,
                    opacity: 1,
                    duration: 0.4,
                    ease: "power2.out"
                }
            );
        }
        isOpen = !isOpen;
    }

    // Close menu on resize to desktop
    window.addEventListener("resize", () => {
        if (window.innerWidth >= 768) {
            if (isOpen) {
                gsap.set(mobileMenu, {
                    height: 0,
                    opacity: 0
                });
                mobileMenu.classList.add("hidden");
                isOpen = false;
            }
        }
    });

    // Close when clicking outside
    document.addEventListener("click", (e) => {
        const btn = document.querySelector(".mobile-menu-button");
        if (
            isOpen &&
            !mobileMenu.contains(e.target) &&
            !btn.contains(e.target)
        ) {
            toggleMobileMenu();
        }
    });
</script>
