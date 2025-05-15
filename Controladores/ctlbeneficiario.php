<?php
require_once '../modelo/beneficiario.php';

/**
 * Controlador para obtener los datos de un beneficiario
 * @param string $tipoDocumento Tipo de documento del beneficiario
 * @param string $numeroDocumento Número de documento del beneficiario
 * @return array Retorna un array con el estado de la operación y los datos o mensaje de error
 */
function obtenerDatosBeneficiario($tipoDocumento, $numeroDocumento) {
    try {
        // Crear instancia de la clase Beneficiario
        $beneficiario = new Beneficiario();
        
        // Obtener los datos del beneficiario
        $datos = $beneficiario->obtenerBeneficiarioPorId($numeroDocumento, $tipoDocumento);
        
        if ($datos !== null) {
            return [
                'success' => true,
                'data' => $datos
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No se encontró el beneficiario con el documento proporcionado'
            ];
        }
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
        ];
    }
}

// Procesar la solicitud si se reciben los parámetros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoDocumento = $_POST['tipoDocumento'] ?? '';
    $numeroDocumento = $_POST['numeroDocumento'] ?? '';
    
    if (empty($tipoDocumento) || empty($numeroDocumento)) {
        echo json_encode([
            'success' => false,
            'message' => 'El tipo y número de documento son requeridos'
        ]);
        exit;
    }
    
    // Obtener y devolver los datos del beneficiario
    $resultado = obtenerDatosBeneficiario($tipoDocumento, $numeroDocumento);
    echo json_encode($resultado);
    exit;
}