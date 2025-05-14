<?php
// Configuración de la conexión a la base de datos
$servername = "b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com";
$username = "uvzy20bldxipuq8x";
$password = "cTXQO8Rz00laC0L5lFP8";
$dbname = "b8b6wjxwwgatbkzi3sc7";

try {
    // Crear conexión con PDO para mejor seguridad
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Agregar al principio del archivo, después de la conexión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validar_documento'])) {
    try {
        $tipo = $_POST['tipo'];
        $tipoDoc = $_POST['tipo_documento'];
        $numDoc = $_POST['numero_documento'];
        
        $tabla = ucfirst($tipo); // Capitaliza la primera letra
        
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

// Función para limpiar y validar inputs
function limpiarInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para mostrar notificación
function mostrarNotificacion($mensaje, $tipo = 'success') {
    if (!empty($mensaje)) {
        echo "<div class='notification {$tipo}'>{$mensaje}</div>";
    }
}

// Función para validar documento único
function validarDocumento($tipo_documento, $numero_documento, $conn, $tabla, $campo) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM $tabla WHERE Tipo_documento = ? AND Numero_documento = ?");
    $stmt->execute([$tipo_documento, $numero_documento]);
    $count = $stmt->fetchColumn();
    return $count === 0;
}

// Inicializar variables para mensajes
$mensaje = "";
$error = "";

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn->beginTransaction();

        // Procesar formulario de madre
        if (isset($_POST['madre_tipo_documento'])) {
            // Validar documento único
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
            mostrarNotificacion("Madre registrada correctamente", "success");
            exit;
        }

        // Procesar formulario de padre
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
            mostrarNotificacion("Padre registrado correctamente", "success");
            exit;
        }

        // Procesar formulario de cuidador
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
            mostrarNotificacion("Cuidador registrado correctamente", "success");
            exit;
        }

    } catch (Exception $e) {
        $conn->rollBack();
        mostrarNotificacion($e->getMessage(), "error");
        exit;
    }
}

// Consultar madres para el select
$madres_query = "SELECT Id_madre, CONCAT(Nombres, ' ', Apellidos, ' - ', Numero_documento) as nombre_completo FROM Madre ORDER BY Apellidos";
$madres_result = $conn->query($madres_query);

// Consultar padres para el select
$padres_query = "SELECT Id_padre, CONCAT(Nombres, ' ', Apellidos, ' - ', Numero_documento) as nombre_completo FROM Padre ORDER BY Apellidos";
$padres_result = $conn->query($padres_query);

// Consultar cuidadores para el select
$cuidadores_query = "SELECT Id_cuidador, CONCAT(Nombres, ' ', Apellidos, ' - ', Numero_documento, ' (', Parentesco, ')') as nombre_completo FROM Cuidador ORDER BY Apellidos";
$cuidadores_result = $conn->query($cuidadores_query);

$queries = [
    'familias' => "SELECT f.*, 
                   m.Nombres as Madre_Nombres, m.Apellidos as Madre_Apellidos,
                   p.Nombres as Padre_Nombres, p.Apellidos as Padre_Apellidos,
                   c.Nombres as Cuidador_Nombres, c.Apellidos as Cuidador_Apellidos
                   FROM Familias f 
                   LEFT JOIN Madre m ON f.Id_madre = m.Id_madre
                   LEFT JOIN Padre p ON f.Id_padre = p.Id_padre
                   LEFT JOIN Cuidador c ON f.Id_cuidador = c.Id_cuidador",
    'cuidadores' => "SELECT * FROM Cuidador",
    'madres' => "SELECT * FROM Madre",
    'padres' => "SELECT * FROM Padre"
];

