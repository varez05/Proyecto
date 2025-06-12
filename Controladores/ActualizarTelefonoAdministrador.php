<?php
// Controlador para actualizar el teléfono del administrador
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/Paginaprincipal.php');
    exit();
}

$returnUrl = isset($_POST['return_url']) ? $_POST['return_url'] : '../vista/Sidebar_Administrador.php?seccion=contenido-perfil';

if (isset($_POST['nuevo_telefono'])) {
    $nuevo_telefono = trim($_POST['nuevo_telefono']);
    $id = $_SESSION['id'];

    if ($nuevo_telefono !== '') {
        global $conexion;
        $stmt = $conexion->prepare('UPDATE Administrador SET Telefono = ? WHERE Id_admin = ?');
        $stmt->bind_param('si', $nuevo_telefono, $id);
        if ($stmt->execute()) {
            $_SESSION['telefono'] = $nuevo_telefono;
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => true, 'telefono' => $nuevo_telefono]);
                exit;
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&telefono=ok');
        } else {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => false]);
                exit;
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&telefono=error');
        }
        $stmt->close();
    } else {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => false]);
            exit;
        }
        header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&telefono=error');
    }
} else {
    header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&telefono=error');
}
