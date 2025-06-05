<?php
// Controlador para Comunidades
$servername = "b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com";
$username = "uvzy20bldxipuq8x";
$password = "cTXQO8Rz00laC0L5lFP8";
$dbname = "b8b6wjxwwgatbkzi3sc7";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Error de conexión: " . $conn->connect_error]));
}

header('Content-Type: application/json');


// actualizar / insertar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'] ?? '';
    if ($accion == 'actualizar') {
        $id_comunidad = $_POST['id_comunidad'];
        $nombre_comunidad = $_POST['nombre_comunidad'];
        $autoridad = $_POST['autoridad'];
        $direccion = $_POST['direccion'];
        $id_unidad = $_POST['id_unidad'];
        $sql = "UPDATE Comunidad SET Nombre_comunidad = ?, Autoridad = ?, Direccion = ?, Id_unidad = ? WHERE Id_comunidad = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nombre_comunidad, $autoridad, $direccion, $id_unidad, $id_comunidad);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Comunidad actualizada correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar: " . $stmt->error]);
        }
        $stmt->close();
        exit();
    } else {
        $nombre_comunidad = $_POST['nombre_comunidad'];
        $autoridad = $_POST['autoridad'];
        $direccion = $_POST['direccion'];
        $id_unidad = $_POST['id_unidad'];
        $sql = "INSERT INTO Comunidad (Nombre_comunidad, Autoridad, Direccion, Id_unidad) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre_comunidad, $autoridad, $direccion, $id_unidad);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Comunidad registrada correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }
        $stmt->close();
        exit();
    }
}

// aliminar
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $sql_eliminar = "DELETE FROM Comunidad WHERE Id_comunidad = ?";
    $stmt = $conn->prepare($sql_eliminar);
    $stmt->bind_param("i", $id_eliminar);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Comunidad eliminada correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar: " . $stmt->error]);
    }
    $stmt->close();
    exit();
}
// ...existing code for selects and queries...
