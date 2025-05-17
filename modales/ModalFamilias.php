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
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
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
                <label for="id_cuidador">ID Cuidador:</label>
                <select id="id_cuidador" name="id_cuidador">
                    <option value="">Seleccione un cuidador</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id_padre">ID Padre:</label>
                <select id="id_padre" name="id_padre">
                    <option value="">Seleccione un padre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id_madre">ID Madre:</label>
                <select id="id_madre" name="id_madre">
                    <option value="">Seleccione una madre</option>
                </select>
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
        <h2>Agregar Familia</h2>
        <form action="Familias.php" method="POST" class="form-modificar">
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
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
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
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
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
                <label for="id_cuidador">ID Cuidador:</label>
                <select id="id_cuidador" name="id_cuidador">
                    <option value="">Seleccione un cuidador</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id_padre">ID Padre:</label>
                <select id="id_padre" name="id_padre">
                    <option value="">Seleccione un padre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="id_madre">ID Madre:</label>
                <select id="id_madre" name="id_madre">
                    <option value="">Seleccione una madre</option>
                </select>
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" id="btn-cancelar-modal-familia" class="btn-cancelar" onclick="cerrarModal('modal-modificar-familia')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para agregar madre -->
<div id="modal-agregar-madre" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-madre" class="close" onclick="cerrarModal('modal-agregar-madre')">&times;</span>
        <h2>Agregar Madre</h2>
        <form action="Madre.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="madre_tipo_documento">Tipo de Documento:</label>
                <select id="madre_tipo_documento" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="madre_numero_documento">Número de Documento:</label>
                <input type="text" id="madre_numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="madre_nombres">Nombres:</label>
                <input type="text" id="madre_nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="madre_apellidos">Apellidos:</label>
                <input type="text" id="madre_apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="madre_fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="madre_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="madre_lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" id="madre_lugar_nacimiento" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="madre_sexo">Sexo:</label>
                <input type="text" id="madre_sexo" name="sexo" value="Femenino" readonly>
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" id="btn-cancelar-modal-madre" class="btn-cancelar" onclick="cerrarModal('modal-agregar-madre')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para modificar madre -->
<div id="modal-modificar-madre" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-madre" class="close" onclick="cerrarModal('modal-modificar-madre')">&times;</span>
        <h2>Agregar Madre</h2>
        <form action="Madre.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="madre_tipo_documento">Tipo de Documento:</label>
                <select id="madre_tipo_documento" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="madre_numero_documento">Número de Documento:</label>
                <input type="text" id="madre_numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="madre_nombres">Nombres:</label>
                <input type="text" id="madre_nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="madre_apellidos">Apellidos:</label>
                <input type="text" id="madre_apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="madre_fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="madre_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="madre_lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" id="madre_lugar_nacimiento" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="madre_sexo">Sexo:</label>
                <input type="text" id="madre_sexo" name="sexo" value="Femenino" readonly>
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" id="btn-cancelar-modal-madre" class="btn-cancelar" onclick="cerrarModal('modal-modificar-madre')">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal para agregar padre -->
<div id="modal-agregar-padre" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-padre" class="close" onclick="cerrarModal('modal-agregar-padre')">&times;</span>
        <h2>Agregar Padre</h2>
        <form action="Padre.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="padre_tipo_documento">Tipo de Documento:</label>
                <select id="padre_tipo_documento" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="padre_numero_documento">Número de Documento:</label>
                <input type="text" id="padre_numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="padre_nombres">Nombres:</label>
                <input type="text" id="padre_nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="padre_apellidos">Apellidos:</label>
                <input type="text" id="padre_apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="padre_fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="padre_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="padre_lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" id="padre_lugar_nacimiento" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="padre_sexo">Sexo:</label>
                <input type="text" id="padre_sexo" name="sexo" value="Masculino" readonly>
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" id="btn-cancelar-modal-padre" class="btn-cancelar" onclick="cerrarModal('modal-agregar-padre')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para modificar padre -->
<div id="modal-modificar-padre" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-padre" class="close" onclick="cerrarModal('modal-modificar-padre')">&times;</span>
        <h2>Agregar Padre</h2>
        <form action="Padre.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="padre_tipo_documento">Tipo de Documento:</label>
                <select id="padre_tipo_documento" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="padre_numero_documento">Número de Documento:</label>
                <input type="text" id="padre_numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="padre_nombres">Nombres:</label>
                <input type="text" id="padre_nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="padre_apellidos">Apellidos:</label>
                <input type="text" id="padre_apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="padre_fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="padre_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="padre_lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" id="padre_lugar_nacimiento" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="padre_sexo">Sexo:</label>
                <input type="text" id="padre_sexo" name="sexo" value="Masculino" readonly>
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" id="btn-cancelar-modal-padre" class="btn-cancelar" onclick="cerrarModal('modal-modificar-padre')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para agregar cuidador -->
<div id="modal-agregar-cuidador" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-cuidador" class="close" onclick="cerrarModal('modal-agregar-cuidador')">&times;</span>
        <h2>Agregar Cuidador</h2>
        <form action="Cuidador.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="cuidador_parentesco">Parentesco:</label>
                <select id="cuidador_parentesco" name="parentesco" required>
                    <option value="Padre">Padre</option>
                    <option value="Madre">Madre</option>
                    <option value="Hermano">Hermano/a</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cuidador_tipo_documento">Tipo de Documento:</label>
                <select id="cuidador_tipo_documento" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cuidador_numero_documento">Número de Documento:</label>
                <input type="text" id="cuidador_numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="cuidador_nombres">Nombres:</label>
                <input type="text" id="cuidador_nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="cuidador_apellidos">Apellidos:</label>
                <input type="text" id="cuidador_apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="cuidador_fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="cuidador_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="cuidador_lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" id="cuidador_lugar_nacimiento" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="cuidador_sexo">Sexo:</label>
                <select id="cuidador_sexo" name="sexo" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cuidador_telefono">Teléfono:</label>
                <input type="text" id="cuidador_telefono" name="telefono">
            </div>
            <div class="form-group">
                <label for="cuidador_correo">Correo:</label>
                <input type="email" id="cuidador_correo" name="correo">
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal('modal-agregar-cuidador')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para modificar cuidador -->
<div id="modal-modificar-cuidador" class="modal" >
    <div class="modal-content">
        <span id="btn-cerrar-modal-cuidador" class="close"  onclick="cerrarModal('modal-modificar-cuidador')">&times;</span>
        <h2>Agregar Cuidador</h2>
        <form action="Cuidador.php" method="POST" class="form-modificar">
            <div class="form-group">
                <label for="cuidador_parentesco">Parentesco:</label>
                <select id="cuidador_parentesco" name="parentesco" required>
                    <option value="Padre">Padre</option>
                    <option value="Madre">Madre</option>
                    <option value="Hermano">Hermano</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cuidador_tipo_documento">Tipo de Documento:</label>
                <select id="cuidador_tipo_documento" name="tipo_documento" required>
                    <option value="Cédula">Cédula</option>
                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                    <option value="Cédula Extranjería">Cédula Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cuidador_numero_documento">Número de Documento:</label>
                <input type="text" id="cuidador_numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="cuidador_nombres">Nombres:</label>
                <input type="text" id="cuidador_nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="cuidador_apellidos">Apellidos:</label>
                <input type="text" id="cuidador_apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="cuidador_fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="cuidador_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="cuidador_lugar_nacimiento">Lugar de Nacimiento:</label>
                <input type="text" id="cuidador_lugar_nacimiento" name="lugar_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="cuidador_sexo">Sexo:</label>
                <select id="cuidador_sexo" name="sexo" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cuidador_telefono">Teléfono:</label>
                <input type="text" id="cuidador_telefono" name="telefono">
            </div>
            <div class="form-group">
                <label for="cuidador_correo">Correo:</label>
                <input type="email" id="cuidador_correo" name="correo">
            </div>
            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <button type="button" id="btn-cancelar-modal-cuidador" class="btn-cancelar" onclick="cerrarModal('modal-modificar-cuidador')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

