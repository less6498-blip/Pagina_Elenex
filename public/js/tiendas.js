document.addEventListener('DOMContentLoaded', () => {

    const slides = document.querySelectorAll('.carousel-slide');
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');

    let index = 0;

    function updateCarousel() {
        slides.forEach(slide => slide.classList.remove('active'));
        slides[index].classList.add('active');

        prevBtn.style.display = index === 0 ? 'none' : 'block';
        nextBtn.style.display = index === slides.length - 1 ? 'none' : 'block';
    }

    updateCarousel(); // importante al cargar

    nextBtn.addEventListener('click', () => {
        if (index < slides.length - 1) {
            index++;
            updateCarousel();
        }
    });

    prevBtn.addEventListener('click', () => {
        if (index > 0) {
            index--;
            updateCarousel();
        }
    });

});