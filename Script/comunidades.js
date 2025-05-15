// Script para Comunidades

function inicializarComunidades() {
    // Mostrar/ocultar formulario
    function toggleForm(esEditar = false) {
        const formModal = document.getElementById('formModal');
        formModal.style.display = formModal.style.display === 'flex' ? 'none' : 'flex';
        if (!esEditar) {
            document.getElementById('formularioComunidad').reset();
            document.getElementById('tituloFormulario').textContent = 'Registrar Nueva Comunidad';
            document.getElementById('accion').value = 'agregar';
            document.getElementById('id_comunidad').value = '';
        }
    }

    // Mostrar/ocultar menú desplegable
    function toggleDropdown(id) {
        document.querySelectorAll('.dropdown-content').forEach(function(menu) {
            if (menu.id !== 'menu-' + id) {
                menu.classList.remove('show');
            }
        });
        document.getElementById('menu-' + id).classList.toggle('show');
    }

    // Cerrar los menús al hacer clic fuera de ellos
    function cerrarMenus(event) {
        if (!event.target.matches('.menu-icon')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

    // Asignar el evento de clic global
    window.onclick = cerrarMenus;

    // Envío AJAX del formulario de comunidad
    const form = document.getElementById('formularioComunidad');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            try {
                const response = await fetch('../Controladores/ComunidadesController.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                mostrarAlerta(data.message, data.success ? 'success' : 'error');
                if (data.success) setTimeout(() => location.reload(), 1500);
            } catch (error) {
                mostrarAlerta('Error al procesar la solicitud', 'error');
            }
        });
    }

    // Envío AJAX para eliminar comunidad
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            if (!confirm('¿Está seguro de eliminar esta comunidad?')) return;
            const url = this.getAttribute('href');
            try {
                const response = await fetch(url.replace('?', '../Controladores/ComunidadesController.php?'), {
                    method: 'GET'
                });
                const data = await response.json();
                mostrarAlerta(data.message, data.success ? 'success' : 'error');
                if (data.success) setTimeout(() => location.reload(), 1500);
            } catch (error) {
                mostrarAlerta('Error al eliminar', 'error');
            }
        });
    });
}

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

    // Manejar el envío del formulario de edición
    const formularioEditar = document.getElementById('form-editar-comunidad');
    formularioEditar.addEventListener('submit', async function(event) {
        event.preventDefault(); // Evitar el envío tradicional del formulario

        const formData = new FormData(formularioEditar);

        try {
            const response = await fetch('../Controladores/ComunidadesController.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            mostrarAlerta(data.message, data.success ? 'success' : 'error');

            if (data.success) {
                cerrarModal('editar-comunidad-container');
                setTimeout(() => location.reload(), 1500); // Recargar la página para reflejar los cambios
            }
        } catch (error) {
            console.error('Error al editar la comunidad:', error);
            mostrarAlerta('Error al procesar la solicitud', 'error');
        }
    });
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