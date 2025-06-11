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

// Validar documento único en Familias (excluyendo un id opcional)
function validarDocumentoFamilia($tipo_documento, $numero_documento, $conn, $excluir_id = null) {
    if ($excluir_id) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM Familias WHERE Tipo_documento = ? AND Numero_documento = ? AND Id_familia != ?");
        $stmt->execute([$tipo_documento, $numero_documento, $excluir_id]);
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM Familias WHERE Tipo_documento = ? AND Numero_documento = ?");
        $stmt->execute([$tipo_documento, $numero_documento]);
    }
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['validar_documento']) && !isset($_POST['id_familia'])) {
    try {
        $conn->beginTransaction();
        // Insertar nueva familia
        if (isset($_POST['tipo_documento']) && isset($_POST['numero_documento'])) {
            $tipo_documento = $_POST['tipo_documento'];
            $numero_documento = $_POST['numero_documento'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            // Validar tipo de documento permitido
            $tiposPermitidos = ['Registro Civil', 'Tarjeta de Identidad'];
            if (!in_array($tipo_documento, $tiposPermitidos)) {
                throw new Exception("Solo se permiten Registro Civil o Tarjeta de Identidad");
            }
            // Calcular edad
            $hoy = new DateTime();
            $nacimiento = new DateTime($fecha_nacimiento);
            $edad = $hoy->diff($nacimiento)->y;
            // Validar edad
            if ($edad < 0 || $edad > 14) {
                throw new Exception("Solo se pueden registrar niños de 0 a 14 años");
            }
            // Asignar tipo de usuario
            if ($edad <= 5) {
                $tipo_usuario = 'A';
            } else {
                $tipo_usuario = 'C';
            }
            if (!validarDocumentoFamilia($tipo_documento, $numero_documento, $conn)) {
                throw new Exception("El número de documento ya existe para una familia");
            }
            $stmt = $conn->prepare("INSERT INTO Familias (
                Id_comunidad, Tipo_usuario, Tipo_documento, Numero_documento, Nombres, Apellidos, Fecha_nacimiento, Lugar_nacimiento, Sexo, Telefono, Correo, Autoreconicido, Etnia, Cuidador, Padre, Madre
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['id_comunidad'],
                $tipo_usuario,
                $tipo_documento,
                $numero_documento,
                $_POST['nombres'],
                $_POST['apellidos'],
                $fecha_nacimiento,
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
            echo json_encode(["success" => true, "message" => "Niño registrado correctamente"]);
            exit;
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
        exit;
    }
}

// Actualizar familia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_familia'])) {
    try {
        $conn->beginTransaction();
        $id_familia = $_POST['id_familia'];
        // Validar documento único excluyendo el propio id
        if (!validarDocumentoFamilia($_POST['tipo_documento'], $_POST['numero_documento'], $conn, $id_familia)) {
            throw new Exception("El número de documento ya existe para otra familia");
        }
        $stmt = $conn->prepare("UPDATE Familias SET Id_comunidad=?, Tipo_documento=?, Numero_documento=?, Nombres=?, Apellidos=?, Fecha_nacimiento=?, Lugar_nacimiento=?, Sexo=?, Telefono=?, Correo=?, Autoreconicido=?, Etnia=?, Cuidador=?, Padre=?, Madre=? WHERE Id_familia=?");
        $stmt->execute([
            $_POST['id_comunidad'],
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
            $_POST['madre'],
            $id_familia
        ]);
        $conn->commit();
        echo json_encode(["success" => true, "message" => "Familia actualizada correctamente"]);
    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
    exit();
}

// Eliminar familia
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    try {
        $stmt = $conn->prepare("DELETE FROM Familias WHERE Id_familia = ?");
        $stmt->execute([$id]);
        echo json_encode(["success" => true, "message" => "Familia eliminada correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error al eliminar la familia: " . $e->getMessage()]);
    }
    exit();
}

// ...existing code for selects and queries...
