// Script/lideres.js

document.addEventListener('DOMContentLoaded', function () {
    const modalAgregar = document.getElementById('modal-agregar');
    const modalModificar = document.getElementById('modal-modificar');
    const btnAbrirModalAgregar = document.getElementById('btn-agregar');
    const btnCerrarModalAgregar = document.getElementById('btn-cerrar-modal');
    const btnCancelarModalAgregar = document.getElementById('btn-cancelar-modal');
    const btnCerrarModalModificar = document.getElementById('btn-cerrar-modal-modificar');
    const btnCancelarModalModificar = document.getElementById('btn-cancelar-modal-modificar');

    // Mostrar el modal de agregar
    btnAbrirModalAgregar.addEventListener('click', function () {
        modalAgregar.style.display = 'flex';
    });

    // Ocultar el modal de agregar
    btnCerrarModalAgregar.addEventListener('click', function () {
        modalAgregar.style.display = 'none';
    });
    btnCancelarModalAgregar.addEventListener('click', function () {
        modalAgregar.style.display = 'none';
    });

    // Mostrar el modal de modificar si existe
    if (modalModificar) {
        modalModificar.style.display = 'flex';
    }

    // Ocultar el modal de modificar
    btnCerrarModalModificar.addEventListener('click', function () {
        modalModificar.style.display = 'none';
    });
    btnCancelarModalModificar.addEventListener('click', function () {
        modalModificar.style.display = 'none';
    });

    // Ocultar los modales al hacer clic fuera del contenido
    window.addEventListener('click', function (event) {
        if (event.target === modalAgregar) {
            modalAgregar.style.display = 'none';
        }
        if (event.target === modalModificar) {
            modalModificar.style.display = 'none';
        }
    });

    const mensaje = document.getElementById('mensaje');
    if (mensaje) {
        setTimeout(() => {
            mensaje.style.display = 'none';
        }, 5000); // 5 segundos
    }
});
