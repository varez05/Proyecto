function btnAbrirModal(identificador) {
    const modal = document.getElementById(identificador);
    if (modal) {
        modal.classList.add('show');
        console.log("abrir", modal)
    }
}

function cerrarModal(identificador) {
    const modal = document.getElementById(identificador);
    if (modal) {
        modal.classList.remove('show');
    }
}

function mostrarMensaje(mensaje) {
    const mensajeDiv = document.getElementById('mensaje');
    if (mensajeDiv) {
        mensajeDiv.textContent = mensaje.message;
        mensajeDiv.style.display = 'block';

        // Eliminar el mensaje después de 4 segundos
        setTimeout(() => {
            mensajeDiv.style.display = 'none';
            mensajeDiv.textContent = '';
        }, 4000);
    }
}