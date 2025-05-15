<?php
require_once '../Controladores/UnidadesController.php';
$result = obtenerUnidades($conn);
?>

<!-- Contenedor principal -->
<div class="container">
    <!-- Contenedor para mostrar mensajes -->
    <div id="mensaje" class="mensaje" style="display: none;">

    </div>

    <!-- Botón para agregar unidad -->
    <div class="header">
        <h1>Gestión de Unidades</h1>
        <button id="btn-agregar-unidad" class="btn-modificar" onclick="btnAbrirModal('agregar-container')">Agregar Unidad</button>
    </div>


    <div class="tabla">
        <!-- Mostrar contenido de la tabla Unidad -->
        <h2>Lista de Unidades</h2>
        <table class="tabla-unidades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="center"><?php echo $row['Id_unidad']; ?></td>
                            <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                            <td class="center">
                                <a href="../Controladores/UnidadesController.php?eliminar=<?php echo $row['Id_unidad']; ?>" class="btn-eliminar" onclick="eliminarUnidad(event, this.href)">Eliminar</a>
                                <a href="#" class="btn-modificar" onclick="editarUnidad(event, <?php echo $row['Id_unidad']; ?>, '<?php echo htmlspecialchars($row['Nombre']); ?>')">Modificar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="center">No hay unidades registradas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



<script src="../Script/unidades.js"></script>


