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

    // --- Primero, verificar en la tabla Administrador ---
    $sqlAdmin = "SELECT * FROM Administrador WHERE Usuario = ? AND Contrasena = ?";
    $stmt = $conexion->prepare($sqlAdmin);

    if (!$stmt) {
        die("❌ Error en la consulta SQL: " . $conexion->error);
    }

    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre'] = $fila['Nombre'];
        $_SESSION['correo'] = $fila['Correo'];
        $_SESSION['img'] = $fila['Img'];
        $_SESSION['rol'] = 'administrador';

        $stmt->close();
        $conexion->close();

        header("Location: ../vista/Sidebar_Administrador.php");
        exit;
    }

    $stmt->close();

    // --- Verificar en la tabla Lider usando correo y documento ---
    $sqlLider = "SELECT * FROM Lider WHERE Correo = ? AND Numero_documento = ?";
    $stmt = $conexion->prepare($sqlLider);

    if (!$stmt) {
        die("❌ Error en la consulta SQL (líder): " . $conexion->error);
    }

    $stmt->bind_param("ss", $usuario, $password); // correo como usuario, documento como password
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre'] = $fila['Nombres'];
        $_SESSION['correo'] = $fila['Correo'];
        $_SESSION['img'] = $fila['Img'];
        $_SESSION['rol'] = 'lider';

        $stmt->close();
        $conexion->close();

        header("Location: ../vista/Sidebar_Lider.php");
        exit;
    }

    $stmt->close();
    $conexion->close();

    // --- No se encontró ningún usuario ---
    header("Location: ../vista/Paginaprincipal.php?error=1");
    exit;
} else {
    echo "Acceso no permitido.";
}
