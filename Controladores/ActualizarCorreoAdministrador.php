<?php
// Controlador para actualizar el correo del administrador
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: ../vista/Paginaprincipal.php');
    exit();
}

$returnUrl = isset($_POST['return_url']) ? $_POST['return_url'] : '../vista/Sidebar_Administrador.php?seccion=contenido-perfil';

if (isset($_POST['nuevo_correo'])) {
    $nuevo_correo = trim($_POST['nuevo_correo']);
    $id = $_SESSION['id']; // Asegúrate de tener el id en la sesión

    if (filter_var($nuevo_correo, FILTER_VALIDATE_EMAIL)) {
        // Usar mysqli en vez de PDO para compatibilidad con el resto del sistema
        global $conexion;
        $stmt = $conexion->prepare('UPDATE Administrador SET Correo = ? WHERE Id_admin = ?');
        $stmt->bind_param('si', $nuevo_correo, $id);
        if ($stmt->execute()) {
            $_SESSION['correo'] = $nuevo_correo;
            // Si la petición es AJAX, responde con JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => true, 'correo' => $nuevo_correo]);
                exit;
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&correo=ok');
        } else {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => false]);
                exit;
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&correo=error');
        }
        $stmt->close();
    } else {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => false]);
            exit;
        }
        header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&correo=error');
    }
} else {
    header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&correo=error');
}
