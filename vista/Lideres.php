<?php
/**
 * Lideres.php - Sistema de gestión de líderes
 * 
 * Este archivo maneja las operaciones CRUD para la entidad Lider
 * en la base de datos corporacion.
 */

// Inicializar sesión y conectar a la base de datos
session_start();

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'corporacion');
define('UPLOAD_DIR', '../uploads/');

// Funciones de utilidad
function conectarBaseDatos() {
    $conn = new mysqli("b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com", "uvzy20bldxipuq8x", "cTXQO8Rz00laC0L5lFP8", "b8b6wjxwwgatbkzi3sc7");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

function guardarMensaje($mensaje) {
    $_SESSION['mensaje'] = $mensaje;
}

function redirigir($ubicacion) {
    header("Location: $ubicacion");
    exit();
}

function procesarImagen($archivos, $prefijo, $id = null) {
    if (!isset($archivos['img']) || $archivos['img']['error'] != 0) {
        return "";
    }
    
    // Crear directorio si no existe
    if (!file_exists(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }
    
    $extension = pathinfo($archivos['img']['name'], PATHINFO_EXTENSION);
    $nombreArchivo = $prefijo . ($id ? "_" . $id : "") . "_" . time() . "." . $extension;
    $rutaDestino = UPLOAD_DIR . $nombreArchivo;
    
    if (move_uploaded_file($archivos['img']['tmp_name'], $rutaDestino)) {
        return $nombreArchivo;
    } else {
        guardarMensaje("Error al subir la imagen.");
        return "";
    }
}

function obtenerImagenActual($conn, $id) {
    $consulta = "SELECT Img FROM Lider WHERE Id_lider = $id";
    $resultado = $conn->query($consulta);
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        return $fila['Img'];
    }
    return "";
}

// Conexión a la base de datos
$conn = conectarBaseDatos();

// GESTIÓN DE OPERACIONES CRUD

// 1. Eliminar líder
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM Lider WHERE Id_lider = $id";
    
    if ($conn->query($sql)) {
        guardarMensaje("Líder eliminado correctamente");
    } else {
        guardarMensaje("Error al eliminar el líder");
    }
    redirigir("Lideres.php");
}

// 2. Modificar líder existente
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
    
    // Procesar imagen o mantener la existente
    $img = procesarImagen($_FILES, "lider", $id);
    if (empty($img)) {
        $img = obtenerImagenActual($conn, $id);
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
                Rol = '$rol',
                Img = '$img'  
            WHERE Id_lider = $id";
    
    if ($conn->query($sql)) {
        guardarMensaje("Líder modificado correctamente");
    } else {
        guardarMensaje("Error al modificar el líder: " . $conn->error);
    }
    redirigir("Lideres.php");
}

// 3. Agregar nuevo líder
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
    
    // Verificar si ya existe el número de documento
    $check_documento_query = "SELECT * FROM Lider WHERE Numero_documento = '$numero_documento'";
    $check_documento_result = $conn->query($check_documento_query);
    
    // Verificar si ya existe el correo
    $check_correo_query = "SELECT * FROM Lider WHERE Correo = '$correo'";
    $check_correo_result = $conn->query($check_correo_query);
    
    // Verificar si ya existe el teléfono
    $check_telefono_query = "SELECT * FROM Lider WHERE Telefono = '$telefono'";
    $check_telefono_result = $conn->query($check_telefono_query);
    
    if ($check_documento_result->num_rows > 0) {
        echo "<script>alert('Error: Ya existe un líder con ese número de documento');</script>";
    } elseif ($check_correo_result->num_rows > 0) {
        guardarMensaje("Error: Ya existe un líder con ese correo electrónico");
    } elseif ($check_telefono_result->num_rows > 0) {
        guardarMensaje("Error: Ya existe un líder con ese número de teléfono");
    } else {
        // Validar que la fecha de nacimiento no sea mayor a la fecha actual
        $fecha_actual = date('Y-m-d');
        if ($fecha_nacimiento > $fecha_actual) {
            guardarMensaje("Error: La fecha de nacimiento no puede ser mayor a la fecha actual");
        } else {
            // Procesar imagen
            $img = procesarImagen($_FILES, "lider");
            
            $sql = "INSERT INTO Lider (Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, 
                                      Sexo, Correo, Telefono, Rol, Img) 
                    VALUES ('$tipo_documento', '$numero_documento', '$nombres', '$apellidos', '$fecha_nacimiento', 
                           '$sexo', '$correo', '$telefono', '$rol', '$img')";
            
            if ($conn->query($sql)) {
                guardarMensaje("Líder agregado correctamente");
            } else {
                guardarMensaje("Error al agregar el líder: " . $conn->error);
            }
            redirigir("Lideres.php");
        }
    }
}

