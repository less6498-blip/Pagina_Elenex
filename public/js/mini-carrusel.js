/*document.addEventListener("DOMContentLoaded", function () {
  const track = document.querySelector(".carrusel-track");
  const totalItems = 3; // Sabemos que son 3 items (incluyendo clon)

  let index = 0;

  setInterval(() => {
    index++;
    track.style.transition = "transform 0.5s ease-in-out";
    track.style.transform = `translateX(-${index * 100}%)`;

    if (index === totalItems - 1) {
      setTimeout(() => {
        track.style.transition = "none";
        track.style.transform = "translateX(0)";
        index = 0;
      }, 500); // coincide con duración transición
    }
  }, 3000);
});*/