<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../modelo/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['passwordField'];

    if (empty($usuario) || empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    $sql = "SELECT * FROM Administrador WHERE Usuario = ? AND Contrasena = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("❌ Error en la consulta SQL: " . $conexion->error);
    }

    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../vista/Sidebar.html");
        exit;
    } else {
        header("Location: ../vista/Paginaprincipal.php?error=1"); 
    exit;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Acceso no permitido.";
}




