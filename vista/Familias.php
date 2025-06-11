<?php
// Incluir el controlador
require_once '../Controladores/FamiliasController.php';

// Consultar solo familias para la tabla
$familias_query = "SELECT * FROM Familias";
$familias_result = $conn->query($familias_query)->fetchAll(PDO::FETCH_ASSOC);
?>


    <div class="Div-container">
        <h1>Gestión de Familias</h1>
        <button id="btn-agregar-familia" class="btn-modificar" onclick="btnAbrirModal('modal-agregar-familia'); cargarComunidades();">Agregar Familia</button>
    </div>
    <!-- Tabla Familias -->
    <div class="table-container">
        <h2>Familias Registradas</h2>
        <table class="tabla-familias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha Inscripción</th>
                    <th>ID Comunidad</th>
                    <th>Tipo Usuario</th>
                    <th>Tipo Documento</th>
                    <th>Número Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Fecha Nacimiento</th>
                    <th>Lugar Nacimiento</th>
                    <th>Sexo</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Autoreconocido</th>
                    <th>Etnia</th>
                    <th>Cuidador</th>
                    <th>Padre</th>
                    <th>Madre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($familias_result)): ?>
                    <?php foreach ($familias_result as $familia): ?>
                        <tr>
                            <td class="center"><?php echo $familia['Id_familia']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($familia['Fecha_inscripcion'])); ?></td>
                            <td><?php echo htmlspecialchars($familia['Id_comunidad']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Tipo_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Tipo_documento']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Numero_documento']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Nombres']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Apellidos']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($familia['Fecha_nacimiento'])); ?></td>
                            <td><?php echo htmlspecialchars($familia['Lugar_nacimiento']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Sexo']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Telefono']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Correo']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Autoreconicido']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Etnia']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Cuidador']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Padre']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Madre']); ?></td>
                            <td class="center">
                                <div class="dropdown">
                                    <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                    <div class="dropdown-menu">
                                        <a href="../Controladores/FamiliasController.php?eliminar=<?php echo $familia['Id_familia']; ?>" class="dropdown-item" onclick="eliminarFamilia(event, this.href)">Eliminar</a>
                                        <a href="#" class="dropdown-item" onclick='editarFamilia(event, <?php echo json_encode($familia, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'>Modificar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="19" class="center">No hay familias registradas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

