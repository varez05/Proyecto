<?php 
$conexion = mysqli_connect("localhost", "root", "", "corporacion");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
$conexion->set_charset("utf8");
?>
