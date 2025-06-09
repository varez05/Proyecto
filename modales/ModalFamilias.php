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
        <form action="Familias.php" method="POST" class="form-modificar" id="form-familia">
            <div class="form-group">
                <label for="id_familia_comunidad_agregar">Comunidad:</label>
                <select id="id_familia_comunidad_agregar" name="id_comunidad" required>
                    <option value="">Seleccione una comunidad</option>
                </select>
            </div>
            <!-- Eliminado campo Fecha de Inscripción -->
            <!-- Eliminado campo Tipo de Usuario (se asigna automáticamente por JS) -->
            <div class="form-group">
                <label for="tipo_documento_agregar">Tipo de Documento:</label>
                <select id="tipo_documento_agregar" name="tipo_documento" required>
                    <option value="Registro Civil">Registro Civil</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero_documento_agregar">Número de Documento:</label>
                <input type="text" id="numero_documento_agregar" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="nombres_agregar">Nombres:</label>
                <input type="text" id="nombres_agregar" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="apellidos_agregar">Apellidos:</label>
                <input type="text" id="apellidos_agregar" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento_agregar">Fecha de Nacimiento:</label>
                <input max="<?php echo date('Y-m-d'); ?>" type="date" id="fecha_nacimiento_agregar" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="lugar_nacimiento_agregar">Lugar de Nacimiento:</label>
                <input type="text" id="lugar_nacimiento_agregar" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="sexo_agregar">Sexo:</label>
                <select id="sexo_agregar" name="sexo" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefono_agregar">Teléfono:</label>
                <input type="text" id="telefono_agregar" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="correo_agregar">Correo:</label>
                <input type="email" id="correo_agregar" name="correo" required>
            </div>
            <div class="form-group">
                <label for="autoreconicido_agregar">Autoreconocido:</label>
                <input type="text" id="autoreconicido_agregar" name="autoreconicido">
            </div>
            <div class="form-group">
                <label for="etnia_agregar">Etnia:</label>
                <input type="text" id="etnia_agregar" name="etnia">
            </div>
            <div class="form-group">
                <label for="cuidador_agregar">Cuidador:</label>
                <input type="text" id="cuidador_agregar" name="cuidador">
            </div>
            <div class="form-group">
                <label for="padre_agregar">Padre:</label>
                <input type="text" id="padre_agregar" name="padre">
            </div>
            <div class="form-group">
                <label for="madre_agregar">Madre:</label>
                <input type="text" id="madre_agregar" name="madre">
            </div>
            <div class="form-buttons">
                <button type="button">Guardar</button>
                <a class="btn-cancelar" onclick="cerrarModal('modal-modificar-familia')">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<!-- Modal para modificar familia -->
<div id="modal-modificar-familia" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-familia" class="close" onclick="cerrarModal('modal-modificar-familia')">&times;</span>
        <h2>Modificar Familia</h2>
        <form action="Familias.php" method="POST" class="form-modificar" id="form-familia-editar">
            <div class="form-group">
                <label for="id_familia_comunidad_editar">Comunidad:</label>
                <select id="id_familia_comunidad_editar" name="id_comunidad" required>
                    <option value="">Seleccione una comunidad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_documento_familia_editar">Tipo de Documento:</label>
                <select id="tipo_documento_familia_editar" name="tipo_documento" required>
                    <option value="Registro Civil">Registro Civil</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
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
                <label for="fecha_nacimiento_familia_editar">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento_familia_editar" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="lugar_nacimiento_familia_editar">Lugar de Nacimiento:</label>
                <input type="text" id="lugar_nacimiento_familia_editar" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="sexo_familia_editar">Sexo:</label>
                <select id="sexo_familia_editar" name="sexo" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefono_familia_editar">Teléfono:</label>
                <input type="text" id="telefono_familia_editar" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="correo_familia_editar">Correo:</label>
                <input type="email" id="correo_familia_editar" name="correo" required>
            </div>
            <div class="form-group">
                <label for="autoreconicido_familia_editar">Autoreconocido:</label>
                <input type="text" id="autoreconicido_familia_editar" name="autoreconicido">
            </div>
            <div class="form-group">
                <label for="etnia_familia_editar">Etnia:</label>
                <input type="text" id="etnia_familia_editar" name="etnia">
            </div>
            <div class="form-group">
                <label for="cuidador_familia_editar">Cuidador:</label>
                <input type="text" id="cuidador_familia_editar" name="cuidador">
            </div>
            <div class="form-group">
                <label for="padre_familia_editar">Padre:</label>
                <input type="text" id="padre_familia_editar" name="padre">
            </div>
            <div class="form-group">
                <label for="madre_familia_editar">Madre:</label>
                <input type="text" id="madre_familia_editar" name="madre">
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <a class="btn-cancelar" onclick="cerrarModal('modal-modificar-familia')">Cancelar</a>
            </div>
        </form>
    </div>
</div>

