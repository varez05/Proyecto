<?php
function validarDocumento($tipo, $numero, $conn, $tabla, $campo) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM $tabla WHERE Tipo_documento = ? AND Numero_documento = ?");
    $stmt->execute([$tipo, $numero]);
    return $stmt->fetchColumn() == 0;
}