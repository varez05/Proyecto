

    <!-- Modal para agregar Comunidad -->
    <div class="form-section" id="guardar-modal" style="display:none;">
    <div class="form-container">
    <span class="close-icon" onclick="toggleForm()">×</span>
    <h2 id="tituloFormulario">Registrar Nueva Comunidad</h2>
    <form id="formularioComunidad" method="post" action="">
        <input type="hidden" id="accion" name="accion" value="agregar">
        <input type="hidden" id="id_comunidad" name="id_comunidad" value="">

        <div class="form-group">
            <label for="nombre_comunidad">Nombre de la Comunidad:</label>
            <input type="text" id="nombre_comunidad" name="nombre_comunidad" value="" required>
        </div>

        <div class="form-group">
            <label for="autoridad">Autoridad:</label>
            <input type="text" id="autoridad" name="autoridad" value="" required>
        </div>

        <div class="form-group">
            <label for="id_unidad">Unidad:</label>
            <select id="id_unidad" name="id_unidad" required>
                <option value="">Seleccione una unidad</option>
                <?php
                // Reiniciamos el puntero del resultado
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
    </form>
    </div>
    </div>

    <!-- Modal para Modificar Comunidad -->
    <div class="form-section" id="modificar-modal" style="display:none;">
    <div class="form-container">
    <span class="close-icon" onclick="toggleForm()">×</span>
    <h2 id="tituloFormulario">Registrar Nueva Comunidad</h2>
    <form id="formularioComunidad" method="post" action="">
        <input type="hidden" id="accion" name="accion" value="agregar">
        <input type="hidden" id="id_comunidad" name="id_comunidad" value="">

        <div class="form-group">
            <label for="nombre_comunidad">Nombre de la Comunidad:</label>
            <input type="text" id="nombre_comunidad" name="nombre_comunidad" value="" required>
        </div>

        <div class="form-group">
            <label for="autoridad">Autoridad:</label>
            <input type="text" id="autoridad" name="autoridad" value="" required>
        </div>

        <div class="form-group">
            <label for="id_unidad">Unidad:</label>
            <select id="id_unidad" name="id_unidad" required>
                <option value="">Seleccione una unidad</option>
                <?php
                // Reiniciamos el puntero del resultado
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
    </form>
    </div>
    </div>