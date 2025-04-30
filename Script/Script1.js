const cloud = document.getElementById("cloud"),
barralateral = document.querySelector(".barra-lateral"),
spans = document.querySelectorAll("Span"),
palanca = document.querySelector(".switch"),
circulo = document.querySelector(".circulo");

palanca.addEventListener("click", () => {
    let body = document.body;
    body.classList.toggle("modo-black"); 
    circulo.classList.toggle("prendido"); 
});

cloud.addEventListener("click", () => {
    barralateral.classList.toggle("mini-barra-lateral");
    spans.forEach((span) => {
        span.classList.toggle("oculto")});
});