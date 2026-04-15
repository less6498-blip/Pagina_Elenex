const slides = document.querySelectorAll('.carousel-slide');
const prev   = document.querySelector('.prev');
const next   = document.querySelector('.next');
let current  = 0;

function goTo(n) {
  slides[current].classList.remove('active');
  current = (n + slides.length) % slides.length;
  slides[current].classList.add('active');
  prev.style.display = current === 0               ? 'none' : 'block';
  next.style.display = current === slides.length - 1 ? 'none' : 'block';
}

prev.addEventListener('click', () => goTo(current - 1));
next.addEventListener('click', () => goTo(current + 1));
goTo(0);