$results = [];
foreach ($queries as $key => $query) {
    $results[$key] = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familias</title>
    <link rel="stylesheet" href="../Css/Familias.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            font-size: 14px;
            min-width: 280px;
            animation: slideIn 0.5s ease-out;
        }

        .alert-error {
            background-color: #dc3545;
            color: white;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <?php 
    if (!empty($mensaje)) {
        mostrarNotificacion($mensaje, 'success');
    }
    if (!empty($error)) {
        mostrarNotificacion($error, 'error');
    }
    ?>

    <div class="gestion-contenedor">
        <h1>Gestión de Familias</h1>
        <button id="btn-agregar-madre" class="btn-modificar">Agregar Madre</button>
        <button id="btn-agregar-padre" class="btn-modificar">Agregar Padre</button>
        <button id="btn-agregar-cuidador" class="btn-modificar">Agregar Cuidador</button>
        <button id="btn-agregar-familia" class="btn-modificar">Agregar Familia</button>
    </div>

    <section class="container">
        <div class="tabla-familia" id="madre" role="tabpanel" aria-labelledby="madre-tab">
            <div class="form-section">
                <span class="close">&times;</span>
                <h2>Registro de Madre</h2>
                <form method="post" id="form-madre" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="col-md-6">
                        <label for="madre_tipo_documento" class="form-label">Tipo de Documento</label>
                        <select class="form-select" id="madre_tipo_documento" name="madre_tipo_documento" required>
                            <option value="">Seleccione...</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="TI">Tarjeta de Identidad</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="madre_numero_documento" class="form-label">Número de Documento</label>
                        <input type="text" 
                               class="form-control" 
                               id="madre_numero_documento" 
                               name="madre_numero_documento" 
                               pattern="[0-9]+" 
                               title="Solo se permiten números"
                               required>
                    </div>


                    <div class="col-md-6">
                        <label for="madre_nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="madre_nombres" name="madre_nombres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="madre_apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="madre_apellidos" name="madre_apellidos" required>
                    </div>


                    <div class="col-md-6">
                        <label for="madre_fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="madre_fecha_nacimiento" name="madre_fecha_nacimiento" required>
                    </div>
                    <div class="col-md-6">
                        <label for="madre_lugar_nacimiento" class="form-label">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="madre_lugar_nacimiento" name="madre_lugar_nacimiento" required>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Formulario para registrar Padre -->
        <div class="tabla-familia" id="padre" role="tabpanel" aria-labelledby="padre-tab">
            <div class="form-section">
                <span class="close">&times;</span>
                <h2>Registro de Padre</h2>
                <form method="post" id="form-padre" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                    <div class="col-md-6">
                        <label for="padre_tipo_documento" class="form-label">Tipo de Documento</label>
                        <select class="form-select" id="padre_tipo_documento" name="padre_tipo_documento">
                            <option value="">Seleccione...</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="TI">Tarjeta de Identidad</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="padre_numero_documento" class="form-label">Número de Documento</label>
                        <input type="text" class="form-control" id="padre_numero_documento" name="padre_numero_documento">
                    </div>
                    <div class="col-md-6">
                        <label for="padre_nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="padre_nombres" name="padre_nombres">
                    </div>
                    <div class="col-md-6">
                        <label for="padre_apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="padre_apellidos" name="padre_apellidos">
                    </div>
                    <div class="col-md-6">
                        <label for="padre_fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="padre_fecha_nacimiento" name="padre_fecha_nacimiento">
                    </div>
                    <div class="col-md-6">
                        <label for="padre_lugar_nacimiento" class="form-label">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="padre_lugar_nacimiento" name="padre_lugar_nacimiento">
                    </div>
                    <div class="form-buttons">
                        <button type="submit" class="btn-guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Formulario para registrar Cuidador -->
        <div class="tabla-familia" id="cuidador" role="tabpanel" aria-labelledby="cuidador-tab">
            <div class="form-section">
                <span class="close">&times;</span>
                <h2>Registro de Cuidador</h2>
                <form method="post" id="form-cuidador" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>

                    <div class="col-md-6">
                        <label for="cuidador_parentesco" class="form-label">Parentesco</label>
                        <select class="form-select" id="cuidador_parentesco" name="cuidador_parentesco" required>
                            <option value="">Seleccione...</option>
                            <option value="Madre">Madre</option>
                            <option value="Padre">Padre</option>
                            <option value="Abuelo/a">Abuelo/a</option>
                            <option value="Tío/a">Tío/a</option>
                            <option value="Hermano/a">Hermano/a</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="cuidador_tipo_documento" class="form-label">Tipo de Documento</label>
                        <select class="form-select" id="cuidador_tipo_documento" name="cuidador_tipo_documento" required>
                            <option value="">Seleccione...</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="TI">Tarjeta de Identidad</option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label for="cuidador_numero_documento" class="form-label">Número de Documento</label>
                        <input type="text" class="form-control" id="cuidador_numero_documento" name="cuidador_numero_documento" required>

                    </div>
                    <div class="col-md-6">
                        <label for="cuidador_sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="cuidador_sexo" name="cuidador_sexo" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>

                    </div>


                    <div class="col-md-6">
                        <label for="cuidador_nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="cuidador_nombres" name="cuidador_nombres" required>

                    </div>
                    <div class="col-md-6">
                        <label for="cuidador_apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="cuidador_apellidos" name="cuidador_apellidos" required>

                    </div>


                    <div class="col-md-6">
                        <label for="cuidador_fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="cuidador_fecha_nacimiento" name="cuidador_fecha_nacimiento" required>

                    </div>
                    <div class="col-md-6">
                        <label for="cuidador_lugar_nacimiento" class="form-label">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="cuidador_lugar_nacimiento" name="cuidador_lugar_nacimiento" required>

                    </div>


                    <div class="col-md-6">
                        <label for="cuidador_telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="cuidador_telefono" name="cuidador_telefono" required>

                    </div>
                    <div class="col-md-6">
                        <label for="cuidador_correo" class="form-label">Correo Electrónico</label>
                        <input type="email" 
                               class="form-control" 
                               id="cuidador_correo" 
                               name="cuidador_correo" 
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                               required>
                    </div>
                    <div class="form-buttons">
                        <button type="submit" class="btn-guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Formulario para registrar Familia -->
        <div class="tabla-familia" id="familia" role="tabpanel" aria-labelledby="familia-tab">
            <div class="form-section">
                <span class="close">&times;</span>
                <h2>Registro de Familia</h2>
                <form method="post" id="form-familia" class="form-modificar" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>

                    <div class="col-md-6">
                        <label for="familia_tipo_usuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="familia_tipo_usuario" name="familia_tipo_usuario" required>
                            <option value="">Seleccione...</option>
                            <option value="Niño/a">Niño/a</option>
                            <option value="Adolescente">Adolescente</option>
                            <option value="Adulto">Adulto</option>
                            <option value="Adulto Mayor">Adulto Mayor</option>
                        </select>

                    </div>
                    <div class="col-md-6">
                        <label for="familia_tipo_documento" class="form-label">Tipo de Documento</label>
                        <select class="form-select" id="familia_tipo_documento" name="familia_tipo_documento" required>
                            <option value="">Seleccione...</option>
                            <option value="RC">Registro Civil</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="CE">Cédula de Extranjería</option>
                        </select>

                    </div>


                    <div class="col-md-6">
                        <label for="familia_numero_documento" class="form-label">Número de Documento</label>
                        <input type="text" class="form-control" id="familia_numero_documento" name="familia_numero_documento" required>

                    </div>
                    <div class="col-md-6">
                        <label for="familia_sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="familia_sexo" name="familia_sexo" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>

                    </div>


                    <div class="col-md-6">
                        <label for="familia_nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="familia_nombres" name="familia_nombres" required>

                    </div>
                    <div class="col-md-6">
                        <label for="familia_apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="familia_apellidos" name="familia_apellidos" required>

                    </div>


                    <div class="col-md-6">
                        <label for="familia_fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="familia_fecha_nacimiento" name="familia_fecha_nacimiento" required>

                    </div>
                    <div class="col-md-6">
                        <label for="familia_lugar_nacimiento" class="form-label">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="familia_lugar_nacimiento" name="familia_lugar_nacimiento" required>

                    </div>


                    <div class="col-md-6">
                        <label for="familia_direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="familia_direccion" name="familia_direccion" required>

                    </div>


                    <div class="col-md-6">
                        <label for="familia_autoreconocido" class="form-label">Autoreconocido</label>
                        <input type="text" class="form-control" id="familia_autoreconocido" name="familia_autoreconocido">
                    </div>
                    <div class="col-md-6">
                        <label for="familia_etnia" class="form-label">Etnia</label>
                        <input type="text" class="form-control" id="familia_etnia" name="familia_etnia">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <!-- Tabla Familias -->
        <div class="table-container">
            <h2>Familias Registradas</h2>
            <table class="tabla-familias">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Fecha Inscripción</th>
                        <th>Tipo Usuario</th>
                        <th>Dirección</th>
                        <th>Madre</th>
                        <th>Padre</th>
                        <th>Cuidador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results['familias'])): ?>
                        <?php foreach ($results['familias'] as $familia): ?>
                            <tr>
                                <td class="center"><?php echo $familia['Id_familia']; ?></td>
                                <td><?php echo $familia['Tipo_documento'] . ': ' . htmlspecialchars($familia['Numero_documento']); ?></td>
                                <td><?php echo htmlspecialchars($familia['Nombres']); ?></td>
                                <td><?php echo htmlspecialchars($familia['Apellidos']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($familia['Fecha_inscripcion'])); ?></td>
                                <td><?php echo $familia['Tipo_usuario']; ?></td>
                                <td><?php echo htmlspecialchars($familia['Direccion']); ?></td>
                                <td><?php echo htmlspecialchars($familia['Madre_Nombres'] . ' ' . $familia['Madre_Apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($familia['Padre_Nombres'] . ' ' . $familia['Padre_Apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($familia['Cuidador_Nombres'] . ' ' . $familia['Cuidador_Apellidos']); ?></td>
                                <td class="center">
                                    <div class="dropdown">
                                        <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                        <div class="dropdown-menu">
                                            <a href="?modificar_familia=<?php echo $familia['Id_familia']; ?>" class="dropdown-item">Modificar</a>
                                            <a href="?eliminar_familia=<?php echo $familia['Id_familia']; ?>" class="dropdown-item btn-eliminar"
                                                onclick="return confirm('¿Está seguro de eliminar esta familia?');">Eliminar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="center">No hay familias registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla Madres -->
        <div class="table-container">
            <h2>Madres Registradas</h2>
            <table class="tabla-familias">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Fecha Nacimiento</th>
                        <th>Lugar Nacimiento</th>
                        <th>Sexo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results['madres'])): ?>
                        <?php foreach ($results['madres'] as $madre): ?>
                            <tr>
                                <td class="center"><?php echo $madre['Id_madre']; ?></td>
                                <td><?php echo $madre['Tipo_documento'] . ': ' . htmlspecialchars($madre['Numero_documento']); ?></td>
                                <td><?php echo htmlspecialchars($madre['Nombres']); ?></td>
                                <td><?php echo htmlspecialchars($madre['Apellidos']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($madre['Fecha_nacimiento'])); ?></td>
                                <td><?php echo htmlspecialchars($madre['Lugar_nacimiento']); ?></td>
                                <td><?php echo $madre['Sexo']; ?></td>
                                <td class="center">
                                    <div class="dropdown">
                                        <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                        <div class="dropdown-menu">
                                            <a href="?modificar_madre=<?php echo $madre['Id_madre']; ?>" class="dropdown-item">Modificar</a>
                                            <a href="?eliminar_madre=<?php echo $madre['Id_madre']; ?>" class="dropdown-item btn-eliminar"
                                                onclick="return confirm('¿Está seguro de eliminar este registro?');">Eliminar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="center">No hay madres registradas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla Padres -->
        <div class="table-container">
            <h2>Padres Registrados</h2>
            <table class="tabla-familias">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Fecha Nacimiento</th>
                        <th>Lugar Nacimiento</th>
                        <th>Sexo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results['padres'])): ?>
                        <?php foreach ($results['padres'] as $padre): ?>
                            <tr>
                                <td class="center"><?php echo $padre['Id_padre']; ?></td>
                                <td><?php echo $padre['Tipo_documento'] . ': ' . htmlspecialchars($padre['Numero_documento']); ?></td>
                                <td><?php echo htmlspecialchars($padre['Nombres']); ?></td>
                                <td><?php echo htmlspecialchars($padre['Apellidos']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($padre['Fecha_nacimiento'])); ?></td>
                                <td><?php echo htmlspecialchars($padre['Lugar_nacimiento']); ?></td>
                                <td><?php echo $padre['Sexo']; ?></td>
                                <td class="center">
                                    <div class="dropdown">
                                        <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                        <div class="dropdown-menu">
                                            <a href="?modificar_padre=<?php echo $padre['Id_padre']; ?>" class="dropdown-item">Modificar</a>
                                            <a href="?eliminar_padre=<?php echo $padre['Id_padre']; ?>" class="dropdown-item btn-eliminar"
                                                onclick="return confirm('¿Está seguro de eliminar este registro?');">Eliminar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="center">No hay padres registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla Cuidadores -->
        <div class="table-container">
            <h2>Cuidadores Registrados</h2>
            <table class="tabla-familias">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Parentesco</th>
                        <th>Fecha Nacimiento</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results['cuidadores'])): ?>
                        <?php foreach ($results['cuidadores'] as $cuidador): ?>
                            <tr>
                                <td class="center"><?php echo $cuidador['Id_cuidador']; ?></td>
                                <td><?php echo $cuidador['Tipo_documento'] . ': ' . htmlspecialchars($cuidador['Numero_documento']); ?></td>
                                <td><?php echo htmlspecialchars($cuidador['Nombres']); ?></td>
                                <td><?php echo htmlspecialchars($cuidador['Apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($cuidador['Parentesco']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($cuidador['Fecha_nacimiento'])); ?></td>
                                <td><?php echo htmlspecialchars($cuidador['Telefono']); ?></td>
                                <td><?php echo htmlspecialchars($cuidador['Correo']); ?></td>
                                <td class="center">
                                    <div class="dropdown">
                                        <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                        <div class="dropdown-menu">
                                            <a href="?modificar_cuidador=<?php echo $cuidador['Id_cuidador']; ?>" class="dropdown-item">Modificar</a>
                                            <a href="?eliminar_cuidador=<?php echo $cuidador['Id_cuidador']; ?>" class="dropdown-item btn-eliminar"
                                                onclick="return confirm('¿Está seguro de eliminar este registro?');">Eliminar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="center">No hay cuidadores registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Agregar scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Referencias a los botones
            const btnMadre = document.getElementById('btn-agregar-madre');
            const btnPadre = document.getElementById('btn-agregar-padre');
            const btnCuidador = document.getElementById('btn-agregar-cuidador');
            const btnFamilia = document.getElementById('btn-agregar-familia');

            // Referencias a los formularios
            const formularios = {
                madre: document.getElementById('madre'),
                padre: document.getElementById('padre'),
                cuidador: document.getElementById('cuidador'),
                familia: document.getElementById('familia')
            };

            // Ocultar todos los formularios inicialmente
            Object.values(formularios).forEach(form => {
                form.style.display = 'none';
            });

            // Función para mostrar un formulario
            function mostrarFormulario(tipo) {
                // Ocultar todos los formularios primero
                Object.values(formularios).forEach(form => {
                    form.style.display = 'none';
                });
                // Mostrar el formulario seleccionado
                formularios[tipo].style.display = 'flex';
            }

            // Event listeners para cada botón
            btnMadre.addEventListener('click', () => mostrarFormulario('madre'));
            btnPadre.addEventListener('click', () => mostrarFormulario('padre'));
            btnCuidador.addEventListener('click', () => mostrarFormulario('cuidador'));
            btnFamilia.addEventListener('click', () => mostrarFormulario('familia'));

            // Event listener para los botones de cerrar (X)
            document.querySelectorAll('.close').forEach(span => {
                span.addEventListener('click', function() {
                    const formulario = this.closest('.tabla-familia');
                    if (formulario) {
                        formulario.style.display = 'none';
                        // Limpiar el formulario
                        const form = formulario.querySelector('form');
                        if (form) form.reset();
                    }
                });
            });

            // Función para validar documento único
            async function validarDocumentoUnico(tipo, tipoDoc, numDoc) {
                try {
                    const formData = new FormData();
                    formData.append('validar_documento', '1');
                    formData.append('tipo', tipo);
                    formData.append('tipo_documento', tipoDoc);
                    formData.append('numero_documento', numDoc);

                    const response = await fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();
                    return data.esUnico;
                } catch (error) {
                    console.error('Error al validar documento:', error);
                    return false;
                }
            }

            // Manejar el envío de cada formulario
            const formMadre = document.getElementById('form-madre');
            const formPadre = document.getElementById('form-padre');
            const formCuidador = document.getElementById('form-cuidador');
            const formFamilia = document.getElementById('form-familia');

            formMadre.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!validarFormulario(this)) return;
                
                const formData = new FormData(this);
                await guardarRegistro(formData, 'madre');
                this.reset();
                document.getElementById('madre').style.display = 'none';
            });

            formPadre.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!this.querySelector('#padre_numero_documento').value.trim()) {
                    // Si no hay número de documento, no enviar el formulario
                    return;
                }
                
                const formData = new FormData(this);
                await guardarRegistro(formData, 'padre');
                this.reset();
                document.getElementById('padre').style.display = 'none';
            });

            formCuidador.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!validarFormulario(this)) return;
                
                const formData = new FormData(this);
                await guardarRegistro(formData, 'cuidador');
                this.reset();
                document.getElementById('cuidador').style.display = 'none';
            });

            formFamilia.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!validarFormulario(this)) return;
                
                const formData = new FormData(this);
                guardarRegistro(formData, 'familia');
            });

            // Función para validar formularios
            function validarFormulario(formulario) {
                const inputs = formulario.querySelectorAll('[required]');
                let isValid = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    mostrarAlerta('Por favor complete todos los campos obligatorios', 'error');
                }

                return isValid;
            }

            // Función para guardar registros
            async function guardarRegistro(formData, tipo) {
                const botonSubmit = document.querySelector(`#form-${tipo} button[type="submit"]`);
                botonSubmit.disabled = true;

                try {
                    const response = await fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }

                    mostrarAlerta(`${tipo.charAt(0).toUpperCase() + tipo.slice(1)} registrado/a correctamente`, 'success');
                    setTimeout(() => location.reload(), 2000);
                } catch (error) {
                    console.error('Error:', error);
                    mostrarAlerta(`Error al registrar ${tipo}`, 'error');
                } finally {
                    botonSubmit.disabled = false;
                }
            }

            // Función para mostrar alertas
            function mostrarAlerta(mensaje, tipo) {
                const alerta = document.createElement('div');
                alerta.className = `alert alert-${tipo}`;
                alerta.textContent = mensaje;
                alerta.style.position = 'fixed';
                alerta.style.top = '20px';
                alerta.style.right = '20px';
                alerta.style.zIndex = '9999';
                
                document.body.appendChild(alerta);

                setTimeout(() => {
                    alerta.remove();
                }, 3000);
            }

            // Manejar notificaciones
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.remove();
                }, 5000); // 5 segundos
            });
        });
    </script>
</body>

</html>