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

function validarDocumento($tipo_documento, $numero_documento, $conn, $tabla, $campo) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM $tabla WHERE Tipo_documento = ? AND Numero_documento = ?");
    $stmt->execute([$tipo_documento, $numero_documento]);
    $count = $stmt->fetchColumn();
    return $count === 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validar_documento'])) {
    try {
        $tipo = $_POST['tipo'];
        $tipoDoc = $_POST['tipo_documento'];
        $numDoc = $_POST['numero_documento'];
        $tabla = ucfirst($tipo);
        $esUnico = validarDocumento($tipoDoc, $numDoc, $conn, $tabla, 'Numero_documento');
        header('Content-Type: application/json');
        echo json_encode(['esUnico' => $esUnico]);
        exit;
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn->beginTransaction();
        if (isset($_POST['madre_tipo_documento'])) {
            if (!validarDocumento($_POST['madre_tipo_documento'], $_POST['madre_numero_documento'], $conn, 'Madre', 'Numero_documento')) {
                throw new Exception("El número de documento ya existe para la madre");
            }
            $stmt = $conn->prepare("INSERT INTO Madre (Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Lugar_nacimiento, Sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['madre_tipo_documento'],
                $_POST['madre_numero_documento'],
                $_POST['madre_nombres'],
                $_POST['madre_apellidos'],
                $_POST['madre_fecha_nacimiento'],
                $_POST['madre_lugar_nacimiento'],
                'Femenino'
            ]);
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Madre registrada correctamente"]);
            exit;
        }
        if (isset($_POST['padre_tipo_documento']) && !empty($_POST['padre_numero_documento'])) {
            if (!validarDocumento($_POST['padre_tipo_documento'], $_POST['padre_numero_documento'], $conn, 'Padre', 'Numero_documento')) {
                throw new Exception("El número de documento ya existe para el padre");
            }
            $stmt = $conn->prepare("INSERT INTO Padre (Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Lugar_nacimiento, Sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['padre_tipo_documento'],
                $_POST['padre_numero_documento'],
                $_POST['padre_nombres'],
                $_POST['padre_apellidos'],
                $_POST['padre_fecha_nacimiento'],
                $_POST['padre_lugar_nacimiento'],
                'Masculino'
            ]);
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Padre registrado correctamente"]);
            exit;
        }
        if (isset($_POST['cuidador_tipo_documento'])) {
            if (!validarDocumento($_POST['cuidador_tipo_documento'], $_POST['cuidador_numero_documento'], $conn, 'Cuidador', 'Numero_documento')) {
                throw new Exception("El número de documento ya existe para el cuidador");
            }
            $stmt = $conn->prepare("INSERT INTO Cuidador (Parentesco, Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Lugar_nacimiento, Sexo, Telefono, Correo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['cuidador_parentesco'],
                $_POST['cuidador_tipo_documento'],
                $_POST['cuidador_numero_documento'],
                $_POST['cuidador_nombres'],
                $_POST['cuidador_apellidos'],
                $_POST['cuidador_fecha_nacimiento'],
                $_POST['cuidador_lugar_nacimiento'],
                $_POST['cuidador_sexo'],
                $_POST['cuidador_telefono'],
                $_POST['cuidador_correo']
            ]);
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Cuidador registrado correctamente"]);
            exit;
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
        exit;
    }
}
// ...existing code for selects and queries...
