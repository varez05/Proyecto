<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'lider') {
    header("Location: ../vista/Paginaprincipal.php");
    exit();
}
include '../modelo/conexion.php';

$id_lider = $_SESSION['numero_documento'];
$nuevo_correo = isset($_POST['nuevo_correo']) ? trim($_POST['nuevo_correo']) : '';

if (filter_var($nuevo_correo, FILTER_VALIDATE_EMAIL)) {
    $sql = "UPDATE Lider SET Correo = ? WHERE Numero_documento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('ss', $nuevo_correo, $id_lider);
    if ($stmt->execute()) {
        $_SESSION['correo'] = $nuevo_correo;
        header("Location: ../vista/Sidebar_Lider.php?correo=ok");
        exit();
    } else {
        header("Location: ../vista/Sidebar_Lider.php?correo=error");
        exit();
    }
} else {
    header("Location: ../vista/Sidebar_Lider.php?correo=error");
    exit();
}
