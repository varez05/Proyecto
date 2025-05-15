<?php
require_once 'conexion.php';

class Beneficiario {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    /**
     * Obtiene los datos de un beneficiario por su número de identificación
     * @param string $numeroDocumento Número de documento del beneficiario
     * @param string $tipoDocumento Tipo de documento del beneficiario
     * @return array|null Retorna un array con los datos del beneficiario o null si no existe
     */
    public function obtenerBeneficiarioPorId($numeroDocumento, $tipoDocumento) {
        try {
            $query = "SELECT f.*, 
                        m.Nombres as Madre_Nombres, m.Apellidos as Madre_Apellidos,
                        p.Nombres as Padre_Nombres, p.Apellidos as Padre_Apellidos,
                        c.Nombres as Cuidador_Nombres, c.Apellidos as Cuidador_Apellidos
                    FROM Familias f
                    LEFT JOIN Madre m ON f.Id_madre = m.Id_madre
                    LEFT JOIN Padre p ON f.Id_padre = p.Id_padre
                    LEFT JOIN Cuidador c ON f.Id_cuidador = c.Id_cuidador
                    WHERE f.Numero_documento = ? AND f.Tipo_documento = ?";
            
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("ss", $numeroDocumento, $tipoDocumento);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;

        } catch (Exception $e) {
            error_log("Error al obtener beneficiario: " . $e->getMessage());
            return null;
        }
    }
}