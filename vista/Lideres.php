<?php
session_start(); // Iniciar sesión para usar variables de sesión

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'corporacion'); // Cambia 'corporacion' por el nombre de tu base de datos

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Eliminar líder
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']); // Asegurarse de que el ID sea un número entero
    $sql = "DELETE FROM Lider WHERE Id_lider = $id";
    if ($conn->query($sql)) {
        $_SESSION['mensaje'] = "Líder eliminado correctamente"; // Guardar mensaje en la sesión
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el líder"; // Guardar mensaje de error
    }
    header("Location: Lideres.php"); // Redirigir para evitar reenvío del formulario
    exit();
}

// Modificar líder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_lider'])) {
    $id = intval($_POST['id_lider']);
    $tipo_documento = $conn->real_escape_string($_POST['tipo_documento']);
    $numero_documento = $conn->real_escape_string($_POST['numero_documento']);
    $nombres = $conn->real_escape_string($_POST['nombres']);
    $apellidos = $conn->real_escape_string($_POST['apellidos']);
    $fecha_nacimiento = $conn->real_escape_string($_POST['fecha_nacimiento']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $rol = $conn->real_escape_string($_POST['rol']);
    
    // Procesamiento de la imagen
    $img = "";
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $extension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $img = "lider_" . $id . "_" . time() . "." . $extension;
        $target_file = $target_dir . $img;
        
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
            // La imagen se subió correctamente
        } else {
            $_SESSION['mensaje'] = "Error al subir la imagen.";
            header("Location: Lideres.php");
            exit();
        }
    } else {
        // Si no se subió una nueva imagen, mantener la existente
        $consulta = "SELECT Img FROM Lider WHERE Id_lider = $id";
        $resultado = $conn->query($consulta);
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $img = $fila['Img'];
        }
    }
    
    $sql = "UPDATE Lider SET 
                Tipo_documento = '$tipo_documento', 
                Numero_documento = '$numero_documento', 
                Nombres = '$nombres', 
                Apellidos = '$apellidos', 
                Fecha_nacimiento = '$fecha_nacimiento', 
                Sexo = '$sexo', 
                Correo = '$correo', 
                Telefono = '$telefono', 
                Rol = '$rol'";
    
    // Agregar la imagen a la consulta solo si se subió una nueva
    if (!empty($img)) {
        $sql .= ", Img = '$img'";
    }
    
    $sql .= " WHERE Id_lider = $id";
    
    if ($conn->query($sql)) {
        $_SESSION['mensaje'] = "Líder modificado correctamente"; // Guardar mensaje en la sesión
    } else {
        $_SESSION['mensaje'] = "Error al modificar el líder: " . $conn->error; // Guardar mensaje de error
    }
    header("Location: Lideres.php"); // Redirigir para evitar reenvío del formulario
    exit();
}

