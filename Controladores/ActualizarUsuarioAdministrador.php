<?php
// Controlador para actualizar el usuario del administrador
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/Paginaprincipal.php');
    exit();
}

$returnUrl = isset($_POST['return_url']) ? $_POST['return_url'] : '../vista/Sidebar_Administrador.php?seccion=contenido-perfil';

if (isset($_POST['nuevo_usuario'])) {
    $nuevo_usuario = trim($_POST['nuevo_usuario']);
    $id = $_SESSION['id'];

    if ($nuevo_usuario !== '') {
        global $conexion;
        $stmt = $conexion->prepare('UPDATE Administrador SET Usuario = ? WHERE Id_admin = ?');
        $stmt->bind_param('si', $nuevo_usuario, $id);
        if ($stmt->execute()) {
            $_SESSION['usuario'] = $nuevo_usuario;
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => true, 'usuario' => $nuevo_usuario]);
                exit;
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&usuario=ok');
        } else {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => false]);
                exit;
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&usuario=error');
        }
        $stmt->close();
    } else {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => false]);
            exit;
        }
        header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&usuario=error');
    }
} else {
    header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&usuario=error');
}
