<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../vista/Paginaprincipal.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>

    <link rel="stylesheet" href="../Css/Sidebar.css">
    <link rel="stylesheet" href="../Css/alerta.css">
    <link rel="stylesheet" href="../Css/buttons.css">
    <link rel="stylesheet" href="../Css/Formularios.CSS">
    <link rel="stylesheet" href="../Css/headers.css">
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/menusdespegables.css">
    <link rel="stylesheet" href="../Css/notifications.css">
    <link rel="stylesheet" href="../Css/tables.css">
    <link rel="stylesheet" href="../Css/modal.css">

    <!-- <link rel="stylesheet" href="../Css/Comunidades.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src=" ../Script/Script1.js " defer></script>
</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-circle-outline"></ion-icon>
    </div>
    <Div class="barra-lateral ">
        <div>
            <Div class="nombre-pagina">
                <ion-icon id="cloud" name="albums-outline"></ion-icon>
                <Span>Koutuushi Wapushua</Span>
            </Div>
            <button class="boton" onclick="mostrarSeccion(event, 'contenido-perfil', '../vista/Perfil_Administrador.php')">
                <ion-icon name="create-outline"></ion-icon>
                <span> Perfil Administrador </span>
            </button>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a href="#" onclick="mostrarSeccion(event, 'contenido-unidades', '../vista/Unidades.php')">
                        <ion-icon name="accessibility-outline"></ion-icon>
                        <span>Unidades</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="mostrarSeccion(event, 'contenido-comunidades', '../vista/Comunidades.php')">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Comunidades</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="mostrarSeccion(event, 'contenido-familias', '../vista/Familias.php')">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span>Familias</span>
                    </a>
                </li>
                  <li>
    <a href="#" onclick="mostrarSeccion(event, 'contenido-administradores', '../vista/Administrador.php')">
        <ion-icon name="person-add-outline"></ion-icon>
        <span>Administradores</span>
    </a>
</li>
                <li>
                    <a href="#" onclick="mostrarSeccion(event, 'contenido-lideres', '../vista/Lideres.php')">
                        <ion-icon name="people-outline"></ion-icon>
                        <span>Líderes</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="mostrarSeccion(event, 'contenido-reportes', '../vista/Reportes.php')">
                        <ion-icon name="document-text-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div>
           

            <div class="usuario">
                <img src="<?php echo isset($_SESSION['img']) ? '../imagen/' . $_SESSION['img'] : '../imagen/Fondo1.jpg'; ?>" alt="">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">
                            <?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario'; ?>
                        </span>
                        <span class="email">
                            <?php echo isset($_SESSION['correo']) ? $_SESSION['correo'] : 'correo@ejemplo.com'; ?>
                        </span>
                    </div>
                    <a href="../Controladores/Cerrarsesion.php" title="Cerrar sesión">
                        <ion-icon name="log-out-outline" style="font-size: 22px; color: red;"></ion-icon>
                    </a>
                </div>
            </div>

        </div>
    </Div>
    <main>
        <div id="contenido-unidades" style="display: none; margin-top: 20px;"></div>
        <div id="contenido-lideres" style="display: none; margin-top: 20px;"></div>
        <div id="contenido-comunidades" style="display: none; margin-top: 20px;"></div>
        <div id="contenido-familias" style="display: none; margin-top: 20px;"></div>
        <div id="contenido-administradores" style="display: none; margin-top: 20px;"></div>
        <div id="contenido-reportes" style="display: none; margin-top: 20px;"></div>
        <div id="contenido-perfil" style="display: none; margin-top: 20px;"></div>
    </main>

   <!-- MODALES -->
        <?php
            include '../modales/ModalUnidades.html';  // crear y editar
            include '../modales/ModalLider.html';  // crear y editar
            include '../modales/ModalComunidades.php';
            include '../modales/ModalFamilias.php';
            include '../modales/ModalAdministrador.html';
            include '../modales/Modal_contraseña.php';
        ?>
   <!--  -->

   <script src="../Script/unidades.js"></script>
   <script src="../Script/modal.js"></script>
   <script src="../Script/comunidades.js"></script>
   <script src="../Script/familias.js"></script>
   <script src="../Script/lideres.js"></script>
   
   
   <script>

        async function mostrarSeccion(event, id, url) {
            event.preventDefault(); // Evita la redirección

            // Actualizar la URL con el parámetro de la sección seleccionada
            const params = new URLSearchParams(window.location.search);
            params.set('seccion', id);
            window.history.replaceState({}, '', `${window.location.pathname}?${params.toString()}`);

            // Oculta todas las secciones
            const secciones = [
                'contenido-unidades',
                'contenido-lideres',
                'contenido-comunidades',
                'contenido-familias',
                'contenido-administradores',
                'contenido-reportes',
                'contenido-perfil'
            ];
            secciones.forEach(seccion => {
                document.getElementById(seccion).style.display = 'none';
            });

            // Muestra solo la sección solicitada
            const contenido = document.getElementById(id);
            contenido.style.display = 'block';

            // Carga el contenido dinámicamente
            try {
                const response = await fetch(url);
                if (response.ok) {
                    const html = await response.text();
                    contenido.innerHTML = html;
                } else {
                    contenido.innerHTML = '<p>Error al cargar el contenido.</p>';
                }
            } catch (error) {
                contenido.innerHTML = '<p>Error al cargar el contenido.</p>';
            }
        }

        // Cargar la sección seleccionada al recargar la página
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const seccion = params.get('seccion');
            if (seccion) {
                const enlace = document.querySelector(`a[onclick*="${seccion}"]`);
                if (enlace) {
                    enlace.click();
                }
            }
        });
    </script>
</body>

</html>