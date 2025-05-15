<?php
session_start(); // Iniciar sesión para usar variables de sesión

// Conexión a la base de datos
$conn = new mysqli("b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com", "uvzy20bldxipuq8x", "cTXQO8Rz00laC0L5lFP8", "b8b6wjxwwgatbkzi3sc7");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar datos de la tabla Unidad
function obtenerUnidades($conn) {
    $sql = "SELECT * FROM Unidad";
    return $conn->query($sql);
}


header('Content-Type: application/json'); // Establecer el encabezado para JSON

// Eliminar unidad
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']); // Asegurarse de que el ID sea un número entero
    $sql = "DELETE FROM Unidad WHERE Id_unidad = $id";
    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Unidad eliminada correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar la unidad, debe eliminar todas las comunidades asociadas"]);
    }
    exit();
}

// Obtener todas las unidades en formato JSON
if (isset($_GET['obtener_unidades'])) {
    $resultado = obtenerUnidades($conn);
    $unidades = [];
    while ($row = $resultado->fetch_assoc()) {
        $unidades[] = $row;
    }
    echo json_encode($unidades);
    exit();
}

// Modificar unidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_unidad']) && isset($_POST['nombre'])) {
    $id = intval($_POST['id_unidad']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $sql = "UPDATE Unidad SET Nombre = '$nombre' WHERE Id_unidad = $id";
    if ($conn->query($sql)) {
        echo json_encode(["success" => true, "message" => "Unidad modificada correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al modificar la unidad"]);
    }
    exit();
}

// Insertar nueva unidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre']) && !isset($_POST['id_unidad'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $sql = "INSERT INTO Unidad (Nombre) VALUES ('$nombre')";
    if (!$conn->query($sql)) {
        echo json_encode(["success" => false, "message" => "Error al insertar: " . $conn->error]);
    } else {
        echo json_encode(["success" => true, "message" => "Unidad agregada correctamente"]);
    }
    exit();
}

?>
