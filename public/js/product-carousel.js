document.addEventListener("DOMContentLoaded", function () {

  function setupCarousel(carouselId, prevId, nextId) {
    const carousel = document.getElementById(carouselId);
    const prevBtn = document.getElementById(prevId);
    const nextBtn = document.getElementById(nextId);

    if (!carousel || !prevBtn || !nextBtn) return;

    const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);

    function updateArrows() {
      const items = carousel.querySelectorAll(".carousel-item");
      const activeIndex = [...items].findIndex(item =>
        item.classList.contains("active")
      );

      prevBtn.style.display = activeIndex === 0 ? "none" : "flex";
      nextBtn.style.display = activeIndex === items.length - 1 ? "none" : "flex";
    }

    updateArrows();

    nextBtn.addEventListener("click", () => {
      bsCarousel.next();
      setTimeout(updateArrows, 100); // espera que cambie el slide
    });

    prevBtn.addEventListener("click", () => {
      bsCarousel.prev();
      setTimeout(updateArrows, 100);
    });

    carousel.addEventListener("slid.bs.carousel", updateArrows);
  }

  // Activar todos los carruseles
  setupCarousel("productCarousel", "prevProduct", "nextProduct");
  setupCarousel("productCarousel2", "prevProduct2", "nextProduct2");
  setupCarousel("productCarousel3","prevProduct3","nextProduct3");

  window.addEventListener("load", () => {
  document.body.classList.add("loaded");
});
});