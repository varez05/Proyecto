<?php
include '../modelo/conexion.php';

$query = "SELECT id, usuario, fecha_hora, rol, ip, user_agent FROM Sesiones ORDER BY fecha_hora DESC";
$result = $conexion->query($query);
?>
<div class="container">
    <h2>Historial de Sesiones</h2>
        <table class="tabla-lideres">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora</th>
                    <th>Rol</th>
                    <th>IP</th>
                    <th>User Agent</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                            <td><?php echo $row['fecha_hora']; ?></td>
                            <td><?php echo htmlspecialchars($row['rol']); ?></td>
                            <td><?php echo htmlspecialchars($row['ip']); ?></td>
                            <td style="max-width:200px;overflow-x:auto;"><?php echo htmlspecialchars($row['user_agent']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">No hay registros de sesiones.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
</div>
<?php $conexion->close(); ?>
