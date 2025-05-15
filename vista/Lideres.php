<?php
require_once '../Controladores/LideresController.php';

$conn = conectarBaseDatos();


// Listar todos los líderes
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
