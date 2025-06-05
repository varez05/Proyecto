<?php 
$conexion = mysqli_connect("b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com", "uvzy20bldxipuq8x", "cTXQO8Rz00laC0L5lFP8", "b8b6wjxwwgatbkzi3sc7");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
$conexion->set_charset("utf8");

// Función para conexión PDO
function conectar() {
    $host = "b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com";
    $db = "b8b6wjxwwgatbkzi3sc7";
    $user = "uvzy20bldxipuq8x";
    $pass = "cTXQO8Rz00laC0L5lFP8";
    $charset = "utf8";
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión PDO: " . $e->getMessage());
    }
}
?>
