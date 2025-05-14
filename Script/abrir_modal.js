// Obtener elementos
const modal = document.getElementById("myModal");
const closeModal = document.querySelector(".btnclose");
const modalBody = document.getElementById("modal-body");

// Mostrar la ventana modal y cargar contenido
function showModal() {
    fetch('../vista/Contactanos.php')
        .then(response => response.text())
        .then(data => {
            // Agregar el enlace al CSS dentro del contenido cargado
            modalBody.innerHTML = data;
            modal.style.display = "block";
        })
        .catch(error => console.error('Error al cargar el contenido:', error));
}

// Cerrar la ventana modal
closeModal.onclick = function() {
    modal.style.display = "none";
};

// Cerrar la ventana modal al hacer clic fuera de ella
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};