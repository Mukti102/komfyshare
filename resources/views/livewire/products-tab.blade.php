<div class="w-full py-10  relative ">

    <div class="absolute inset-0 ">
        <div
            class="absolute top-20 -left-60 w-[20rem]  h-[20rem] bg-blue-800/80 rounded-full blur-2xl floating-animation">
        </div>
        <div
            class="absolute bottom-10 -right-60 w-[20rem]  h-[20rem] bg-blue-800/60 rounded-full blur-2xl floating-animation">
        </div>
        <div class="absolute top-40 right-20 w-24 h-24  bg-blue-800/40 rounded-full blur-xl floating-animation-delayed">
        </div>
        <div class="absolute bottom-20 left-1/4 w-40  h-40 bg-blue-800/40 rounded-full blur-2xl floating-animation">
        </div>
        <div class="absolute bottom-10 left-1/4 w-40  h-40 bg-blue-800/40 rounded-full blur-2xl floating-animation">
        </div>
    </div>

    <div
        class="relative z-50 px-6 py-4 
            rounded-3xl 
            bg-white/10 
            border-2 border-white/80 
            backdrop-blur-xl shadow-lg">

        <div class="text-center space-y-2 mb-8">
            <img src="{{ asset('assets/sharemorepayless.png') }}" class="scale-110 md:scale-100" alt="">
            <h3 class=" md:text-4xl text-[1rem]">Berbagi Langganan, Lebih Hemat!</h3>
        </div>

        {{-- Buttons --}}
        <div class="relative">

            <!-- Category Slider Container -->
            <div class="relative overflow-hidden   mx-0 md:mx-8 lg:mx-0">
                <div id="categorySlider"
                    class="flex transition-transform  py-3 px-1 md:px-5 duration-500 ease-out space-x-3 md:space-x-4">

                    <!-- All Categories Button -->
                    <button wire:click="$set('activeCategory', 'all')"
                        class="category-btn flex-shrink-0 group/btn relative overflow-hidden
                                    {{ $activeCategory === 'all' ? 'active text-gray-900' : '' }}
                                    bg-white/10 hover:bg-white/15 backdrop-blur-sm border border-white/20 
                                     font-medium rounded-full text-sm md:text-base 
                                    px-6 md:px-8 py-3 md:py-4 transition-all duration-300 
                                    hover:scale-105 hover:shadow-xl min-w-fit">

                        <!-- Active Background -->
                        <div
                            class="absolute inset-0 bg-gray-50  opacity-0 transition-opacity duration-300 rounded-full">
                        </div>

                        <!-- Button Content -->
                        <span class="relative z-10 flex items-center gap-2">
                            <i class="fas fa-th-large text-xs opacity-70"></i>
                            <span>Semua</span>
                        </span>

                    </button>

                    <!-- Category Buttons -->
                    @foreach ($categories ?? [] as $category)
                        <button wire:click="$set('activeCategory', {{ $category->id }})"
                            class="category-btn flex-shrink-0 group/btn relative overflow-hidden
                                        {{ $activeCategory == $category->id ? 'active text-gray-900' : '' }}
                                        bg-white/10 hover:bg-white/15 backdrop-blur-sm border border-white/20 
                                         font-medium rounded-full text-sm md:text-base 
                                        px-6 md:px-8 py-3 md:py-4 transition-all duration-300 
                                        hover:scale-105 hover:shadow-xl min-w-fit">

                            <!-- Active Background -->
                            <div
                                class="absolute inset-0 bg-gray-50  opacity-0 transition-opacity duration-300 rounded-full">
                            </div>

                            <!-- Button Content -->
                            <span class="relative z-10 flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-current opacity-50"></div>
                                <span>{{ $category->name }}</span>
                            </span>


                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Gradient Fade Edges -->
            {{-- <div
                     class="absolute left-0 top-0 w-12 h-full bg-gradient-to-r from-slate-900 to-transparent pointer-events-none z-5 md:hidden">
                 </div>
                 <div
                     class="absolute right-0 top-0 w-12 h-full bg-gradient-to-l from-slate-900 to-transparent pointer-events-none z-5 md:hidden">
                 </div> --}}

            <!-- Scroll Indicator Dots (Mobile Only) -->
            <div class="flex justify-center mt-4 space-x-2 md:hidden" id="scrollIndicators">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>

        {{-- Loading Spinner --}}
        <div wire:loading.flex class="justify-center items-center py-10 col-span-full">
            <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-red-500"></div>
        </div>

        {{-- Cards --}}
        <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 py-10">
            @if ($activeCategory === 'all')
                @foreach ($categories as $category)
                    @foreach ($category->products as $product)
                        @livewire('card-product', ['product' => $product], key('all-' . $product->id))
                    @endforeach
                @endforeach
            @else
                @php
                    $selectedCategory = $categories->firstWhere('id', $activeCategory);
                @endphp

                @if ($selectedCategory)
                    @foreach ($selectedCategory->products as $product)
                        @livewire('card-product', ['product' => $product], key('cat-' . $product->id))
                    @endforeach
                @else
                    <p class="col-span-full text-center text-gray-500">Belum ada produk.</p>
                @endif
            @endif
        </div>

    </div>
