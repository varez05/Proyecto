<?php
require_once '../modelo/conexion.php';
header('Content-Type: application/json');

// AGREGAR O EDITAR ADMINISTRADOR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_admin = isset($_POST['id_admin']) ? intval($_POST['id_admin']) : null;
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $contrasena = $conexion->real_escape_string($_POST['contrasena']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    
    // Manejo de imagen
    $img = '';
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $extension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = 'admin_' . time() . '.' . $extension;
        $rutaDestino = '../uploads/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['img']['tmp_name'], $rutaDestino)) {
            $img = $nombreArchivo;
        }
    }

    if ($id_admin) {
        // EDITAR
        $sql = "UPDATE Administrador SET Nombre='$nombre', Usuario='$usuario', Contrasena='$contrasena', Correo='$correo', Telefono='$telefono'";
        if ($img !== '') {
            $sql .= ", Img='$img'";
        }
        $sql .= " WHERE Id_admin=$id_admin";
        $ok = $conexion->query($sql);
        if ($ok) {
            echo json_encode(["success" => true, "message" => "Administrador actualizado correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar: " . $conexion->error]);
        }
    } else {
        // AGREGAR
        $sql = "INSERT INTO Administrador (Nombre, Usuario, Contrasena, Correo, Telefono, Img) VALUES ('$nombre', '$usuario', '$contrasena', '$correo', '$telefono', '$img')";
        $ok = $conexion->query($sql);
        if ($ok) {
            echo json_encode(["success" => true, "message" => "Administrador agregado correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al agregar: " . $conexion->error]);
        }
    }
    exit();
}

// ELIMINAR ADMINISTRADOR
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM Administrador WHERE Id_admin = $id";
    $ok = $conexion->query($sql);
    if ($ok) {
        echo json_encode(["success" => true, "message" => "Administrador eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar: " . $conexion->error]);
    }
    exit();
}
?>