// Agregar nuevo líder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['id_lider'])) {
    $tipo_documento = $conn->real_escape_string($_POST['tipo_documento']);
    $numero_documento = $conn->real_escape_string($_POST['numero_documento']);
    $nombres = $conn->real_escape_string($_POST['nombres']);
    $apellidos = $conn->real_escape_string($_POST['apellidos']);
    $fecha_nacimiento = $conn->real_escape_string($_POST['fecha_nacimiento']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $rol = $conn->real_escape_string($_POST['rol']);
    $img = "";
    
    // Verificar si ya existe un líder con ese número de documento
    $check_query = "SELECT * FROM Lider WHERE Numero_documento = '$numero_documento'";
    $check_result = $conn->query($check_query);
    
    if ($check_result->num_rows > 0) {
        $_SESSION['mensaje'] = "Error: Ya existe un líder con ese número de documento";
        header("Location: Lideres.php");
        exit();
    }
    
    // Procesamiento de la imagen si se ha enviado
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $extension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $img = "lider_" . time() . "." . $extension;
        $target_file = $target_dir . $img;
        
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
            // La imagen se subió correctamente
        } else {
            $_SESSION['mensaje'] = "Error al subir la imagen.";
            header("Location: Lideres.php");
            exit();
        }
    }
    
    $sql = "INSERT INTO Lider (Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Sexo, Correo, Telefono, Rol, Img) 
            VALUES ('$tipo_documento', '$numero_documento', '$nombres', '$apellidos', '$fecha_nacimiento', '$sexo', '$correo', '$telefono', '$rol', '$img')";
    
    if ($conn->query($sql)) {
        $_SESSION['mensaje'] = "Líder agregado correctamente";
    } else {
        $_SESSION['mensaje'] = "Error al agregar el líder: " . $conn->error;
    }
    
    header("Location: Lideres.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Líderes</title>
    <link rel="stylesheet" href="../Css/Lider.css"> <!-- Archivo CSS externo -->
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container">
        <!-- Contenedor para mostrar mensajes -->
        <div id="mensaje" class="mensaje" style="display: none;"></div>

        <!-- Botón para agregar líder -->
        <div class="header-container">
            <button id="btn-agregar" class="btn-modificar">Agregar Líder</button>
        </div>

        <!-- Formulario para agregar un nuevo líder -->
        <div id="agregar-container" class="modificar-container" style="display: none;">
            <h2>Agregar Líder</h2>
            <form action="Lideres.php" method="POST" class="form-modificar" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="tipo_documento">Tipo de Documento:</label>
                    <select id="tipo_documento" name="tipo_documento" required>
                        <option value="Cédula">Cédula</option>
                        <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                        <option value="Pasaporte">Pasaporte</option>
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
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo" required>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo">
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono">
                </div>
                
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select id="rol" name="rol" required>
                        <option value="Pedagógico">Pedagógico</option>
                        <option value="Comunitario">Comunitario</option>
                        <option value="Técnico">Técnico</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="img">Imagen (opcional):</label>
                    <input type="file" id="img" name="img" accept="image/*">
                </div>
                
                <div class="form-buttons">
                    <button type="submit">Guardar</button>
                    <a href="#" id="btn-cancelar-agregar" class="btn-cancelar">Cancelar</a>
                </div>
            </form>
        </div>

        <!-- Mostrar contenido de la tabla Lider -->
        <h2>Lista de Líderes</h2>
        <table class="tabla-lideres">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Fecha Nac.</th>
                    <th>Sexo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar datos de la tabla Lider
                $sql = "SELECT * FROM Lider";
                $result = $conn->query($sql);

                // Mostrar datos en la tabla
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td class="center"><?php echo $row['Id_lider']; ?></td>
                            <td><?php echo $row['Tipo_documento'] . ': ' . htmlspecialchars($row['Numero_documento']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nombres']); ?></td>
                            <td><?php echo htmlspecialchars($row['Apellidos']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['Fecha_nacimiento'])); ?></td>
                            <td><?php echo $row['Sexo']; ?></td>
                            <td><?php echo htmlspecialchars($row['Correo']); ?></td>
                            <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
                            <td><?php echo $row['Rol']; ?></td>
                            <td class="center">
                                <?php if (!empty($row['Img'])): ?>
                                    <img src="../uploads/<?php echo htmlspecialchars($row['Img']); ?>" alt="Foto de perfil" class="profile-img">
                                <?php else: ?>
                                    <span>Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td class="center">
                                <a href="Lideres.php?eliminar=<?php echo $row['Id_lider']; ?>" class="btn-eliminar" onclick="return confirm('¿Está seguro de eliminar este líder?');">Eliminar</a>
                                <a href="Lideres.php?modificar=<?php echo $row['Id_lider']; ?>" class="btn-modificar">Modificar</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="11" class="center">No hay líderes registrados</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Formulario para modificar líder -->
    <?php if (isset($_GET['modificar'])): ?>
        <?php
        $id = intval($_GET['modificar']);
        $sql = "SELECT * FROM Lider WHERE Id_lider = $id";
        $result = $conn->query($sql);
        $lider = $result->fetch_assoc();
        ?>
        <div class="modificar-container">
            <h2>Modificar Líder</h2>
            <form action="Lideres.php" method="POST" class="form-modificar" enctype="multipart/form-data">
                <input type="hidden" name="id_lider" value="<?php echo $lider['Id_lider']; ?>">
                
                <div class="form-group">
                    <label for="tipo_documento">Tipo de Documento:</label>
                    <select id="tipo_documento" name="tipo_documento" required>
                        <option value="Cédula" <?php echo ($lider['Tipo_documento'] == 'Cédula') ? 'selected' : ''; ?>>Cédula</option>
                        <option value="Tarjeta de Identidad" <?php echo ($lider['Tipo_documento'] == 'Tarjeta de Identidad') ? 'selected' : ''; ?>>Tarjeta de Identidad</option>
                        <option value="Pasaporte" <?php echo ($lider['Tipo_documento'] == 'Pasaporte') ? 'selected' : ''; ?>>Pasaporte</option>
                        <option value="Cédula Extranjería" <?php echo ($lider['Tipo_documento'] == 'Cédula Extranjería') ? 'selected' : ''; ?>>Cédula Extranjería</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="numero_documento">Número de Documento:</label>
                    <input type="text" id="numero_documento" name="numero_documento" value="<?php echo htmlspecialchars($lider['Numero_documento']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($lider['Nombres']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($lider['Apellidos']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $lider['Fecha_nacimiento']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo" required>
                        <option value="Masculino" <?php echo ($lider['Sexo'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?php echo ($lider['Sexo'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($lider['Correo']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($lider['Telefono']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select id="rol" name="rol" required>
                        <option value="Pedagógico" <?php echo ($lider['Rol'] == 'Pedagógico') ? 'selected' : ''; ?>>Pedagógico</option>
                        <option value="Comunitario" <?php echo ($lider['Rol'] == 'Comunitario') ? 'selected' : ''; ?>>Comunitario</option>
                        <option value="Técnico" <?php echo ($lider['Rol'] == 'Técnico') ? 'selected' : ''; ?>>Técnico</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <?php if (!empty($lider['Img'])): ?>
                        <label>Imagen Actual:</label>
                        <img src="../uploads/<?php echo htmlspecialchars($lider['Img']); ?>" alt="Imagen actual" class="current-img">
                    <?php endif; ?>
                    <label for="img">Nueva Imagen (opcional):</label>
                    <input type="file" id="img" name="img" accept="image/*">
                </div>
                
                <div class="form-buttons">
                    <button type="submit">Guardar Cambios</button>
                    <a href="Lideres.php" class="btn-cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <script>
        // Mostrar el formulario de agregar líder
        document.getElementById('btn-agregar').addEventListener('click', function() {
            document.getElementById('agregar-container').style.display = 'block';
        });

        // Ocultar el formulario de agregar líder
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