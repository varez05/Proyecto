<?php
require_once '../modelo/conexion.php';

$sql = "SELECT Id_comunidad, Nombre_comunidad FROM Comunidad";
$result = $conexion->query($sql);

$comunidades = [];
while ($row = $result->fetch_assoc()) {
    $comunidades[] = $row;
}
header('Content-Type: application/json');
echo json_encode($comunidades);
?>
