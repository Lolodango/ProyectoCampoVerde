document.addEventListener("DOMContentLoaded", function () {
   
  const metodoPago = document.getElementById("metodoPago");
    const seccionTarjeta = document.getElementById("seccionTarjeta");

    metodoPago.addEventListener("change", function () {
      if (this.value === "tarjeta") {
        seccionTarjeta.style.display = "block";
      } else {
        seccionTarjeta.style.display = "none";
      }
    });
    
});