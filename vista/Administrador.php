<?php
require_once '../modelo/conexion.php';
// Consulta para obtener todos los administradores
$sql = "SELECT * FROM Administrador";
$result = $conexion->query($sql);
?>
<div class="container">
    <div class="header-container">
        <h1>Gestión de Administradores</h1>
        <button id="btn-agregar" class="btn-modificar" onclick="btnAbrirModal('agregar-administrador-container')">Agregar Administrador</button>
    </div>


    <h2>Lista de Administradores</h2>
    <table class="tabla-lideres">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="center"><?php echo $row['Id_admin']; ?></td>
                        <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['Usuario']); ?></td>
                        <td><?php echo htmlspecialchars($row['Correo']); ?></td>
                        <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
                        <td class="center">
                            <?php if (!empty($row['Img'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($row['Img']); ?>" alt="Foto de perfil" class="profile-img">
                            <?php else: ?>
                                <span>Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td class="center">
                            <div class="dropdown">
                                <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="EditarAdmin({
                                        Id_admin: <?php echo $row['Id_admin']; ?>,
                                        Nombre: '<?php echo htmlspecialchars($row['Nombre']); ?>',
                                        Usuario: '<?php echo htmlspecialchars($row['Usuario']); ?>',
                                        Correo: '<?php echo htmlspecialchars($row['Correo']); ?>',
                                        Telefono: '<?php echo htmlspecialchars($row['Telefono']); ?>'
                                    })">Modificar</a>
                                    <a class="dropdown-item" onclick="eliminarAdminHandler(event, <?php echo $row['Id_admin']; ?>)">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="center">No hay administradores registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include '../modales/ModalAdministrador.html'; ?>
<script src="../Script/modal.js"></script>