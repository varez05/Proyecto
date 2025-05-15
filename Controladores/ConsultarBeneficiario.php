<?php
require_once '../modelo/conexion.php';

$tipo = $_POST['tipoDocumento'] ?? '';
$numero = $_POST['numeroDocumento'] ?? '';

if ($tipo && $numero) {
    // Usar la conexión existente de conexion.php
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT * FROM Familias WHERE Tipo_documento = ? AND Numero_documento = ?");
    $stmt->bind_param("ss", $tipo, $numero);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Es beneficiario
        header("Location: ../vista/paginaConsulta.php?tipo=$tipo&numero=$numero");
    } else {
        // No es beneficiario
        header("Location: ../vista/paginaConsultaNoBeneficiario.php?tipo=$tipo&numero=$numero");
    }
    $stmt->close();
    $conexion->close();
    exit;
} else {
    header("Location: ../vista/Paginaprincipal.php?error=datos");
    exit;
}
?>
