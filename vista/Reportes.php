<?php
// ...existing code...
?>
<div class="container">
    <h1>Reportes del Sistema</h1>
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
        <button class="boton" onclick="mostrarReporte('sesiones')">Reporte de Ingresos</button>
        <button class="boton" onclick="mostrarReporte('otro')">Otro Reporte</button>
        <!-- Agrega más botones para otros reportes aquí -->
    </div>
    <div id="contenedor-reporte" style="margin-top: 20px;"></div>
</div>
<script>
async function mostrarReporte(tipo) {
    const contenedor = document.getElementById('contenedor-reporte');
    contenedor.innerHTML = '<p>Cargando...</p>';
    if (tipo === 'sesiones') {
        const resp = await fetch('Reportes.php?reporte=sesiones');
        const html = await resp.text();
        contenedor.innerHTML = html;
    } else if (tipo === 'otro') {
        contenedor.innerHTML = '<p>Próximamente: otro reporte.</p>';
    }
}
// Mostrar por defecto el reporte de sesiones
mostrarReporte('sesiones');
</script>
<?php
// Renderizado parcial para AJAX
if (isset($_GET['reporte']) && $_GET['reporte'] === 'sesiones') {
    require_once '../modelo/conexion.php';
    $sql = "SELECT * FROM Sesiones ORDER BY fecha_hora DESC";
    $result = $conexion->query($sql);
    echo '<table class="tabla-lideres">';
    echo '<thead><tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Fecha y Hora</th><th>IP</th><th>Navegador/Dispositivo</th></tr></thead><tbody>';
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['usuario']) . '</td>';
            echo '<td>' . htmlspecialchars($row['rol']) . '</td>';
            echo '<td>' . htmlspecialchars($row['fecha_hora']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ip']) . '</td>';
            echo '<td style="max-width:200px; overflow-x:auto;"><small>' . htmlspecialchars($row['user_agent']) . '</small></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="center">No hay registros de sesiones.</td></tr>';
    }
    echo '</tbody></table>';
    exit;
}
// ...existing code...