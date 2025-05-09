<?php 
$conexion = mysqli_connect("b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com", "uvzy20bldxipuq8x", "cTXQO8Rz00laC0L5lFP8", "b8b6wjxwwgatbkzi3sc7");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
$conexion->set_charset("utf8");
?>
