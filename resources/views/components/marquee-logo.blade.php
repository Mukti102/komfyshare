<div class="mb-32 mt-10 relative marquee-container">
    {{-- gradient right left --}}
    <div class="bg-gradient-to-l from-dark h-full w-20 to-transparent absolute right-0 z-50"></div>
    <div class="bg-gradient-to-r from-dark h-full w-20 to-transparent absolute left-0 z-50"></div>

    <div class="marquee">
        <div class="marquee-content flex gap-3">
            @php
                $count = count($brands);
                $min = 10;
            @endphp

            @for ($i = 0; $i < max($count, $min); $i++)
                @php
                    $brand = $brands[$i % $count]; // biar muter ulang kalau habis
                @endphp

                <div class="flex-shrink-0 w-40 h-40 flex items-center justify-center bg-white/10 rounded-2xl overflow-hidden p-0">
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}"
                        class="w-full h-full object-cover">
                </div>
            @endfor

        </div>
    </div>
</div>

<style>
    .marquee {
        overflow: hidden;
        display: flex;
        position: relative;
        width: 100%;
    }

    .marquee-content {
        display: flex;
        white-space: nowrap;
        will-change: transform;
    }
</style>

<script>
    function Marquee(selector, speedNormal, speedHover) {
        const parent = document.querySelector(selector);
        const content = parent.querySelector('.marquee-content');
        const clone = content.cloneNode(true);
        parent.appendChild(clone); // double isi biar looping mulus

        let i = 0;
        let speed = speedNormal;

        function move() {
            i -= speed;
            if (-i >= content.clientWidth) {
                i = 0; // reset pas habis 1 blok
            }
            // geser semua isi
            parent.querySelectorAll('.marquee-content').forEach(el => {
                el.style.transform = `translateX(${i}px)`;
            });
            requestAnimationFrame(move);
        }

        parent.addEventListener('mouseenter', () => speed = speedHover);
        parent.addEventListener('mouseleave', () => speed = speedNormal);

        move();
    }

    window.addEventListener('load', () => {
        Marquee('.marquee', 1, 0.5);
        // normal speed: 0.5, hover speed: 0.1
    });
</script>
