document.addEventListener("DOMContentLoaded", () => {
  const reveals = document.querySelectorAll(".reveal");

  if (!("IntersectionObserver" in window)) {
    // Fallback para navegadores antiguos
    reveals.forEach(el => el.classList.add("active"));
    return;
  }

  const observer = new IntersectionObserver((entries, observerInstance) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("active");
        observerInstance.unobserve(entry.target); // 🔥 evita observaciones innecesarias
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: "0px 0px -100px 0px"
  });

  reveals.forEach(el => observer.observe(el));
});