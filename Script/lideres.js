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
    // No se carga la imagen por seguridad
    btnAbrirModal('editar-lider-container');
}

// Manejar el envío del formulario de edición
const formularioEditarLider = document.getElementById('form-editar-lider');
if (formularioEditarLider) {
    formularioEditarLider.addEventListener('submit', function(event) {
        // El formulario ya tiene action y method, se envía normalmente
        // Si quieres hacerlo por AJAX, aquí puedes implementarlo
        // event.preventDefault();
        // ...
    });
}