/**
 * Abre el modal de edición de líder y carga los datos en el formulario.
 * @param {Object} lider Objeto con los datos del líder a editar
 */
function editarLider(lider) {
    // Cargar los datos en el formulario de edición
    document.getElementById('id_lider_editar').value = lider.Id_lider;
    document.getElementById('tipo_documento_editar').value = lider.Tipo_documento;
    document.getElementById('numero_documento_editar').value = lider.Numero_documento;
    document.getElementById('nombres_editar').value = lider.Nombres;
    document.getElementById('apellidos_editar').value = lider.Apellidos;
    document.getElementById('fecha_nacimiento_editar').value = lider.Fecha_nacimiento;
    document.getElementById('sexo_editar').value = lider.Sexo;
    document.getElementById('correo_editar').value = lider.Correo;
    document.getElementById('telefono_editar').value = lider.Telefono;
    document.getElementById('rol_editar').value = lider.Rol;

    // Mostrar la imagen actual (si existe)
    const imgPreview = document.getElementById('img_preview_editar');
    if (imgPreview) {
        if (lider.Img && lider.Img !== "") {
            imgPreview.src = "../uploads/" + lider.Img;
            imgPreview.style.display = "block";
        } else {
            imgPreview.style.display = "none";
        }
    }

    btnAbrirModal('editar-lider-container');
}

// Envío AJAX del formulario de agregar líder
const formAgregarLider = document.getElementById('form-agregar-lider');
if (formAgregarLider) {
    formAgregarLider.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(formAgregarLider);

        const response = await fetch('../Controladores/LideresController.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        mostrarMensaje(data);
        if (data.success) {
            cerrarModal('agregar-lider-container');
            setTimeout(() => location.reload(), 1500);
        }

    });
}

// Envío AJAX del formulario de editar líder
const formEditarLider = document.getElementById('form-editar-lider');
if (formEditarLider) {
    formEditarLider.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(formEditarLider);

        const response = await fetch('../Controladores/LideresController.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        mostrarMensaje(data);
        if (data.success) {
            cerrarModal('editar-lider-container');
            setTimeout(() => location.reload(), 1500);
        }

    });
}

// Manejo de eliminación de líder
function eliminarLiderHandler(event, idEliminar) {
    event.preventDefault();
    if (!confirm('¿Está seguro de eliminar este líder?')) return;
    fetch(`../Controladores/LideresController.php?eliminar=${idEliminar}`, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        mostrarMensaje(data);
        if (data.success) setTimeout(() => location.reload(), 1500);
    })
    .catch(() => mostrarAlerta('Error al eliminar', 'error'));
}