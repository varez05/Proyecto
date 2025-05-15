<?php
require_once '../Controladores/LideresController.php';

$conn = conectarBaseDatos();

// 1. Eliminar líder
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    eliminarLider($conn, $id);
}

// 2. Modificar líder existente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_lider'])) {
    modificarLider($conn, $_POST, $_FILES);
}

// 3. Agregar nuevo líder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['id_lider'])) {
    agregarLider($conn, $_POST, $_FILES);
}

// 4. Consultar líder para modificar
$lider = null;
if (isset($_GET['modificar'])) {
    $id = intval($_GET['modificar']);
    $lider = consultarLider($conn, $id);
}

// 5. Listar todos los líderes
$result = listarLideres($conn);
?>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="notification <?php echo $_SESSION['mensaje']['tipo']; ?>" id="notification">
            <?php 
                echo $_SESSION['mensaje']['texto']; 
                unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
            ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <!-- Modal para agregar líder -->
    <div id="modal-agregar" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="btn-cerrar-modal" class="close">&times;</span>
            <h2>Agregar Líder</h2>
            <form action="Lideres.php" method="POST" class="form-modificar" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="tipo_documento">Tipo de Documento:</label>
                    <select id="tipo_documento" name="tipo_documento" required>
                        <option value="Cédula">Cédula</option>
                        <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                        <option value="Pasaporte">Pasaporte</option>
                        <option value="Cédula Extranjería">Cédula Extranjería</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero_documento">Número de Documento:</label>
                    <input type="text" id="numero_documento" name="numero_documento" required>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo" required>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono">
                </div>
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select id="rol" name="rol" required>
                        <option value="Pedagógico">Pedagógico</option>
                        <option value="Comunitario">Comunitario</option>
                        <option value="Técnico">Técnico</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="img">Imagen (opcional):</label>
                    <input type="file" id="img" name="img" accept="image/*">
                </div>
                <div class="form-buttons">
                    <button type="submit">Guardar</button>
                    <button type="button" id="btn-cancelar-modal" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para modificar líder -->
    <?php if ($lider): ?>
        <div id="modal-modificar" class="modal" style="display: none;">
            <div class="modal-content">
                <span id="btn-cerrar-modal-modificar" class="close">&times;</span>
                <h2>Modificar Líder</h2>
                <form action="Lideres.php" method="POST" class="form-modificar" enctype="multipart/form-data">
                    <input type="hidden" name="id_lider" value="<?php echo $lider['Id_lider']; ?>">
                    
                    <div class="form-group">
                        <label for="tipo_documento">Tipo de Documento:</label>
                        <select id="tipo_documento" name="tipo_documento" required>
                            <option value="Cédula" <?php echo ($lider['Tipo_documento'] == 'Cédula') ? 'selected' : ''; ?>>Cédula</option>
                            <option value="Tarjeta de Identidad" <?php echo ($lider['Tipo_documento'] == 'Tarjeta de Identidad') ? 'selected' : ''; ?>>Tarjeta de Identidad</option>
                            <option value="Pasaporte" <?php echo ($lider['Tipo_documento'] == 'Pasaporte') ? 'selected' : ''; ?>>Pasaporte</option>
                            <option value="Cédula Extranjería" <?php echo ($lider['Tipo_documento'] == 'Cédula Extranjería') ? 'selected' : ''; ?>>Cédula Extranjería</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="numero_documento">Número de Documento:</label>
                        <input type="text" id="numero_documento" name="numero_documento" value="<?php echo htmlspecialchars($lider['Numero_documento']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($lider['Nombres']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($lider['Apellidos']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $lider['Fecha_nacimiento']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo" required>
                            <option value="Masculino" <?php echo ($lider['Sexo'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Femenino" <?php echo ($lider['Sexo'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="correo">Correo Electrónico:</label>
                        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($lider['Correo']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($lider['Telefono']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="rol">Rol:</label>
                        <select id="rol" name="rol" required>
                            <option value="Pedagógico" <?php echo ($lider['Rol'] == 'Pedagógico') ? 'selected' : ''; ?>>Pedagógico</option>
                            <option value="Comunitario" <?php echo ($lider['Rol'] == 'Comunitario') ? 'selected' : ''; ?>>Comunitario</option>
                            <option value="Técnico" <?php echo ($lider['Rol'] == 'Técnico') ? 'selected' : ''; ?>>Técnico</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <?php if (!empty($lider['Img'])): ?>
                            <label>Imagen Actual:</label>
                            <img src="../uploads/<?php echo htmlspecialchars($lider['Img']); ?>" alt="Imagen actual" class="current-img">
                        <?php endif; ?>
                        <label for="img">Nueva Imagen (opcional):</label>
                        <input type="file" id="img" name="img" accept="image/*">
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit">Guardar Cambios</button>
                        <button type="button" id="btn-cancelar-modal-modificar" class="btn-cancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
             <div class="header-container">
             <h1>Gestión de Líderes</h1>
             <button id="btn-agregar" class="btn-modificar">Agregar Líder</button>
             </div>
    <!-- Contenido principal -->
    <div class="container">
        <!-- Contenedor para mensajes -->
        <div id="mensaje" class="mensaje" style="display: none;"></div>

        <!-- Tabla de líderes -->
        <h2>Lista de Líderes</h2>
        <table class="tabla-lideres">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Fecha Nac.</th>
                    <th>Sexo</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="center"><?php echo $row['Id_lider']; ?></td>
                            <td><?php echo $row['Tipo_documento'] . ': ' . htmlspecialchars($row['Numero_documento']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nombres']); ?></td>
                            <td><?php echo htmlspecialchars($row['Apellidos']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['Fecha_nacimiento'])); ?></td>
                            <td><?php echo $row['Sexo']; ?></td>
                            <td><?php echo htmlspecialchars($row['Correo']); ?></td>
                            <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
                            <td><?php echo $row['Rol']; ?></td>
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
                                        <a href="Lideres.php?modificar=<?php echo $row['Id_lider']; ?>" class="dropdown-item">Modificar</a>
                                        <a href="Lideres.php?eliminar=<?php echo $row['Id_lider']; ?>" class="dropdown-item btn-eliminar" 
                                           onclick="return confirm('¿Está seguro de eliminar este líder?');">Eliminar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="center">No hay líderes registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalAgregar = document.getElementById('modal-agregar');
        const modalModificar = document.getElementById('modal-modificar');
        const btnAbrirModalAgregar = document.getElementById('btn-agregar');
        const btnCerrarModalAgregar = document.getElementById('btn-cerrar-modal');
        const btnCancelarModalAgregar = document.getElementById('btn-cancelar-modal');
        const btnCerrarModalModificar = document.getElementById('btn-cerrar-modal-modificar');
        const btnCancelarModalModificar = document.getElementById('btn-cancelar-modal-modificar');

        // Mostrar el modal de agregar
        btnAbrirModalAgregar.addEventListener('click', function () {
            modalAgregar.style.display = 'flex';
        });

        // Ocultar el modal de agregar
        btnCerrarModalAgregar.addEventListener('click', function () {
            modalAgregar.style.display = 'none';
        });
        btnCancelarModalAgregar.addEventListener('click', function () {
            modalAgregar.style.display = 'none';
        });

        // Mostrar el modal de modificar si existe
        if (modalModificar) {
            modalModificar.style.display = 'flex';
        }

        // Ocultar el modal de modificar
        btnCerrarModalModificar.addEventListener('click', function () {
            modalModificar.style.display = 'none';
        });
        btnCancelarModalModificar.addEventListener('click', function () {
            modalModificar.style.display = 'none';
        });

        // Ocultar los modales al hacer clic fuera del contenido
        window.addEventListener('click', function (event) {
            if (event.target === modalAgregar) {
                modalAgregar.style.display = 'none';
            }
            if (event.target === modalModificar) {
                modalModificar.style.display = 'none';
            }
        });

        const mensaje = document.getElementById('mensaje');
        if (mensaje) {
            setTimeout(() => {
                mensaje.style.display = 'none';
            }, 5000); // 5 segundos
        }
    });
    </script>
    <script src="../Script/lideres.js"></script>
</body>
</html>
