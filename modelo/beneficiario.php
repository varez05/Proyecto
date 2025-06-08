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
            $query = "SELECT 
    f.Id_familia,
    f.Fecha_inscripcion,
    f.Id_comunidad,
    c.Nombre_comunidad as Direccion,
    f.Tipo_usuario,
    f.Tipo_documento,
    f.Numero_documento,
    f.Nombres,
    f.Apellidos,
    f.Fecha_nacimiento,
    f.Lugar_nacimiento,
    f.Sexo,
    f.Telefono,
    f.Correo,
    f.Autoreconicido,
    f.Etnia,
    f.Cuidador    AS Cuidador_Nombres,
    f.Padre       AS Padre_Nombres,
    f.Madre       AS Madre_Nombres
FROM 
    Familias f
LEFT JOIN 
    Comunidad c ON f.Id_comunidad = c.Id_comunidad
WHERE 
    f.Numero_documento = ?
    AND f.Tipo_documento = ?;";
            
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