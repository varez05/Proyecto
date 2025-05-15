<?php
// Controladores/LideresController.php
session_start();
define('UPLOAD_DIR', '../uploads/');

function conectarBaseDatos() {
    $conn = new mysqli("b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com", "uvzy20bldxipuq8x", "cTXQO8Rz00laC0L5lFP8", "b8b6wjxwwgatbkzi3sc7");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

function procesarImagen($archivos, $prefijo, $id = null) {
    if (!isset($archivos['img']) || $archivos['img']['error'] != 0) {
        return "";
    }
    if (!file_exists(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }
    $extension = pathinfo($archivos['img']['name'], PATHINFO_EXTENSION);
    $nombreArchivo = $prefijo . ($id ? "_" . $id : "") . "_" . time() . "." . $extension;
    $rutaDestino = UPLOAD_DIR . $nombreArchivo;
    if (move_uploaded_file($archivos['img']['tmp_name'], $rutaDestino)) {
        return $nombreArchivo;
    } else {
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

function consultarLider($conn, $id) {
    $sql = "SELECT * FROM Lider WHERE Id_lider = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

function listarLideres($conn) {
    $sql = "SELECT * FROM Lider";
    return $conn->query($sql);
}

// Conexión a la base de datos
$conn = conectarBaseDatos();

header('Content-Type: application/json'); // Establecer el encabezado para JSON

// Manejo de eliminación de líder
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM Lider WHERE Id_lider = $id";
    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Líder eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el líder"]);
    }
    exit();
}

// Manejo de edición de líder
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
        echo json_encode(["success" => true, "message" => "Líder modificado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al modificar el líder: " . $conn->error]);
    }
    exit();
}

// Manejo de agregar líder
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
    $img = procesarImagen($_FILES, "lider");
    $sql = "INSERT INTO Lider (Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Sexo, Correo, Telefono, Rol, Img) VALUES ('$tipo_documento', '$numero_documento', '$nombres', '$apellidos', '$fecha_nacimiento', '$sexo', '$correo', '$telefono', '$rol', '$img')";
    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Líder agregado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al agregar el líder: " . $conn->error]);
    }
    exit();
}
?>
