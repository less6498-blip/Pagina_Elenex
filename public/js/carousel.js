(function () {

    const bsEl = document.getElementById('carruselExample');

    // IMPORTANTE:
    // si el carrusel no existe en esta página,
    // detenemos el script
    if (!bsEl) return;

    const DURATION = 4000;
    const EXPAND_DELAY = 350;
    const BAR_WIDTH = 44;

    const dots = document.querySelectorAll('#carruselIndicators .yape-dot');

    // seguridad extra
    if (!dots.length) return;

    const TOTAL = dots.length;

    let current = 0;
    let autoTimer = null;
    let expandTimeout = null;
    let fillRAF = null;
    let fillStart = null;
    let isTransitioning = false;

    function resetDot(dot) {

        if (!dot) return;

        dot.style.width = '8px';

        const fill = dot.querySelector('.yape-dot-fill');

        if (!fill) return;

        fill.style.transition = 'none';
        fill.style.width = '0px';
    }

    function activateDot(dot) {

        if (!dot) return;

        cancelAnimationFrame(fillRAF);
        clearTimeout(expandTimeout);

        dot.style.width = '8px';

        const fill = dot.querySelector('.yape-dot-fill');

        if (!fill) return;

        fill.style.transition = 'none';
        fill.style.width = '8px';

        expandTimeout = setTimeout(() => {

            dot.style.width = BAR_WIDTH + 'px';

            fillStart = null;

            const remaining = DURATION - EXPAND_DELAY;

            fillRAF = requestAnimationFrame(function tick(ts) {

                if (!fillStart) fillStart = ts;

                const progress =
                    Math.min((ts - fillStart) / remaining, 1);

                fill.style.width =
                    (8 + (BAR_WIDTH - 8) * progress) + 'px';

                if (progress < 1) {
                    fillRAF = requestAnimationFrame(tick);
                }

            });

        }, EXPAND_DELAY);
    }

    // Bootstrap event
    bsEl.addEventListener('slide.bs.carousel', (e) => {

        resetDot(dots[current]);

        current = e.to;

        activateDot(dots[current]);
    });

    // Click dots
    dots.forEach(dot => {

        dot.addEventListener('click', () => {

            const index = parseInt(dot.dataset.index);

            const carousel = bootstrap.Carousel.getInstance(bsEl);

            if (carousel) {
                carousel.to(index);
            }
        });
    });

    // Flechas
    const prevBtn = document.getElementById('prevBtn');

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {

            const carousel = bootstrap.Carousel.getInstance(bsEl);

            if (carousel) {
                carousel.prev();
            }
        });
    }

    const nextBtn = document.getElementById('nextBtn');

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {

            const carousel = bootstrap.Carousel.getInstance(bsEl);

            if (carousel) {
                carousel.next();
            }
        });
    }

    activateDot(dots[0]);

})();