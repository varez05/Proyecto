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

<script>
    function toggleForm(esEditar = false) {
        const formModal = document.getElementById('formModal');
        formModal.style.display = formModal.style.display === 'flex' ? 'none' : 'flex';

        if (!esEditar) {
            // Si no es editar, resetear el formulario
            document.getElementById('formularioComunidad').reset();
            document.getElementById('tituloFormulario').textContent = 'Registrar Nueva Comunidad';
            document.getElementById('accion').value = 'agregar';
            document.getElementById('id_comunidad').value = '';
        }
    }

    // Mostrar/ocultar menú desplegable
    function toggleDropdown(id) {
        document.querySelectorAll('.dropdown-content').forEach(function(menu) {
            if (menu.id !== 'menu-' + id) {
                menu.classList.remove('show');
            }
        });
        document.getElementById('menu-' + id).classList.toggle('show');
    }

    // Cerrar los menús al hacer clic fuera de ellos
    window.onclick = function(event) {
        if (!event.target.matches('.menu-icon')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
<script>
    // Ocultar el mensaje después de 5 segundos
    setTimeout(function() {
        const mensaje = document.getElementById('mensaje');
        if (mensaje) {
            mensaje.style.transition = 'opacity 0.5s ease';
            mensaje.style.opacity = '0';
            setTimeout(() => mensaje.style.display = 'none', 500); // Ocultar completamente después de la transición
        }
    }, 5000);
</script>

<div class="container">
    <div class="header-section">
        <h1>Gestión de Comunidades</h1>
        <button onclick="toggleForm()">Nueva Comunidad</button>
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
                                    <a href="?editar=<?php echo $row['Id_comunidad']; ?>" class="dropdown-item">Modificar</a>
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