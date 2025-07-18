const cloud = document.getElementById("cloud"),
barralateral = document.querySelector(".barra-lateral"),
spans = document.querySelectorAll("Span"),
palanca = document.querySelector(".switch"),
circulo = document.querySelector(".circulo"),
menu = document.querySelector(".menu"),
main = document.querySelector("main");

menu.addEventListener("click", () => {
    barralateral.classList.toggle("max-barra-lateral");
    if (barralateral.classList.contains("max-barra-lateral")) {
        menu.children[0].style.display = "none";
        menu.children[1].style.display = "block"; 
    }else {
        menu.children[0].style.display = "block";
        menu.children[1].style.display = "none";          
    }
    if (window.innerWidth < 320) {
        barralateral.classList.add("mini-barra-lateral");
        main.classList.add("min-main");
         spans.forEach((span) => {span.classList.add("oculto")});
    }
});


cloud.addEventListener("click", () => {
    barralateral.classList.toggle("mini-barra-lateral");
    main.classList.toggle("min-main");
    spans.forEach((span) => {
        span.classList.toggle("oculto")});
});