// 4. Consultar líder para modificar
$lider = null;
if (isset($_GET['modificar'])) {
    $id = intval($_GET['modificar']);
    $sql = "SELECT * FROM Lider WHERE Id_lider = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $lider = $result->fetch_assoc();
    }
}

// 5. Listar todos los líderes
$sql = "SELECT * FROM Lider";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Líderes</title>
    <link rel="stylesheet" href="../Css/Lider.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje" class="mensaje">
            <?php $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
        </div>
    <?php endif; ?>

    <!-- Modal para agregar líder -->
    <div id="modal-agregar" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="btn-cerrar-modal" class="close">&times;</span>
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
                    <button type="button" id="btn-cancelar-modal" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para modificar líder -->
    <?php if ($lider): ?>
        <div id="modal-modificar" class="modal" style="display: none;">
            <div class="modal-content">
                <span id="btn-cerrar-modal-modificar" class="close">&times;</span>
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
                        <button type="button" id="btn-cancelar-modal-modificar" class="btn-cancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
             <div class="header-container">
             <h1>Gestión de Líderes</h1>
             <button id="btn-agregar" class="btn-modificar">Agregar Líder</button>
             </div>
    <!-- Contenido principal -->
    <div class="container">
        <!-- Contenedor para mensajes -->
        <div id="mensaje" class="mensaje" style="display: none;"></div>

        <!-- Tabla de líderes -->
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
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
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
                                <div class="dropdown">
                                    <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                    <div class="dropdown-menu">
                                        <a href="Lideres.php?modificar=<?php echo $row['Id_lider']; ?>" class="dropdown-item">Modificar</a>
                                        <a href="Lideres.php?eliminar=<?php echo $row['Id_lider']; ?>" class="dropdown-item btn-eliminar" 
                                           onclick="return confirm('¿Está seguro de eliminar este líder?');">Eliminar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="center">No hay líderes registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalAgregar = document.getElementById('modal-agregar');
        const modalModificar = document.getElementById('modal-modificar');
        const btnAbrirModalAgregar = document.getElementById('btn-agregar');
        const btnCerrarModalAgregar = document.getElementById('btn-cerrar-modal');
        const btnCancelarModalAgregar = document.getElementById('btn-cancelar-modal');
        const btnCerrarModalModificar = document.getElementById('btn-cerrar-modal-modificar');
        const btnCancelarModalModificar = document.getElementById('btn-cancelar-modal-modificar');

        // Mostrar el modal de agregar
        btnAbrirModalAgregar.addEventListener('click', function () {
            modalAgregar.style.display = 'flex';
        });

        // Ocultar el modal de agregar
        btnCerrarModalAgregar.addEventListener('click', function () {
            modalAgregar.style.display = 'none';
        });
        btnCancelarModalAgregar.addEventListener('click', function () {
            modalAgregar.style.display = 'none';
        });

        // Mostrar el modal de modificar si existe
        if (modalModificar) {
            modalModificar.style.display = 'flex';
        }

        // Ocultar el modal de modificar
        btnCerrarModalModificar.addEventListener('click', function () {
            modalModificar.style.display = 'none';
        });
        btnCancelarModalModificar.addEventListener('click', function () {
            modalModificar.style.display = 'none';
        });

        // Ocultar los modales al hacer clic fuera del contenido
        window.addEventListener('click', function (event) {
            if (event.target === modalAgregar) {
                modalAgregar.style.display = 'none';
            }
            if (event.target === modalModificar) {
                modalModificar.style.display = 'none';
            }
        });

        const mensaje = document.getElementById('mensaje');
        if (mensaje) {
            setTimeout(() => {
                mensaje.style.display = 'none';
            }, 5000); // 5 segundos
        }
    });
    </script>
</body>
</html>