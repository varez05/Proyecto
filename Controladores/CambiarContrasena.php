<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    http_response_code(403);
    exit('No autorizado');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../modelo/conexion.php';
    $usuario = $_SESSION['usuario'];
    $actual = $_POST['actual'];
    $nueva = $_POST['nueva'];
    $confirmar = $_POST['confirmar'];
    if ($nueva !== $confirmar) {
        exit('Las contraseñas nuevas no coinciden.');
    }
    $sql = "SELECT Contrasena FROM Administrador WHERE Usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $stmt->bind_result($contrasena_bd);
    $stmt->fetch();
    $stmt->close();
    if ($actual !== $contrasena_bd) {
        exit('La contraseña actual es incorrecta.');
    }
    $sql = "UPDATE Administrador SET Contrasena = ? WHERE Usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('ss', $nueva, $usuario);
    if ($stmt->execute()) {
        exit('Contraseña actualizada correctamente.');
    } else {
        exit('Error al actualizar la contraseña.');
    }
}
http_response_code(405);
exit('Método no permitido');
?>
