document.addEventListener("DOMContentLoaded", function () {
  const filtroBtns = document.querySelectorAll(".filtro-btn");
  const filas = document.querySelectorAll("#tablaPagos tbody tr");

  filtroBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      filtroBtns.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      const filtro = btn.getAttribute("data-filtro");

      filas.forEach((fila) => {
        if (filtro === "todos") {
          fila.style.display = "";
        } else {
          fila.style.display =
            fila.getAttribute("data-estado") === filtro ? "" : "none";
        }
      });
    });
  });

  
});
