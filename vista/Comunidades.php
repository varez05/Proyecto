<?php
// Configuración de conexión a la base de datos
$servername = "b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com";
$username = "uvzy20bldxipuq8x";
$password = "cTXQO8Rz00laC0L5lFP8";
$dbname = "b8b6wjxwwgatbkzi3sc7";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía para agregar o actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
        // Actualizar comunidad existente
        $id_comunidad = $_POST['id_comunidad'];
        $nombre_comunidad = $_POST['nombre_comunidad'];
        $autoridad = $_POST['autoridad'];
        $id_unidad = $_POST['id_unidad'];

        $sql = "UPDATE Comunidad SET Nombre_comunidad = ?, Autoridad = ?, Id_unidad = ? WHERE Id_comunidad = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $nombre_comunidad, $autoridad, $id_unidad, $id_comunidad);

        if ($stmt->execute()) {
            $mensaje = "Comunidad actualizada correctamente";
        } else {
            $mensaje = "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Agregar nueva comunidad
        $nombre_comunidad = $_POST['nombre_comunidad'];
        $autoridad = $_POST['autoridad'];
        $id_unidad = $_POST['id_unidad'];

        // Preparar la consulta SQL
        $sql = "INSERT INTO Comunidad (Nombre_comunidad, Autoridad, Id_unidad) 
                VALUES (?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre_comunidad, $autoridad, $id_unidad);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            $mensaje = "Comunidad registrada correctamente";
        } else {
            $mensaje = "Error: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    }
}

// Procesar la eliminación
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];

    $sql_eliminar = "DELETE FROM Comunidad WHERE Id_comunidad = ?";
    $stmt = $conn->prepare($sql_eliminar);
    $stmt->bind_param("i", $id_eliminar);

    if ($stmt->execute()) {
        $mensaje = "Comunidad eliminada correctamente";
    } else {
        $mensaje = "Error al eliminar: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener datos para editar
$comunidad_editar = null;
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];

    $sql_editar = "SELECT * FROM Comunidad WHERE Id_comunidad = ?";
    $stmt = $conn->prepare($sql_editar);
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $resultado_editar = $stmt->get_result();

    if ($resultado_editar->num_rows > 0) {
        $comunidad_editar = $resultado_editar->fetch_assoc();
    }

    $stmt->close();
}

// Obtener datos de unidades para el select
$sql_unidades = "SELECT Id_unidad, Nombre FROM Unidad ORDER BY Nombre";
$resultado_unidades = $conn->query($sql_unidades);

// Obtener todas las comunidades para mostrarlas
$sql_comunidades = "SELECT c.Id_comunidad, c.Nombre_comunidad, c.Autoridad, c.Id_unidad, u.Nombre as Nombre_unidad 
                    FROM Comunidad c 
                    JOIN Unidad u ON c.Id_unidad = u.Id_unidad 
                    ORDER BY c.Nombre_comunidad";
$resultado_comunidades = $conn->query($sql_comunidades);
?>


    <script>
        function toggleForm(esEditar = false) {
            const formModal = document.getElementById('formModal');
            formModal.style.display = formModal.style.display === 'flex' ? 'none' : 'flex';

            if (!esEditar) {
                // Si no es editar, resetear el formulario
                document.getElementById('formularioComunidad').reset();
                document.getElementById('tituloFormulario').textContent = 'Registrar Nueva Comunidad';
                document.getElementById('accion').value = 'agregar';
                document.getElementById('id_comunidad').value = '';
            }
        }

        // Mostrar/ocultar menú desplegable
        function toggleDropdown(id) {
            document.querySelectorAll('.dropdown-content').forEach(function(menu) {
                if (menu.id !== 'menu-' + id) {
                    menu.classList.remove('show');
                }
            });
            document.getElementById('menu-' + id).classList.toggle('show');
        }

        // Cerrar los menús al hacer clic fuera de ellos
        window.onclick = function(event) {
            if (!event.target.matches('.menu-icon')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    <script>
        // Ocultar el mensaje después de 5 segundos
        setTimeout(function() {
            const mensaje = document.getElementById('mensaje');
            if (mensaje) {
                mensaje.style.transition = 'opacity 0.5s ease';
                mensaje.style.opacity = '0';
                setTimeout(() => mensaje.style.display = 'none', 500); // Ocultar completamente después de la transición
            }
        }, 5000);
    </script>

<div class="container">
    <div class="header-section">
    <h1>Gestión de Comunidades</h1>
    <button onclick="toggleForm()">Nueva Comunidad</button>
</div>

<?php if (isset($mensaje)): ?>
    <div class="mensaje" id="mensaje"><?php echo $mensaje; ?></div>
<?php endif; ?>

<div class="form-section" id="formModal" style="<?php echo (isset($comunidad_editar)) ? 'display:flex' : 'display:none'; ?>">
    <div class="form-container">
        <span class="close-icon" onclick="toggleForm()">×</span>
        <h2 id="tituloFormulario"><?php echo (isset($comunidad_editar)) ? 'Editar Comunidad' : 'Registrar Nueva Comunidad'; ?></h2>
        <form id="formularioComunidad" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" id="accion" name="accion" value="<?php echo (isset($comunidad_editar)) ? 'actualizar' : 'agregar'; ?>">
            <input type="hidden" id="id_comunidad" name="id_comunidad" value="<?php echo (isset($comunidad_editar)) ? $comunidad_editar['Id_comunidad'] : ''; ?>">

            <div class="form-group">
                <label for="nombre_comunidad">Nombre de la Comunidad:</label>
                <input type="text" id="nombre_comunidad" name="nombre_comunidad"
                    value="<?php echo (isset($comunidad_editar)) ? $comunidad_editar['Nombre_comunidad'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="autoridad">Autoridad:</label>
                <input type="text" id="autoridad" name="autoridad"
                    value="<?php echo (isset($comunidad_editar)) ? $comunidad_editar['Autoridad'] : ''; ?>" required>
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
                            $selected = (isset($comunidad_editar) && $comunidad_editar['Id_unidad'] == $row["Id_unidad"]) ? 'selected' : '';
                            echo "<option value='" . $row["Id_unidad"] . "' $selected>" . $row["Nombre"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit"><?php echo (isset($comunidad_editar)) ? 'Actualizar' : 'Guardar'; ?></button>
        </form>
    </div>
</div>

    <!-- Contenedor para mensajes -->
    <div id="mensaje" class="mensaje" style="display: none;"></div>

    <!-- Tabla de Comunidades -->
    <h2>Lista de Comunidades</h2>
    <table class="tabla-lideres">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Comunidad</th>
                <th>Autoridad</th>
                <th>Unidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado_comunidades->num_rows > 0): ?>
                <?php while ($row = $resultado_comunidades->fetch_assoc()): ?>
                    <tr>
                        <td class="center"><?php echo $row['Id_comunidad']; ?></td>
                        <td><?php echo htmlspecialchars($row['Nombre_comunidad']); ?></td>
                        <td><?php echo htmlspecialchars($row['Autoridad']); ?></td>
                        <td><?php echo htmlspecialchars($row['Nombre_unidad']); ?></td>
                        <td class="center">
                            <div class="dropdown">
                                <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                <div class="dropdown-menu">
                                    <a href="?editar=<?php echo $row['Id_comunidad']; ?>" class="dropdown-item">Modificar</a>
                                    <a href="?eliminar=<?php echo $row['Id_comunidad']; ?>" class="dropdown-item btn-eliminar" 
                                       onclick="return confirm('¿Está seguro de eliminar esta comunidad?');">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="center">No hay comunidades registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
// Cerrar la conexión
$conn->close();
?>
