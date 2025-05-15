// Script para Comunidades

document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar formulario
    window.toggleForm = function(esEditar = false) {
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
    window.toggleDropdown = function(id) {
        document.querySelectorAll('.dropdown-content').forEach(function(menu) {
            if (menu.id !== 'menu-' + id) {
                menu.classList.remove('show');
            }
        });
        document.getElementById('menu-' + id).classList.toggle('show');
    }

    // Cerrar los menús al hacer clic fuera de ellos
    window.onclick = function(event) {
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

    // Ocultar el mensaje después de 5 segundos
    setTimeout(function() {
        const mensaje = document.getElementById('mensaje');
        if (mensaje) {
            mensaje.style.transition = 'opacity 0.5s ease';
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.style.display = 'none', 500);
        }
    }, 5000);

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

    // Función para mostrar alertas
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

    /**
     * Abre el modal de edición de comunidad y carga los datos en el formulario.
     * @param {Object} comunidad Objeto con los datos de la comunidad a editar
     */
    function editarComunidad(comunidad) {
        document.getElementById('id_comunidad').value = comunidad.Id_comunidad;
        document.getElementById('nombre_comunidad_editar').value = comunidad.Nombre_comunidad;
        document.getElementById('autoridad_comunidad_editar').value = comunidad.Autoridad;
        document.getElementById('unidad_comunidad_editar').value = comunidad.Id_unidad;
        btnAbrirModal('editar-comunidad-container');
    }
});