</div>

@push('styles')
    <style>
        /* Active Button Styles */
        .category-btn.active .absolute:first-of-type {
            opacity: 1;
        }

        /* .category-btn.active {
                    transform: translateY(-2px);
                    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
                    border-color: rgba(239, 68, 68, 0.5);
                } */

        .category-btn.active span {
            /* text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); */
        }

        /* Hide scrollbar */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Smooth scrolling */
        #categorySlider {
            scroll-behavior: smooth;
        }

        /* Arrow button animations */
        @keyframes slideArrowLeft {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-3px);
            }
        }

        @keyframes slideArrowRight {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(3px);
            }
        }

        #slideLeft:hover i {
            animation: slideArrowLeft 0.6s ease-in-out infinite;
        }

        #slideRight:hover i {
            animation: slideArrowRight 0.6s ease-in-out infinite;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {

            .group:hover #slideLeft,
            .group:hover #slideRight {
                opacity: 1;
            }
        }

        /* Scroll indicator dots */
        .scroll-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .scroll-dot.active {
            background: rgba(239, 68, 68, 0.8);
            transform: scale(1.2);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('categorySlider');
            const leftBtn = document.getElementById('slideLeft');
            const rightBtn = document.getElementById('slideRight');
            const container = slider.parentElement;

            let currentTranslate = 0;
            let maxTranslate = 0;

            // Calculate max translate distance
            function calculateMaxTranslate() {
                const containerWidth = container.offsetWidth;
                const sliderWidth = slider.scrollWidth;
                maxTranslate = Math.max(0, sliderWidth - containerWidth);
                updateArrowVisibility();
            }

            // Update arrow button visibility
            function updateArrowVisibility() {
                if (leftBtn && rightBtn && window.innerWidth >= 768) { // Desktop
                    leftBtn.style.opacity = currentTranslate > 0 ? '1' : '0.5';
                    rightBtn.style.opacity = currentTranslate < maxTranslate ? '1' : '0.5';
                    leftBtn.style.pointerEvents = currentTranslate > 0 ? 'auto' : 'none';
                    rightBtn.style.pointerEvents = currentTranslate < maxTranslate ? 'auto' : 'none';
                }
            }

            // Slide functions
            function slideLeft() {
                if (currentTranslate > 0) {
                    currentTranslate = Math.max(0, currentTranslate - 200);
                    slider.style.transform = `translateX(-${currentTranslate}px)`;
                    updateArrowVisibility();
                    updateScrollIndicators();
                }
            }

            function slideRight() {
                if (currentTranslate < maxTranslate) {
                    currentTranslate = Math.min(maxTranslate, currentTranslate + 200);
                    slider.style.transform = `translateX(-${currentTranslate}px)`;
                    updateArrowVisibility();
                    updateScrollIndicators();
                }
            }

            // Create scroll indicators for mobile
            function createScrollIndicators() {
                const indicatorsContainer = document.getElementById('scrollIndicators');
                if (window.innerWidth < 768 && maxTranslate > 0) {
                    const numDots = Math.ceil(maxTranslate / 200) + 1;
                    indicatorsContainer.innerHTML = '';

                    for (let i = 0; i < numDots; i++) {
                        const dot = document.createElement('div');
                        dot.className = 'scroll-dot';
                        if (i === 0) dot.classList.add('active');
                        indicatorsContainer.appendChild(dot);
                    }
                } else {
                    indicatorsContainer.innerHTML = '';
                }
            }

            // Update scroll indicators
            function updateScrollIndicators() {
                const dots = document.querySelectorAll('.scroll-dot');
                const activeIndex = Math.round(currentTranslate / 200);

                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === activeIndex);
                });
            }

            // Event listeners for arrow buttons (if they exist)
            if (leftBtn) leftBtn.addEventListener('click', slideLeft);
            if (rightBtn) rightBtn.addEventListener('click', slideRight);

            // Touch/swipe support for mobile - FIXED VERSION
            let startX = 0;
            let startY = 0;
            let currentX = 0;
            let isDragging = false;
            let startTranslate = 0;

            // Prevent default touch behavior that might interfere
            slider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                startTranslate = currentTranslate;
                isDragging = true;
                slider.style.transition = 'none';

                // Prevent default only if we're actually going to handle this
                // e.preventDefault();
            }, {
                passive: false
            });

            slider.addEventListener('touchmove', (e) => {
                if (!isDragging) return;

                currentX = e.touches[0].clientX;
                const currentY = e.touches[0].clientY;

                // Check if this is more of a horizontal swipe
                const diffX = startX - currentX;
                const diffY = Math.abs(startY - currentY);

                // If it's more horizontal movement, handle the slide
                if (Math.abs(diffX) > diffY) {
                    // e.preventDefault(); // Prevent scrolling

                    const newTranslate = Math.max(0, Math.min(maxTranslate, startTranslate + diffX));
                    slider.style.transform = `translateX(-${newTranslate}px)`;
                }
            }, {
                passive: false
            });

            slider.addEventListener('touchend', (e) => {
                if (!isDragging) return;

                const diffX = startX - currentX;
                const diffY = Math.abs(startY - e.changedTouches[0].clientY);

                slider.style.transition = 'transform 0.3s ease-out';
                isDragging = false;

                // Only handle horizontal swipes
                if (Math.abs(diffX) > diffY && Math.abs(diffX) > 30) {
                    if (diffX > 0 && currentTranslate < maxTranslate) {
                        // Swipe left - move right
                        currentTranslate = Math.min(maxTranslate, startTranslate + Math.min(diffX, 200));
                    } else if (diffX < 0 && currentTranslate > 0) {
                        // Swipe right - move left  
                        currentTranslate = Math.max(0, startTranslate + Math.max(diffX, -200));
                    } else {
                        // Snap back
                        currentTranslate = startTranslate;
                    }
                } else {
                    // Snap back to original position
                    currentTranslate = startTranslate;
                }

                slider.style.transform = `translateX(-${currentTranslate}px)`;
                updateArrowVisibility();
                updateScrollIndicators();
            });

            // Mouse drag support for desktop
            let isMouseDown = false;
            let mouseStartX = 0;
            let mouseStartTranslate = 0;

            slider.addEventListener('mousedown', (e) => {
                if (window.innerWidth >= 768) { // Only on desktop
                    isMouseDown = true;
                    mouseStartX = e.clientX;
                    mouseStartTranslate = currentTranslate;
                    slider.style.cursor = 'grabbing';
                    slider.style.transition = 'none';
                    e.preventDefault();
                }
            });

            document.addEventListener('mousemove', (e) => {
                if (!isMouseDown || window.innerWidth < 768) return;

                const diffX = mouseStartX - e.clientX;
                const newTranslate = Math.max(0, Math.min(maxTranslate, mouseStartTranslate + diffX));
                slider.style.transform = `translateX(-${newTranslate}px)`;
            });

            document.addEventListener('mouseup', (e) => {
                if (!isMouseDown) return;

                const diffX = mouseStartX - e.clientX;
                slider.style.cursor = 'grab';
                slider.style.transition = 'transform 0.3s ease-out';
                isMouseDown = false;

                if (Math.abs(diffX) > 50) {
                    if (diffX > 0 && currentTranslate < maxTranslate) {
                        currentTranslate = Math.min(maxTranslate, mouseStartTranslate + Math.min(diffX,
                            200));
                    } else if (diffX < 0 && currentTranslate > 0) {
                        currentTranslate = Math.max(0, mouseStartTranslate + Math.max(diffX, -200));
                    } else {
                        currentTranslate = mouseStartTranslate;
                    }
                } else {
                    currentTranslate = mouseStartTranslate;
                }

                slider.style.transform = `translateX(-${currentTranslate}px)`;
                updateArrowVisibility();
                updateScrollIndicators();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    slideLeft();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    slideRight();
                }
            });

            // Initialize and handle window resize
            function init() {
                calculateMaxTranslate();
                createScrollIndicators();
                updateScrollIndicators();

                // Reset position on window resize
                currentTranslate = 0;
                slider.style.transform = 'translateX(0)';

                // Set cursor for desktop
                if (window.innerWidth >= 768) {
                    slider.style.cursor = 'grab';
                } else {
                    slider.style.cursor = 'default';
                }
            }

            // Auto-scroll to active category
            function scrollToActive() {
                const activeBtn = document.querySelector('.category-btn.active');
                if (activeBtn && container) {
                    const btnRect = activeBtn.getBoundingClientRect();
                    const containerRect = container.getBoundingClientRect();

                    if (btnRect.left < containerRect.left || btnRect.right > containerRect.right) {
                        const scrollAmount = btnRect.left - containerRect.left - 50;
                        currentTranslate = Math.max(0, Math.min(maxTranslate, currentTranslate + scrollAmount));
                        slider.style.transform = `translateX(-${currentTranslate}px)`;
                        updateArrowVisibility();
                        updateScrollIndicators();
                    }
                }
            }

            // Initialize
            init();

            // Handle window resize
            window.addEventListener('resize', () => {
                setTimeout(init, 100);
            });

            // Watch for active category changes (for Livewire)
            const observer = new MutationObserver(() => {
                setTimeout(scrollToActive, 100);
            });

            if (slider) {
                observer.observe(slider, {
                    attributes: true,
                    subtree: true,
                    attributeFilter: ['class']
                });
            }
        });
    </script>
@endpush
