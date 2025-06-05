<script src="../Script/comunidades_familias.js"></script>
<!-- Modal para agregar familia -->
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
                <button type="button" id="btn-cancelar-modal-familia" class="btn-cancelar" onclick="cerrarModal('modal-modificar-familia')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

