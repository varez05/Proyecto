<!-- Modal para agregar Comunidad -->
<div class="modal" id="agregar-comunidad-container">
    <div class="modal-content">
        <h2>Agregar Comunidad</h2>
        <form id="form-agregar-comunidad" method="post" action="../Controladores/ComunidadesController.php" class="form-modificar">
            <input type="hidden" id="accion" name="accion" value="agregar">
            <input type="hidden" id="id_comunidad" name="id_comunidad" value="">
            <div class="form-group">
                <label for="nombre_comunidad">Nombre de la Comunidad:</label>
                <input type="text" id="nombre_comunidad" name="nombre_comunidad" required>
            </div>
            <div class="form-group">
                <label for="autoridad">Autoridad:</label>
                <input type="text" id="autoridad" name="autoridad" required>
            </div>
            <div class="form-group">
                <label for="direccion_comunidad">Dirección:</label>
                <input type="text" id="direccion_comunidad" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="id_unidad_comunidades">Unidad:</label>
                <select id="id_unidad_comunidades" name="id_unidad" required>
                    <option value="">Seleccione una unidad</option>
                </select>
            </div>
            <button type="submit">Guardar</button>
            <a class="btn-cancelar" onclick="cerrarModal('agregar-comunidad-container')">Cancelar</a>
        </form>
    </div>
</div>

<!-- Modal para editar Comunidad -->
<div class="modal" id="editar-comunidad-container">
    <div class="modal-content">
        <h2>Editar Comunidad</h2>
        <form id="form-editar-comunidad" method="post" action="" class="form-modificar">
            <input type="hidden" id="id_comunidad_editar" name="id_comunidad">
            <div class="form-group">
                <label for="nombre_comunidad_editar">Nombre de la Comunidad:</label>
                <input type="text" id="nombre_comunidad_editar" name="nombre_comunidad" required>
            </div>
            <div class="form-group">
                <label for="autoridad_editar">Autoridad:</label>
                <input type="text" id="autoridad_editar" name="autoridad" required>
            </div>
            <div class="form-group">
                <label for="direccion_comunidad_editar">Dirección:</label>
                <input type="text" id="direccion_comunidad_editar" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="id_unidad_editar">Unidad:</label>
                <select id="id_unidad_editar" name="id_unidad" required>
                    <option value="">Seleccione una unidad</option>
                </select>
            </div>
            <button type="submit">Guardar Cambios</button>
            <a class="btn-cancelar" onclick="cerrarModal('editar-comunidad-container')">Cancelar</a>
        </form>
    </div>
</div>