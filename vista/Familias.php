<?php
// Incluir el controlador
require_once '../Controladores/FamiliasController.php';

// Consultar madres, padres, cuidadores y familias para los selects y tablas
$madres_query = "SELECT Id_madre, CONCAT(Nombres, ' ', Apellidos, ' - ', Numero_documento) as nombre_completo FROM Madre ORDER BY Apellidos";
$madres_result = $conn->query($madres_query);
$padres_query = "SELECT Id_padre, CONCAT(Nombres, ' ', Apellidos, ' - ', Numero_documento) as nombre_completo FROM Padre ORDER BY Apellidos";
$padres_result = $conn->query($padres_query);
$cuidadores_query = "SELECT Id_cuidador, CONCAT(Nombres, ' ', Apellidos, ' - ', Numero_documento, ' (', Parentesco, ')') as nombre_completo FROM Cuidador ORDER BY Apellidos";
$cuidadores_result = $conn->query($cuidadores_query);
$queries = [
    'familias' => "SELECT f.*, m.Nombres as Madre_Nombres, m.Apellidos as Madre_Apellidos, p.Nombres as Padre_Nombres, p.Apellidos as Padre_Apellidos, c.Nombres as Cuidador_Nombres, c.Apellidos as Cuidador_Apellidos FROM Familias f LEFT JOIN Madre m ON f.Id_madre = m.Id_madre LEFT JOIN Padre p ON f.Id_padre = p.Id_padre LEFT JOIN Cuidador c ON f.Id_cuidador = c.Id_cuidador",
    'cuidadores' => "SELECT * FROM Cuidador",
    'madres' => "SELECT * FROM Madre",
    'padres' => "SELECT * FROM Padre"
];
$results = [];
foreach ($queries as $key => $query) {
    $results[$key] = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container">
    <div class="gestion-contenedor">
        <h1>Gestión de Familias</h1>
        <button id="btn-agregar-madre" class="btn-modificar">Agregar Madre</button>
        <button id="btn-agregar-padre" class="btn-modificar">Agregar Padre</button>
        <button id="btn-agregar-cuidador" class="btn-modificar">Agregar Cuidador</button>
        <button id="btn-agregar-familia" class="btn-modificar">Agregar Familia</button>
    </div>
    <!-- Tabla Familias -->
    <div class="table-container">
        <h2>Familias Registradas</h2>
        <table class="tabla-familias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Fecha Inscripción</th>
                    <th>Tipo Usuario</th>
                    <th>Dirección</th>
                    <th>Madre</th>
                    <th>Padre</th>
                    <th>Cuidador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results['familias'])): ?>
                    <?php foreach ($results['familias'] as $familia): ?>
                        <tr>
                            <td class="center"><?php echo $familia['Id_familia']; ?></td>
                            <td><?php echo $familia['Tipo_documento'] . ': ' . htmlspecialchars($familia['Numero_documento']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Nombres']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Apellidos']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($familia['Fecha_inscripcion'])); ?></td>
                            <td><?php echo $familia['Tipo_usuario']; ?></td>
                            <td><?php echo htmlspecialchars($familia['Direccion']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Madre_Nombres'] . ' ' . $familia['Madre_Apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Padre_Nombres'] . ' ' . $familia['Padre_Apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($familia['Cuidador_Nombres'] . ' ' . $familia['Cuidador_Apellidos']); ?></td>
                            <td class="center">
                                <div class="dropdown">
                                    <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                    <div class="dropdown-menu">
                                        <a href="?modificar_familia=<?php echo $familia['Id_familia']; ?>" class="dropdown-item">Modificar</a>
                                        <a href="?eliminar_familia=<?php echo $familia['Id_familia']; ?>" class="dropdown-item btn-eliminar"
                                            onclick="return confirm('¿Está seguro de eliminar esta familia?');">Eliminar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="center">No hay familias registradas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla Madres -->
    <div class="table-container">
        <h2>Madres Registradas</h2>
        <table class="tabla-familias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Fecha Nacimiento</th>
                    <th>Lugar Nacimiento</th>
                    <th>Sexo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results['madres'])): ?>
                    <?php foreach ($results['madres'] as $madre): ?>
                        <tr>
                            <td class="center"><?php echo $madre['Id_madre']; ?></td>
                            <td><?php echo $madre['Tipo_documento'] . ': ' . htmlspecialchars($madre['Numero_documento']); ?></td>
                            <td><?php echo htmlspecialchars($madre['Nombres']); ?></td>
                            <td><?php echo htmlspecialchars($madre['Apellidos']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($madre['Fecha_nacimiento'])); ?></td>
                            <td><?php echo htmlspecialchars($madre['Lugar_nacimiento']); ?></td>
                            <td><?php echo $madre['Sexo']; ?></td>
                            <td class="center">
                                <div class="dropdown">
                                    <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                    <div class="dropdown-menu">
                                        <a href="?modificar_madre=<?php echo $madre['Id_madre']; ?>" class="dropdown-item">Modificar</a>
                                        <a href="?eliminar_madre=<?php echo $madre['Id_madre']; ?>" class="dropdown-item btn-eliminar"
                                            onclick="return confirm('¿Está seguro de eliminar este registro?');">Eliminar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="center">No hay madres registradas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Tabla Padres -->
    <div class="table-container">
        <h2>Padres Registrados</h2>
        <table class="tabla-familias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Fecha Nacimiento</th>
                    <th>Lugar Nacimiento</th>
                    <th>Sexo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results['padres'])): ?>
                    <?php foreach ($results['padres'] as $padre): ?>
                        <tr>
                            <td class="center"><?php echo $padre['Id_padre']; ?></td>
                            <td><?php echo $padre['Tipo_documento'] . ': ' . htmlspecialchars($padre['Numero_documento']); ?></td>
                            <td><?php echo htmlspecialchars($padre['Nombres']); ?></td>
                            <td><?php echo htmlspecialchars($padre['Apellidos']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($padre['Fecha_nacimiento'])); ?></td>
                            <td><?php echo htmlspecialchars($padre['Lugar_nacimiento']); ?></td>
                            <td><?php echo $padre['Sexo']; ?></td>
                            <td class="center">
                                <div class="dropdown">
                                    <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                    <div class="dropdown-menu">
                                        <a href="?modificar_padre=<?php echo $padre['Id_padre']; ?>" class="dropdown-item">Modificar</a>
                                        <a href="?eliminar_padre=<?php echo $padre['Id_padre']; ?>" class="dropdown-item btn-eliminar"
                                            onclick="return confirm('¿Está seguro de eliminar este registro?');">Eliminar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="center">No hay padres registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Tabla Cuidadores -->
    <div class="table-container">
        <h2>Cuidadores Registrados</h2>
        <table class="tabla-familias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Parentesco</th>
                    <th>Fecha Nacimiento</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results['cuidadores'])): ?>
                    <?php foreach ($results['cuidadores'] as $cuidador): ?>
                        <tr>
                            <td class="center"><?php echo $cuidador['Id_cuidador']; ?></td>
                            <td><?php echo $cuidador['Tipo_documento'] . ': ' . htmlspecialchars($cuidador['Numero_documento']); ?></td>
                            <td><?php echo htmlspecialchars($cuidador['Nombres']); ?></td>
                            <td><?php echo htmlspecialchars($cuidador['Apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($cuidador['Parentesco']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($cuidador['Fecha_nacimiento'])); ?></td>
                            <td><?php echo htmlspecialchars($cuidador['Telefono']); ?></td>
                            <td><?php echo htmlspecialchars($cuidador['Correo']); ?></td>
                            <td class="center">
                                <div class="dropdown">
                                    <ion-icon name="ellipsis-vertical-outline" class="dropdown-icon"></ion-icon>
                                    <div class="dropdown-menu">
                                        <a href="?modificar_cuidador=<?php echo $cuidador['Id_cuidador']; ?>" class="dropdown-item">Modificar</a>
                                        <a href="?eliminar_cuidador=<?php echo $cuidador['Id_cuidador']; ?>" class="dropdown-item btn-eliminar"
                                            onclick="return confirm('¿Está seguro de eliminar este registro?');">Eliminar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="center">No hay cuidadores registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


