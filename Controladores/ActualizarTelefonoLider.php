<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'lider') {
    header("Location: ../vista/Paginaprincipal.php");
    exit();
}
include '../modelo/conexion.php';

$id_lider = $_SESSION['numero_documento'];
$nuevo_telefono = isset($_POST['nuevo_telefono']) ? trim($_POST['nuevo_telefono']) : '';

if (!empty($nuevo_telefono) && preg_match('/^[0-9+\- ]{7,20}$/', $nuevo_telefono)) {
    $sql = "UPDATE Lider SET Telefono = ? WHERE Numero_documento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('ss', $nuevo_telefono, $id_lider);
    if ($stmt->execute()) {
        $_SESSION['telefono'] = $nuevo_telefono;
        header("Location: ../vista/Sidebar_Lider.php?telefono=ok");
        exit();
    } else {
        header("Location: ../vista/Sidebar_Lider.php?telefono=error");
        exit();
    }
} else {
    header("Location: ../vista/Sidebar_Lider.php?telefono=error");
    exit();
}
