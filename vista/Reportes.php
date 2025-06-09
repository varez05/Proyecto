<?php
require_once '../Controladores/FamiliasController.php';

// Conexión directa para reportes (PDO)
$servername = "b8b6wjxwwgatbkzi3sc7-mysql.services.clever-cloud.com";
$username = "uvzy20bldxipuq8x";
$password = "cTXQO8Rz00laC0L5lFP8";
$dbname = "b8b6wjxwwgatbkzi3sc7";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Comunidades por unidad
$sql1 = "SELECT u.Nombre AS Unidad, COUNT(c.Id_comunidad) AS TotalComunidades
         FROM Unidad u
         LEFT JOIN Comunidad c ON u.Id_unidad = c.Id_unidad
         GROUP BY u.Id_unidad, u.Nombre
         ORDER BY u.Nombre";
$comunidades_por_unidad = $conn->query($sql1)->fetchAll(PDO::FETCH_ASSOC);

// 2. Familias por comunidad
$sql2 = "SELECT c.Nombre_comunidad, COUNT(f.Id_familia) AS TotalFamilias
         FROM Comunidad c
         LEFT JOIN Familias f ON c.Id_comunidad = f.Id_comunidad
         GROUP BY c.Id_comunidad, c.Nombre_comunidad
         ORDER BY c.Nombre_comunidad";
$familias_por_comunidad = $conn->query($sql2)->fetchAll(PDO::FETCH_ASSOC);

// 3. Familias con niños menores de 5 años (al menos un niño <5)
$sql3 = "SELECT c.Nombre_comunidad, COUNT(DISTINCT f.Id_familia) AS FamiliasMenores5
FROM Comunidad c
LEFT JOIN Familias f ON c.Id_comunidad = f.Id_comunidad
WHERE TIMESTAMPDIFF(YEAR, f.Fecha_nacimiento, CURDATE()) < 5
GROUP BY c.Id_comunidad, c.Nombre_comunidad
ORDER BY c.Nombre_comunidad";
$familias_menores_5 = $conn->query($sql3)->fetchAll(PDO::FETCH_ASSOC);

// 4. Familias con niños de 6 a 14 años (al menos un niño 6-14)
$sql4 = "SELECT c.Nombre_comunidad, COUNT(DISTINCT f.Id_familia) AS Familias6a14
FROM Comunidad c
LEFT JOIN Familias f ON c.Id_comunidad = f.Id_comunidad
WHERE TIMESTAMPDIFF(YEAR, f.Fecha_nacimiento, CURDATE()) BETWEEN 6 AND 14
GROUP BY c.Id_comunidad, c.Nombre_comunidad
ORDER BY c.Nombre_comunidad";
$familias_6a14 = $conn->query($sql4)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Reportes</h1>
    <h2>Cantidad de Comunidades por Unidad</h2>
    <table class="tabla-lideres">
        <thead>
            <tr>
                <th>Unidad</th>
                <th>Total Comunidades</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comunidades_por_unidad as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Unidad']) ?></td>
                    <td><?= $row['TotalComunidades'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="container">
    <div class="header-container">
        <h2>Cantidad de Familias por Comunidad</h2>
        <button class="boton">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres">
        <thead>
            <tr>
                <th>Comunidad</th>
                <th>Total Familias</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($familias_por_comunidad as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Nombre_comunidad']) ?></td>
                    <td><?= $row['TotalFamilias'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="container">
    <div class="header-container">
        <h2>Familias con niños menores de 5 años</h2>
        <button class="boton">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres">
        <thead>
            <tr>
                <th>Comunidad</th>
                <th>Familias con niños &lt; 5 años</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($familias_menores_5 as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Nombre_comunidad']) ?></td>
                    <td><?= $row['FamiliasMenores5'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="container">
    <div class="header-container">
        <h2>Familias con niños de 6 a 14 años</h2>
        <button class="boton">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres">
        <thead>
            <tr>
                <th>Comunidad</th>
                <th>Familias con niños 6-14 años</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($familias_6a14 as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Nombre_comunidad']) ?></td>
                    <td><?= $row['Familias6a14'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>