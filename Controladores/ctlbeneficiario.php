<?php
require_once '../modelo/beneficiario.php';

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
    
    try {
        $beneficiario = new Beneficiario();
        $datos = $beneficiario->obtenerBeneficiarioPorId($numeroDocumento, $tipoDocumento);
        
        if ($datos !== null) {
            echo json_encode([
                'success' => true,
                'data' => $datos
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontró el beneficiario con el documento proporcionado'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
        ]);
    }
    exit;
}