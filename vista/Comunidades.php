<?php
require_once '../Controladores/ComunidadesController.php';

// Obtener datos de unidades para el select
$sql_unidades = "SELECT Id_unidad, Nombre FROM Unidad ORDER BY Nombre";
$resultado_unidades = $conn->query($sql_unidades);

// Obtener todas las comunidades para mostrarlas
$sql_comunidades = "SELECT c.Id_comunidad, c.Nombre_comunidad, c.Autoridad, c.Id_unidad, u.Nombre as Nombre_unidad 
                    FROM Comunidad c 
                    JOIN Unidad u ON c.Id_unidad = u.Id_unidad 
                    ORDER BY c.Nombre_comunidad";
$resultado_comunidades = $conn->query($sql_comunidades);

?>

<div class="container">
    <div class="header-section">
        <h1>Gestión de Comunidades</h1>
        <button onclick="abrirModalCrearComunidad()">Nueva Comunidad</button>
    </div>

    <!-- Contenedor para mensajes -->
    <div id="mensaje" class="mensaje" style="display: none;"></div>

    <!-- Tabla de Comunidades -->
    <h2>Lista de Comunidades</h2>
    <table class="tabla-lideres">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Comunidad</th>
                <th>Autoridad</th>
                <th>Unidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado_comunidades->num_rows > 0): ?>
                <?php while ($row = $resultado_comunidades->fetch_assoc()): ?>
                    <tr>
                        <td class="center"><?php echo $row['Id_comunidad']; ?></td>
                        <td><?php echo htmlspecialchars($row['Nombre_comunidad']); ?></td>
                        <td><?php echo htmlspecialchars($row['Autoridad']); ?></td>
                        <td><?php echo htmlspecialchars($row['Nombre_unidad']); ?></td>
                        <td class="center">
                            <div class="dropdown">
                                <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item" onclick="editarComunidad({
                                        Id_comunidad: <?php echo $row['Id_comunidad']; ?>,
                                        Nombre_comunidad: '<?php echo htmlspecialchars($row['Nombre_comunidad']); ?>',
                                        Autoridad: '<?php echo htmlspecialchars($row['Autoridad']); ?>',
                                        Id_unidad: <?php echo $row['Id_unidad']; ?>
                                    })">Modificar</a>
                                    <a href="?eliminar=<?php echo $row['Id_comunidad']; ?>" class="dropdown-item btn-eliminar"
                                        onclick="return confirm('¿Está seguro de eliminar esta comunidad?');">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="center">No hay comunidades registradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>