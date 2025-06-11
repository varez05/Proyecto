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

// 5. Detalle de niños menores de 5 años (usando tabla Familias, mostrando campos relevantes)
$sql5 = "SELECT f.Id_familia, f.Tipo_documento, f.Numero_documento, f.Nombres, f.Apellidos, f.Fecha_nacimiento, f.Telefono, f.Correo, f.Cuidador, c.Nombre_comunidad
FROM Familias f
INNER JOIN Comunidad c ON f.Id_comunidad = c.Id_comunidad
WHERE TIMESTAMPDIFF(YEAR, f.Fecha_nacimiento, CURDATE()) < 5
ORDER BY c.Nombre_comunidad, f.Nombres, f.Apellidos";
$detalle_ninos_menores_5 = $conn->query($sql5)->fetchAll(PDO::FETCH_ASSOC);

// 6. Detalle de niños de 6 a 14 años (usando tabla Familias, mostrando campos relevantes)
$sql6 = "SELECT f.Id_familia, f.Tipo_documento, f.Numero_documento, f.Nombres, f.Apellidos, f.Fecha_nacimiento, f.Telefono, f.Correo, f.Cuidador, c.Nombre_comunidad
FROM Familias f
INNER JOIN Comunidad c ON f.Id_comunidad = c.Id_comunidad
WHERE TIMESTAMPDIFF(YEAR, f.Fecha_nacimiento, CURDATE()) BETWEEN 6 AND 14
ORDER BY c.Nombre_comunidad, f.Nombres, f.Apellidos";
$detalle_ninos_6a14 = $conn->query($sql6)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Reportes</h1>
    <div class="header-container">
        <h2>Cantidad de Comunidades por Unidad</h2>
        <button class="boton" id="pdf-comunidades-unidad">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres" id="tabla-comunidades-unidad">
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
        <button class="boton" id="pdf-familias-comunidad">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres" id="tabla-familias-comunidad">
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
        <button class="boton" id="pdf-familias-menores5">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres" id="tabla-familias-menores5">
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
        <button class="boton" id="pdf-familias-6a14">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres" id="tabla-familias-6a14">
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
<div class="container">
    <div class="header-container">
        <h2>Detalle de niños menores de 5 años</h2>
        <button class="boton" id="pdf-detalle-menores5">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres" id="tabla-detalle-menores5">
        <thead>
            <tr>
                <th>ID Familia</th>
                <th>Tipo Doc</th>
                <th>N° Doc</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha Nac.</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Cuidador</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $comunidad_actual = null;
            foreach ($detalle_ninos_menores_5 as $row):
                if ($comunidad_actual !== $row['Nombre_comunidad']):
                    $comunidad_actual = $row['Nombre_comunidad'];
            ?>
                <tr class="encabezado-comunidad">
                    <td colspan="9" style="font-weight:bold; background:#e3e3e3; color:#2c3e50;">
                        <?= htmlspecialchars($comunidad_actual) ?>
                    </td>
                </tr>
            <?php endif; ?>
                <tr>
                    <td><?= htmlspecialchars($row['Id_familia']) ?></td>
                    <td><?= htmlspecialchars($row['Tipo_documento']) ?></td>
                    <td><?= htmlspecialchars($row['Numero_documento']) ?></td>
                    <td><?= htmlspecialchars($row['Nombres']) ?></td>
                    <td><?= htmlspecialchars($row['Apellidos']) ?></td>
                    <td><?= htmlspecialchars($row['Fecha_nacimiento']) ?></td>
                    <td><?= htmlspecialchars($row['Telefono']) ?></td>
                    <td><?= htmlspecialchars($row['Correo']) ?></td>
                    <td><?= htmlspecialchars($row['Cuidador']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="container">
    <div class="header-container">
        <h2>Detalle de niños de 6 a 14 años</h2>
        <button class="boton" id="pdf-detalle-6a14">
            <ion-icon name="download-outline"></ion-icon>
            <span> PDF </span>
        </button>
    </div>
    <table class="tabla-lideres" id="tabla-detalle-6a14">
        <thead>
            <tr>
                <th>ID Familia</th>
                <th>Tipo Doc</th>
                <th>N° Doc</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha Nac.</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Cuidador</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $comunidad_actual = null;
            foreach ($detalle_ninos_6a14 as $row):
                if ($comunidad_actual !== $row['Nombre_comunidad']):
                    $comunidad_actual = $row['Nombre_comunidad'];
            ?>
                <tr class="encabezado-comunidad">
                    <td colspan="9" style="font-weight:bold; background:#e3e3e3; color:#2c3e50;">
                        <?= htmlspecialchars($comunidad_actual) ?>
                    </td>
                </tr>
            <?php endif; ?>
                <tr>
                    <td><?= htmlspecialchars($row['Id_familia']) ?></td>
                    <td><?= htmlspecialchars($row['Tipo_documento']) ?></td>
                    <td><?= htmlspecialchars($row['Numero_documento']) ?></td>
                    <td><?= htmlspecialchars($row['Nombres']) ?></td>
                    <td><?= htmlspecialchars($row['Apellidos']) ?></td>
                    <td><?= htmlspecialchars($row['Fecha_nacimiento']) ?></td>
                    <td><?= htmlspecialchars($row['Telefono']) ?></td>
                    <td><?= htmlspecialchars($row['Correo']) ?></td>
                    <td><?= htmlspecialchars($row['Cuidador']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Enlaza jsPDF y el script de exportación de reportes -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="/Proyecto/Script/reportes_pdf.js"></script>