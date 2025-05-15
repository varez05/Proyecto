<!-- Modal para agregar Comunidad -->
<div class="modal" id="agregar-comunidad-container">
    <div class="modal-content">
        <h2>Agregar Comunidad</h2>
        <form id="form-agregar-comunidad" method="post" action="" class="form-modificar">
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
                <label for="id_unidad">Unidad:</label>
                <select id="id_unidad" name="id_unidad" required>
                    <option value="">Seleccione una unidad</option>
                    <?php
                    $resultado_unidades->data_seek(0);
                    if ($resultado_unidades->num_rows > 0) {
                        while ($row = $resultado_unidades->fetch_assoc()) {
                            echo "<option value='" . $row["Id_unidad"] . "'>" . $row["Nombre"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Guardar</button>
            <a href="#" id="btn-cancelar-agregar-comunidad" class="btn-cancelar" onclick="cerrarModal('agregar-comunidad-container')">Cancelar</a>
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
                <label for="id_unidad_editar">Unidad:</label>
                <select id="id_unidad_editar" name="id_unidad" required>
                    <option value="">Seleccione una unidad</option>
                    <?php
                    $resultado_unidades->data_seek(0);
                    if ($resultado_unidades->num_rows > 0) {
                        while ($row = $resultado_unidades->fetch_assoc()) {
                            echo "<option value='" . $row["Id_unidad"] . "'>" . $row["Nombre"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit">Guardar Cambios</button>
            <a href="#" id="btn-cancelar-editar-comunidad" class="btn-cancelar" onclick="cerrarModal('editar-comunidad-container')">Cancelar</a>
        </form>
    </div>
</div>