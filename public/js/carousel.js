document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.getElementById("carruselExample");
  const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);

  // Botones personalizados
  document.getElementById("prevBtn").addEventListener("click", () => {
    bsCarousel.prev();
  });

  document.getElementById("nextBtn").addEventListener("click", () => {
    bsCarousel.next();
  });

  // Función de barra de progreso (si ya la tienes)
  const interval = parseInt(carousel.getAttribute("data-bs-interval")) || 4000;
  let activeBar = null;

  function resetBars() {
    document.querySelectorAll(".progress").forEach((bar) => {
      bar.style.transition = "none";
      bar.style.width = "0%";
    });
  }

  function fillActiveBar() {
    resetBars();
    activeBar = document.querySelector(
      ".carousel-indicators button.active .progress"
    );
    if (!activeBar) return;

    setTimeout(() => {
      activeBar.style.transition = `width ${interval}ms linear`;
      activeBar.style.width = "100%";
    }, 50);
  }

  fillActiveBar();

  carousel.addEventListener("slid.bs.carousel", fillActiveBar);

  document.querySelectorAll(".carousel-indicators button").forEach((btn) => {
    btn.addEventListener("click", fillActiveBar);
  });
});