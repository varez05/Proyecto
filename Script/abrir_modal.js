const botones = document.querySelectorAll(".open-modal")
const modales = document.querySelectorAll(".modal");

console.log("Botones encontrados:", botones.length);
console.log("Modales encontrados:", modales.length);

botones.forEach((btn) => {
    btn.addEventListener("click", function(event) {
        event.stopPropagation();
        console.log("Botón clickeado:", btn.getAttribute("value"));

        modales.forEach((modal) => modal.classList.remove("show"));

        const idModal = btn.getAttribute("value");
        console.log("Intentando abrir modal con ID:", idModal);
        const modal = document.getElementById(`${idModal}`)
        
        if (modal) {
            modal.classList.add("show");
            console.log("Modal mostrado exitosamente");
        } else {
            console.error("No se encontró el modal con ID:", idModal);
        }
    });
});

document.querySelectorAll(".modal").forEach((modal) => {
    const btnClose = modal.querySelector(".close")
    if (btnClose) {
        btnClose.addEventListener("click", function(event) {
            event.stopPropagation();
            console.log("Cerrando modal por botón close");
            modal.classList.remove("show")
        });
    } else {
        console.warn("No se encontró botón close en modal");
    }
});

window.addEventListener("click", (event) => {
    const modalVisible = document.querySelector(".modal.show")
    if (modalVisible && !modalVisible.contains(event.target)) {
        console.log("Cerrando modal por click fuera");
        modalVisible.classList.remove("show");
    }
});