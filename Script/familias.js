// Familias.js - Lógica de la vista Familias

document.addEventListener('DOMContentLoaded', function() {
    // Referencias a los botones
    const btnMadre = document.getElementById('btn-agregar-madre');
    const btnPadre = document.getElementById('btn-agregar-padre');
    const btnCuidador = document.getElementById('btn-agregar-cuidador');
    const btnFamilia = document.getElementById('btn-agregar-familia');

    // Referencias a los formularios
    const formularios = {
        madre: document.getElementById('madre'),
        padre: document.getElementById('padre'),
        cuidador: document.getElementById('cuidador'),
        familia: document.getElementById('familia')
    };

    // Ocultar todos los formularios inicialmente
    Object.values(formularios).forEach(form => {
        if (form) form.style.display = 'none';
    });

    // Función para mostrar un formulario
    function mostrarFormulario(tipo) {
        Object.values(formularios).forEach(form => {
            if (form) form.style.display = 'none';
        });
        if (formularios[tipo]) formularios[tipo].style.display = 'flex';
    }

    // Event listeners para cada botón
    if (btnMadre) btnMadre.addEventListener('click', () => mostrarFormulario('madre'));
    if (btnPadre) btnPadre.addEventListener('click', () => mostrarFormulario('padre'));
    if (btnCuidador) btnCuidador.addEventListener('click', () => mostrarFormulario('cuidador'));
    if (btnFamilia) btnFamilia.addEventListener('click', () => mostrarFormulario('familia'));

    // Función para validar documento único
    window.validarDocumentoUnico = async function(tipo, tipoDoc, numDoc) {
        try {
            const formData = new FormData();
            formData.append('validar_documento', '1');
            formData.append('tipo', tipo);
            formData.append('tipo_documento', tipoDoc);
            formData.append('numero_documento', numDoc);
            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            return data.esUnico;
        } catch (error) {
            console.error('Error al validar documento:', error);
            return false;
        }
    }

    // Función para validar formularios
    window.validarFormulario = function(formulario) {
        const inputs = formulario.querySelectorAll('[required]');
        let isValid = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        if (!isValid) {
            mostrarAlerta('Por favor complete todos los campos obligatorios', 'error');
        }
        return isValid;
    }

    // Función para guardar registros
    window.guardarRegistro = async function(formData, tipo) {
        const botonSubmit = document.querySelector(`#form-${tipo} button[type="submit"]`);
        if (botonSubmit) botonSubmit.disabled = true;
        try {
            const response = await fetch('../Controladores/FamiliasController.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                mostrarAlerta(data.message, 'success');
                setTimeout(() => location.reload(), 2000);
            } else {
                mostrarAlerta(data.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarAlerta(`Error al registrar ${tipo}`, 'error');
        } finally {
            if (botonSubmit) botonSubmit.disabled = false;
        }
    }

    // Función para mostrar alertas
    window.mostrarAlerta = function(mensaje, tipo) {
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

    // Manejar notificaciones
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.remove();
        }, 5000);
    });
});

/**
 * Abre el modal de edición de familia y carga los datos en el formulario.
 * @param {Object} familia Objeto con los datos de la familia a editar
 */
function editarFamilia(familia) {
    document.getElementById('id_familia_editar').value = familia.Id_familia;
    document.getElementById('tipo_documento_familia_editar').value = familia.Tipo_documento;
    document.getElementById('numero_documento_familia_editar').value = familia.Numero_documento;
    document.getElementById('nombres_familia_editar').value = familia.Nombres;
    document.getElementById('apellidos_familia_editar').value = familia.Apellidos;
    document.getElementById('fecha_inscripcion_familia_editar').value = familia.Fecha_inscripcion;
    document.getElementById('tipo_usuario_familia_editar').value = familia.Tipo_usuario;
    document.getElementById('direccion_familia_editar').value = familia.Direccion;
    document.getElementById('madre_familia_editar').value = familia.Id_madre;
    document.getElementById('padre_familia_editar').value = familia.Id_padre;
    document.getElementById('cuidador_familia_editar').value = familia.Id_cuidador;
    btnAbrirModal('editar-familia-container');
}
