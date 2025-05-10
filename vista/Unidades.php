<?php
session_start(); // Iniciar sesión para usar variables de sesión

// Conexión a la base de datos
$conn = new mysqli("b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com", "uvzy20bldxipuq8x", "cTXQO8Rz00laC0L5lFP8", "b8b6wjxwwgatbkzi3sc7"); // Cambia 'corporacion' por el nombre de tu base de datos

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Eliminar unidad
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']); // Asegurarse de que el ID sea un número entero
    $sql = "DELETE FROM Unidad WHERE Id_unidad = $id";
    if ($conn->query($sql)) {
        $_SESSION['mensaje'] = "Unidad eliminada correctamente"; // Guardar mensaje en la sesión
    } else {
        $_SESSION['mensaje'] = "Error al eliminar la unidad"; // Guardar mensaje de error
    }
    header("Location: Unidades.php"); // Redirigir para evitar reenvío del formulario
    exit();
}

// Modificar unidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_unidad']) && isset($_POST['nombre'])) {
    $id = intval($_POST['id_unidad']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $sql = "UPDATE Unidad SET Nombre = '$nombre' WHERE Id_unidad = $id";
    if ($conn->query($sql)) {
        $_SESSION['mensaje'] = "Unidad modificada correctamente"; // Guardar mensaje en la sesión
    } else {
        $_SESSION['mensaje'] = "Error al modificar la unidad"; // Guardar mensaje de error
    }
    header("Location: Unidades.php"); // Redirigir para evitar reenvío del formulario
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidades</title>
    <link rel="stylesheet" href="../Css/Unidades.css"> <!-- Archivo CSS externo -->
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container">
        <!-- Contenedor para mostrar mensajes -->
        <div id="mensaje" class="mensaje" style="display: none;"></div>

        <!-- Botón para agregar unidad -->
        <div class="header-container">
            <button id="btn-agregar" class="btn-modificar">Agregar Unidad</button>
        </div>

        <!-- Formulario para agregar una nueva unidad -->
        <div id="agregar-container" class="modificar-container" style="display: none;">
            <h2>Agregar Unidad</h2>
            <form action="Unidades.php" method="POST" class="form-modificar">
                <label for="nombre">Nombre de la Unidad:</label>
                <input type="text" id="nombre" name="nombre" required>
                <button type="submit">Guardar</button>
                <a href="#" id="btn-cancelar-agregar" class="btn-cancelar">Cancelar</a>
            </form>
        </div>

        <!-- Mostrar contenido de la tabla Unidad -->
        <h2>Lista de Unidades</h2>
        <table class="tabla-unidades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Insertar datos si se envió el formulario
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre']) && !isset($_POST['id_unidad'])) {
                    $nombre = $conn->real_escape_string($_POST['nombre']);
                    $sql = "INSERT INTO Unidad (Nombre) VALUES ('$nombre')";
                    if (!$conn->query($sql)) {
                        echo "Error al insertar: " . $conn->error;
                    }
                }

                // Consultar datos de la tabla Unidad
                $sql = "SELECT * FROM Unidad";
                $result = $conn->query($sql);

                // Mostrar datos en la tabla
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td class="center"><?php echo $row['Id_unidad']; ?></td>
                            <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                            <td class="center">
                                <a href="Unidades.php?eliminar=<?php echo $row['Id_unidad']; ?>" class="btn-eliminar">Eliminar</a>
                                <a href="Unidades.php?modificar=<?php echo $row['Id_unidad']; ?>" class="btn-modificar">Modificar</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="center">No hay unidades registradas</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Formulario para modificar unidad -->
    <?php if (isset($_GET['modificar'])): ?>
        <?php
        $conn = new mysqli("b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com", "uvzy20bldxipuq8x", "cTXQO8Rz00laC0L5lFP8", "b8b6wjxwwgatbkzi3sc7");
        $id = intval($_GET['modificar']);
        $sql = "SELECT * FROM Unidad WHERE Id_unidad = $id";
        $result = $conn->query($sql);
        $unidad = $result->fetch_assoc();
        ?>
        <div class="modificar-container">
            <h2>Modificar Unidad</h2>
            <form action="Unidades.php" method="POST" class="form-modificar">
                <input type="hidden" name="id_unidad" value="<?php echo $unidad['Id_unidad']; ?>">
                <label for="nombre">Nuevo Nombre de la Unidad:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($unidad['Nombre']); ?>" required>
                <button type="submit">Guardar Cambios</button>
                <a href="Unidades.php" class="btn-cancelar">Cancelar</a>
            </form>
        </div>
    <?php endif; ?>

    <script>
        // Mostrar el formulario de agregar unidad
        document.getElementById('btn-agregar').addEventListener('click', function() {
            document.getElementById('agregar-container').style.display = 'block';
        });

        // Ocultar el formulario de agregar unidad
        document.getElementById('btn-cancelar-agregar').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('agregar-container').style.display = 'none';
        });

        // Mostrar mensaje desde la sesión
        <?php if (isset($_SESSION['mensaje'])): ?>
            const mensaje = "<?php echo $_SESSION['mensaje']; ?>";
            const mensajeDiv = document.createElement('div');
            mensajeDiv.className = 'mensaje';
            mensajeDiv.textContent = mensaje;
            document.body.appendChild(mensajeDiv);
            mensajeDiv.style.display = 'block';

            // Eliminar el mensaje después de 4 segundos
            setTimeout(() => {
                mensajeDiv.style.display = 'none';
                mensajeDiv.remove();
            }, 4000);

            <?php unset($_SESSION['mensaje']); // Limpiar el mensaje ?>
        <?php endif; ?>
    </script>
</body>
</html>