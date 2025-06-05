<?php
// Controlador para Familias
$servername = "b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com";
$username = "uvzy20bldxipuq8x";
$password = "cTXQO8Rz00laC0L5lFP8";
$dbname = "b8b6wjxwwgatbkzi3sc7";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "Error de conexión: " . $e->getMessage()]));
}

// Validar documento único en Familias
function validarDocumentoFamilia($tipo_documento, $numero_documento, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Familias WHERE Tipo_documento = ? AND Numero_documento = ?");
    $stmt->execute([$tipo_documento, $numero_documento]);
    $count = $stmt->fetchColumn();
    return $count === 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validar_documento'])) {
    try {
        $tipoDoc = $_POST['tipo_documento'];
        $numDoc = $_POST['numero_documento'];
        $esUnico = validarDocumentoFamilia($tipoDoc, $numDoc, $conn);
        header('Content-Type: application/json');
        echo json_encode(['esUnico' => $esUnico]);
        exit;
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['validar_documento'])) {
    try {
        $conn->beginTransaction();
        // Insertar nueva familia
        if (isset($_POST['tipo_documento']) && isset($_POST['numero_documento'])) {
            $tipo_documento = $_POST['tipo_documento'];
            $numero_documento = $_POST['numero_documento'];
            if (!validarDocumentoFamilia($tipo_documento, $numero_documento, $conn)) {
                throw new Exception("El número de documento ya existe para una familia");
            }
            $stmt = $conn->prepare("INSERT INTO Familias (
                Fecha_inscripcion, Id_comunidad, Tipo_usuario, Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Lugar_nacimiento, Sexo, Telefono, Correo, Autoreconicido, Etnia, Cuidador, Padre, Madre
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['fecha_inscripcion'],
                $_POST['id_comunidad'],
                $_POST['tipo_usuario'],
                $_POST['tipo_documento'],
                $_POST['numero_documento'],
                $_POST['nombres'],
                $_POST['apellidos'],
                $_POST['fecha_nacimiento'],
                $_POST['lugar_nacimiento'],
                $_POST['sexo'],
                $_POST['telefono'],
                $_POST['correo'],
                $_POST['autoreconicido'],
                $_POST['etnia'],
                $_POST['cuidador'],
                $_POST['padre'],
                $_POST['madre']
            ]);
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Familia registrada correctamente"]);
            exit;
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
        exit;
    }
}
// ...existing code for selects and queries...
