<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'lider') {
    header("Location: ../vista/Paginaprincipal.php");
    exit();
}
include '../modelo/conexion.php';

$id_lider = $_SESSION['numero_documento']; // Suponiendo que el número de documento es único

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] === 0) {
    $img = $_FILES['nueva_foto'];
    $extension = pathinfo($img['name'], PATHINFO_EXTENSION);
    $nombreArchivo = 'lider_' . $id_lider . '_' . time() . '.' . $extension;
    $rutaDestino = '../uploads/' . $nombreArchivo;

    if (move_uploaded_file($img['tmp_name'], $rutaDestino)) {
        // Actualizar en la base de datos
        $sql = "UPDATE Lider SET Img = ? WHERE Numero_documento = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('ss', $nombreArchivo, $id_lider);
        $stmt->execute();
        $stmt->close();
        // Actualizar la sesión
        $_SESSION['img'] = $nombreArchivo;
        header("Location: ../vista/Sidebar_Lider.php?foto=ok");
        exit();
    } else {
        header("Location: ../vista/Perfil_lider.php?foto=error");
        exit();
    }
} else {
    header("Location: ../vista/Perfil_lider.php?foto=error");
    exit();
}
