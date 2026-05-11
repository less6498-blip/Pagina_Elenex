(function () {
    // Si no existe el carrusel en esta página, salir
    const bsEl = document.getElementById('carruselExample');
    if (!bsEl) return;

    const DURATION = 4000;
    const EXPAND_DELAY = 350;
    const BAR_WIDTH = 44;

    const dots = document.querySelectorAll('#carruselIndicators .yape-dot');
    const TOTAL = dots.length;
    let current = 0;
    let autoTimer = null;
    let expandTimeout = null;
    let fillRAF = null;
    let fillStart = null;
    let isTransitioning = false;

    function resetDot(dot) {
        dot.style.width = '8px';
        const fill = dot.querySelector('.yape-dot-fill');
        fill.style.transition = 'none';
        fill.style.width = '0px';
    }

    function activateDot(dot) {
        cancelAnimationFrame(fillRAF);
        clearTimeout(expandTimeout);
        dot.style.width = '8px';
        const fill = dot.querySelector('.yape-dot-fill');
        fill.style.transition = 'none';
        fill.style.width = '8px';

        expandTimeout = setTimeout(() => {
            dot.style.width = BAR_WIDTH + 'px';
            fillStart = null;
            const remaining = DURATION - EXPAND_DELAY;
            fillRAF = requestAnimationFrame(function tick(ts) {
                if (!fillStart) fillStart = ts;
                const progress = Math.min((ts - fillStart) / remaining, 1);
                fill.style.width = (8 + (BAR_WIDTH - 8) * progress) + 'px';
                if (progress < 1) fillRAF = requestAnimationFrame(tick);
            });
        }, EXPAND_DELAY);
    }

    bsEl.addEventListener('slide.bs.carousel', (e) => {
        resetDot(dots[current]);
        current = e.to;
        activateDot(dots[current]);
    });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index);
            bootstrap.Carousel.getInstance(bsEl).to(index);
        });
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        bootstrap.Carousel.getInstance(bsEl).prev();
    });
    document.getElementById('nextBtn').addEventListener('click', () => {
        bootstrap.Carousel.getInstance(bsEl).next();
    });

    activateDot(dots[0]);
})();