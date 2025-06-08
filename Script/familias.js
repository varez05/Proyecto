// Familias.js - Lógica de la vista Familias
document.addEventListener('DOMContentLoaded', function() {
    // Referencia al botón de familia
    const btnFamilia = document.getElementById('btn-agregar-familia');

    // Referencia al formulario de familia
    const formularioFamilia = document.getElementById('familia');

    // Ocultar el formulario inicialmente
    if (formularioFamilia) formularioFamilia.style.display = 'none';

    // Función para mostrar el formulario de familia
    function mostrarFormularioFamilia() {
        if (formularioFamilia) formularioFamilia.style.display = 'flex';
    }

    // Event listener para el botón de familia
    if (btnFamilia) btnFamilia.addEventListener('click', mostrarFormularioFamilia);

    // Función para validar documento único
    async function validarDocumentoUnico(tipo, tipoDoc, numDoc) {
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
    function validarFormulario(formulario) {
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
    async function guardarRegistro(formData, tipo) {
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

    // Manejar notificaciones
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.remove();
        }, 5000);
    });

    // Interceptar el envío del formulario para validar edad y tipo de usuario
    const formFamilia = document.getElementById('form-familia');
    if (formFamilia) {
        formFamilia.addEventListener('submit', function(event) {
            event.preventDefault();
            // Validar campos obligatorios
            if (!validarFormulario(formFamilia)) return;
            // Obtener fecha de nacimiento
            const fechaNacimiento = formFamilia.querySelector('#fecha_nacimiento').value;
            if (!fechaNacimiento) {
                mostrarAlerta('Debe ingresar la fecha de nacimiento', 'error');
                return;
            }
            // Calcular edad
            const hoy = new Date();
            const nacimiento = new Date(fechaNacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const m = hoy.getMonth() - nacimiento.getMonth();
            if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }
            // Asignar tipo de usuario según la edad
            let tipoUsuario = '';
            if (edad >= 0 && edad <= 5) {
                tipoUsuario = 'A';
            } else if (edad >= 6 && edad <= 14) {
                tipoUsuario = 'C';
            } else {
                mostrarAlerta('Solo se pueden registrar niños de 0 a 14 años', 'error');
                return;
            }
            // Crear FormData y agregar tipo_usuario
            const formData = new FormData(formFamilia);
            formData.append('tipo_usuario', tipoUsuario);
            // Enviar datos al backend
            guardarRegistro(formData, 'familia');
        });
    }
});

/**
 * Abre el modal de edición de familia y carga los datos en el formulario.
 * @param {Object} familia Objeto con los datos de la familia a editar
 */
function editarFamilia(familia) {
    document.getElementById('id_familia_editar').value = familia.Id_familia;
    document.getElementById('fecha_inscripcion_familia_editar').value = familia.Fecha_inscripcion;
    document.getElementById('id_comunidad_familia_editar').value = familia.Id_comunidad;
    document.getElementById('tipo_usuario_familia_editar').value = familia.Tipo_usuario;
    document.getElementById('tipo_documento_familia_editar').value = familia.Tipo_documento;
    document.getElementById('numero_documento_familia_editar').value = familia.Numero_documento;
    document.getElementById('nombres_familia_editar').value = familia.Nombres;
    document.getElementById('apellidos_familia_editar').value = familia.Apellidos;
    document.getElementById('fecha_nacimiento_familia_editar').value = familia.Fecha_nacimiento;
    document.getElementById('lugar_nacimiento_familia_editar').value = familia.Lugar_nacimiento;
    document.getElementById('sexo_familia_editar').value = familia.Sexo;
    document.getElementById('telefono_familia_editar').value = familia.Telefono;
    document.getElementById('correo_familia_editar').value = familia.Correo;
    document.getElementById('autoreconicido_familia_editar').value = familia.Autoreconicido;
    document.getElementById('etnia_familia_editar').value = familia.Etnia;
    document.getElementById('cuidador_familia_editar').value = familia.Cuidador;
    document.getElementById('padre_familia_editar').value = familia.Padre;
    document.getElementById('madre_familia_editar').value = familia.Madre;
    btnAbrirModal('editar-familia-container');
}
function editarMadres(madre) {
    console.log(madre);
    document.getElementById('id_madre_editar').value = madre.Id_madre;
    document.getElementById('madre_tipo_documento_editar').value = madre.Tipo_documento;
    document.getElementById('madre_numero_documento_editar').value = madre.Numero_documento;
    document.getElementById('madre_nombres_editar').value = madre.Nombres;
    document.getElementById('madre_apellidos_editar').value = madre.Apellidos;
    document.getElementById('madre_fecha_nacimiento_editar').value = madre.Fecha_nacimiento;
    document.getElementById('madre_lugar_nacimiento_editar').value = madre.Lugar_nacimiento;
    // El campo sexo es readonly y siempre es "Femenino", no es necesario modificarlo
    btnAbrirModal('modal-modificar-madre');
}