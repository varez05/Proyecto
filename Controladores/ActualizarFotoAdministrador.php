<?php
// Controlador para actualizar la foto del administrador
session_start();
require_once '../modelo/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    http_response_code(403);
    exit();
}

$returnUrl = isset($_POST['return_url']) ? $_POST['return_url'] : '../vista/Sidebar_Administrador.php?seccion=contenido-perfil';

if (isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] === UPLOAD_ERR_OK) {
    $id = $_SESSION['id'];
    $nombreArchivo = 'admin_' . $id . '_' . time();
    $extension = pathinfo($_FILES['nueva_foto']['name'], PATHINFO_EXTENSION);
    $nombreFinal = $nombreArchivo . '.' . $extension;
    $rutaDestino = '../imagen/' . $nombreFinal;

    if (move_uploaded_file($_FILES['nueva_foto']['tmp_name'], $rutaDestino)) {
        global $conexion;
        $stmt = $conexion->prepare('UPDATE Administrador SET Img = ? WHERE Id_admin = ?');
        $stmt->bind_param('si', $nombreFinal, $id);
        if ($stmt->execute()) {
            $_SESSION['img'] = $nombreFinal;
            // Si la petición es AJAX, responde con JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => true, 'img' => $nombreFinal]);
                exit();
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&foto=ok');
        } else {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['success' => false]);
                exit();
            }
            header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&foto=error');
        }
        $stmt->close();
    } else {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['success' => false]);
            exit();
        }
        header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&foto=error');
    }
} else {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(['success' => false]);
        exit();
    }
    header('Location: ../vista/Sidebar_Administrador.php?seccion=contenido-perfil&foto=error');
}
