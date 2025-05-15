// Mostrar el formulario de agregar unidad
function btnAbrirModal(identificador) {
    const modal = document.getElementById(identificador);
    if (modal) {
        modal.classList.add('show');
    }
}

// Ocultar el formulario de agregar unidad
function cerrarModal(identificador) {
    const modal = document.getElementById(identificador);
    if (modal) {
        modal.classList.remove('show');
    }
}

// Función para mostrar el mensaje desde la sesión
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


function inicializarFormularioAgregarUnidades() {
    const formulario = document.querySelector('.form-modificar');

    if (formulario) {
        formulario.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario

            const formData = new FormData(formulario); // Crear un FormData con los datos del formulario

            fetch('../Controladores/UnidadesController.php', {
                method: 'POST',
                body: formData // Enviar el FormData directamente
            })
            .then(response => response.json())
            .then(data => {
                console.log('Resultado de la creación:', data);
                
                mostrarMensaje(data);
                cerrarModal('agregar-container')

                if (data.success) {
                    location.reload(); // Recargar la página para reflejar los cambios
                }
                    
            })
            .catch(error => {
                console.error('Error al crear la unidad:', error);
            });
        });
    }
}

function eliminarUnidad(event, url) {
    event.preventDefault(); // Evitar la navegación predeterminada

    if (confirm('¿Estás seguro de que deseas eliminar esta unidad?')) {
        fetch(url, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resultado de la eliminación:', data);
            mostrarMensaje(data);

            if (data.success) {
                const fila = event.target.closest('tr');
                if (fila) {
                    fila.remove(); // Eliminar la fila de la tabla
                }
            }
        })
        .catch(error => {
            console.error('Error al eliminar la unidad:', error);
        });
    }
}

function editarUnidad(event, idUnidad, nombreUnidad) {
    event.preventDefault(); // Evitar cualquier acción predeterminada

    // Cargar los datos en el modal
    document.getElementById('id_unidad').value = idUnidad;
    document.getElementById('nombre-editar').value = nombreUnidad;

    // Mostrar el modal de edición
    document.getElementById('editar-container').style.display = 'block';

    // Manejar el envío del formulario de edición
    const formularioEditar = document.getElementById('form-editar');
    formularioEditar.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío tradicional del formulario

        const formData = new FormData(formularioEditar);

        fetch('../Controladores/UnidadesController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resultado de la edición:', data);
            mostrarMensaje(data);

            if (data.success) {
                location.reload(); // Recargar la página para reflejar los cambios
            }
        })
        .catch(error => {
            console.error('Error al editar la unidad:', error);
        });
    });
}

// Inicializar los botones de eliminar al cargar la página
inicializarFormularioAgregarUnidades();
