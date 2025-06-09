/**
 * Abre el modal de edición de comunidad y carga los datos en el formulario.
 * @param {Object} comunidad Objeto con los datos de la comunidad a editar
 */
function editarComunidad(comunidad) {
    // Cargar los datos en el formulario de edición
    document.getElementById('id_comunidad_editar').value = comunidad.Id_comunidad;
    document.getElementById('nombre_comunidad_editar').value = comunidad.Nombre_comunidad;
    document.getElementById('autoridad_editar').value = comunidad.Autoridad;

    // Cargar las unidades dinámicamente y seleccionar la unidad por defecto
    cargarUnidadesEditar(comunidad.Id_unidad);

    // Abrir el modal de edición
    btnAbrirModal('editar-comunidad-container');

    // Ajustar el envío AJAX para editar comunidad
    const formularioEditar = document.getElementById('form-editar-comunidad');
    if (formularioEditar) {
        // Eliminar cualquier listener previo para evitar múltiples recargas
        const nuevoFormulario = formularioEditar.cloneNode(true);
        formularioEditar.parentNode.replaceChild(nuevoFormulario, formularioEditar);
        nuevoFormulario.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(nuevoFormulario);
            formData.append('accion', 'actualizar');
            try {
                const response = await fetch('../Controladores/ComunidadesController.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                mostrarAlerta(data.message, data.success ? 'success' : 'error');
                if (data.success) {
                    cerrarModal('editar-comunidad-container');
                   setTimeout(() => location.reload(), 1500);
                }
            } catch (error) {
                mostrarAlerta('Error al procesar la solicitud', 'error');
            }
        });
    }
}

function eliminarComunidadHandler(event, idEliminar) {
    event.preventDefault();
    if (!confirm('¿Está seguro de eliminar esta comunidad?')) return;
    fetch(`../Controladores/ComunidadesController.php?eliminar=${idEliminar}`, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        mostrarAlerta(data.message, data.success ? 'success' : 'error');
        if (data.success) setTimeout(() => location.reload(), 1500);
    })
    .catch(() => mostrarAlerta('Error al eliminar', 'error'));
}


// Función para inicializar las opciones del formulario de agregar comunidad
function inicializarFormularioAgregar(unidades) {
    const selectUnidad = document.getElementById('id_unidad');
    selectUnidad.innerHTML = '<option value="">Seleccione una unidad</option>';
    unidades.forEach(unidad => {
        const option = document.createElement('option');
        option.value = unidad.Id_unidad;
        option.textContent = unidad.Nombre;
        selectUnidad.appendChild(option);
    });
}

// Función para inicializar las opciones del formulario de editar comunidad
function inicializarFormularioEditar(unidades) {
    const selectUnidadEditar = document.getElementById('id_unidad_editar');
    selectUnidadEditar.innerHTML = '<option value="">Seleccione una unidad</option>';
    unidades.forEach(unidad => {
        const option = document.createElement('option');
        option.value = unidad.Id_unidad;
        option.textContent = unidad.Nombre;
        selectUnidadEditar.appendChild(option);
    });
}

// Función para cargar unidades dinámicamente y seleccionar la unidad por defecto
async function cargarUnidadesEditar(idUnidadSeleccionada) {
    try {
        const response = await fetch('../Controladores/UnidadesController.php?obtener_unidades');
        const unidades = await response.json();

        const selectUnidadEditar = document.getElementById('id_unidad_editar');
        selectUnidadEditar.innerHTML = '<option value="">Seleccione una unidad</option>';

        unidades.forEach(unidad => {
            const option = document.createElement('option');
            option.value = unidad.Id_unidad;
            option.textContent = unidad.Nombre;
            if (unidad.Id_unidad == idUnidadSeleccionada) {
                option.selected = true; // Seleccionar la unidad por defecto
            }
            selectUnidadEditar.appendChild(option);
        });
    } catch (error) {
        console.error('Error al cargar las unidades:', error);
    }
}

// Función para abrir el modal de creación y cargar las unidades dinámicamente
async function abrirModalCrearComunidad() {
    try {
        const response = await fetch('../Controladores/UnidadesController.php?obtener_unidades');
        const unidades = await response.json();

        const selectUnidad = document.getElementById('id_unidad_comunidades');
        selectUnidad.innerHTML = '<option value="">Seleccione una unidad</option>';

        unidades.forEach(unidad => {
            const option = document.createElement('option');
            option.value = unidad.Id_unidad;
            option.textContent = unidad.Nombre;
            selectUnidad.appendChild(option);
        });

        // Abrir el modal de creación
        btnAbrirModal('agregar-comunidad-container');
    } catch (error) {
        console.error('Error al cargar las unidades:', error);
    }
}

// Envío AJAX del formulario de agregar comunidad
const formAgregar = document.getElementById('form-agregar-comunidad');
if (formAgregar) {
    formAgregar.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(formAgregar);
        try {
            const response = await fetch('../Controladores/ComunidadesController.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            mostrarAlerta(data.message, data.success ? 'success' : 'error');
            if (data.success) {
                cerrarModal('agregar-comunidad-container');
                setTimeout(() => location.reload(), 1500);
            }
        } catch (error) {
            mostrarAlerta('Error al procesar la solicitud', 'error');
        }
    });

}
 function mostrarAlerta(mensaje, tipo) {
        const alerta = document.createElement('div');
        alerta.className = `alert alert-${tipo}`;
        alerta.textContent = mensaje;
        alerta.style.position = 'fixed';
        alerta.style.top = '20px';
        alerta.style.right = '20px';
        alerta.style.zIndex = '9999';
        document.body.appendChild(alerta);
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
