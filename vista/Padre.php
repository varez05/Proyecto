<?php
// vista/Padre.php
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $numero_documento = $_POST['numero_documento'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $lugar_nacimiento = $_POST['lugar_nacimiento'] ?? '';
    $sexo = $_POST['sexo'] ?? 'Masculino';

    // Validación básica
    if ($tipo_documento && $numero_documento && $nombres && $apellidos && $fecha_nacimiento && $lugar_nacimiento) {
        try {
            $conn = conectar();
            $stmt = $conn->prepare("INSERT INTO Padre (Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Lugar_nacimiento, Sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$tipo_documento, $numero_documento, $nombres, $apellidos, $fecha_nacimiento, $lugar_nacimiento, $sexo]);
            echo "<script>alert('Padre agregado correctamente'); window.location.href='Familias.php';</script>";
            exit();
        } catch (PDOException $e) {
            $error = 'Error al guardar: ' . $e->getMessage();
        }
    } else {
        $error = 'Todos los campos son obligatorios.';
    }
} else {
    $error = 'Método de solicitud no válido.';
}

if (isset($error)) {
    echo "<script>alert('$error'); window.location.href='Familias.php';</script>";
    exit();
}
?>
