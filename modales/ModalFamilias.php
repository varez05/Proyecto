<script src="../Script/comunidades_familias.js"></script>
<!-- Modal para agregar familia -->
 <?php
// Configurar la zona horaria de Colombia
date_default_timezone_set('America/Bogota');
?>
<div id="modal-agregar-familia" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-familia" class="close" onclick="cerrarModal('modal-agregar-familia')">&times;</span>
        <h2>Agregar Familia</h2>
        <form action="Familias.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="id_familia_comunidad">Comunidad:</label>
                <select id="id_familia_comunidad" name="id_comunidad" required>
                    <option value="">Seleccione una comunidad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_inscripcion">Fecha de Inscripción:</label>
                <input type="date" id="fecha_inscripcion" name="fecha_inscripcion" required>
            </div>
            <div class="form-group">
                <label for="tipo_usuario">Tipo de Usuario:</label>
                <input type="text" id="tipo_usuario" name="tipo_usuario" required>
            </div>
            <div class="form-group">
                <label for="tipo_documento">Tipo de Documento:</label>
                <select id="tipo_documento" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero_documento">Número de Documento:</label>
                <input type="text" id="numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input max="<?php echo date('Y-m-d'); ?>" type="date"
                 id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" id="lugar_nacimiento" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="autoreconicido">Autoreconocido:</label>
                <input type="text" id="autoreconicido" name="autoreconicido">
            </div>
            <div class="form-group">
                <label for="etnia">Etnia:</label>
                <input type="text" id="etnia" name="etnia">
            </div>
            <div class="form-group">
                <label for="cuidador">Cuidador:</label>
                <input type="text" id="cuidador" name="cuidador">
            </div>
            <div class="form-group">
                <label for="padre">Padre:</label>
                <input type="text" id="padre" name="padre">
            </div>
            <div class="form-group">
                <label for="madre">Madre:</label>
                <input type="text" id="madre" name="madre">
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" id="btn-cancelar-modal-familia" class="btn-cancelar" onclick="cerrarModal('modal-agregar-familia')">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal para modificar familia -->
<div id="modal-modificar-familia" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-familia" class="close" onclick="cerrarModal('modal-modificar-familia')">&times;</span>
        <h2>Modificar Familia</h2>
        <h2>Modificar Familia</h2>
        <form action="Familias.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="id_familia_comunidad">Comunidad:</label>
                <select id="id_familia_comunidad" name="id_comunidad" required>
                    <option value="">Seleccione una comunidad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_inscripcion_familia_editar">Fecha de Inscripción:</label>
                <input type="date" id="fecha_inscripcion_familia_editar" name="fecha_inscripcion" required>
            </div>
            <div class="form-group">
                <label for="tipo_usuario_familia_editar">Tipo de Usuario:</label>
                <input type="text" id="tipo_usuario_familia_editar" name="tipo_usuario" required>
            </div>
            <div class="form-group">
                <label for="tipo_documento_familia_editar">Tipo de Documento:</label>
                <select id="tipo_documento_familia_editar" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero_documento_familia_editar">Número de Documento:</label>
                <input type="text" id="numero_documento_familia_editar" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="nombres_familia_editar">Nombres:</label>
                <input type="text" id="nombres_familia_editar" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="apellidos_familia_editar">Apellidos:</label>
                <input type="text" id="apellidos_familia_editar" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="direccion_familia_editar">Dirección:</label>
                <input type="text" id="direccion_familia_editar" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="madre_familia_editar">ID Madre:</label>
                <select id="madre_familia_editar" name="id_madre">
                    <option value="">Seleccione una madre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="autoreconicido">Autoreconocido:</label>
                <input type="text" id="autoreconicido" name="autoreconicido">
            </div>
            <div class="form-group">
                <label for="etnia">Etnia:</label>
                <input type="text" id="etnia" name="etnia">
            </div>
            <div class="form-group">
                <label for="cuidador">Cuidador:</label>
                <input type="text" id="cuidador" name="cuidador">
            </div>
            <div class="form-group">
                <label for="padre">Padre:</label>
                <input type="text" id="padre" name="padre">
            </div>
            <div class="form-group">
                <label for="madre">Madre:</label>
                <input type="text" id="madre" name="madre">
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal('modal-modificar-familia')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

