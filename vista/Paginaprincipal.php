
<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="../Css/Paginaprincipal.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
    <header class="header">
        <nav class="nav">
            <a href="Paginaprincipal.php" class="nav_logo">Koutuushi Wapushua</a>
            <div class="nav_menu">
                <ul class="menuitem">
                    <li class="menuitem"><a href="#" class="nav_link">Inicio</a></li>
                    <li class="menuitem"><a href="#" class="nav_link">Sobre Nosotros</a></li>
                    <li class="menuitem"><a href="#" class="nav_link">Contacto</a></li>
                </ul>
            </div>
            <div class="nav_buttons">
                <button class="boton" id="Consultar_boton">Consultar</button>
                <button class="boton" id="Abrir_boton">Ingresar</button>
            </div>
        </nav>
    </header>
    <section class="home">
        <div class="Container">
            <i class="uil uil-times form_close"></i>
            <div class="Forma">
                <form action="../Controladores/Ingresar_Administrador.php" method="post">
                    <h2>Ingresar</h2>

                      <?php 
                      if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                      <div style="color: red; text-align: center; margin-bottom: 10px;">
                      ❌ Usuario o contraseña incorrectos.
                      </div>
                      <script>
                               const  home = document.querySelector(".home")
                               window.addEventListener("DOMContentLoaded", () => {
                               const urlParams = new URLSearchParams(window.location.search);
                               if (urlParams.has('error')) {
                                home.classList.add("Show"); }});
                      </script> 
                      <?php endif; ?>

                    <div class="input_box">
                        <input id="usuario" name="usuario" type="text" placeholder="Ingrese su usuario" required>
                        <i class="uil uil-user-circle email"></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="passwordField" placeholder="Ingrese su Contraseña" required id="passwordField">
                        <i class="uil uil-lock password"></i>
                        <i class="uil uil-eye-slash pw_hide" id="togglePassword"></i>
                    </div>
                    <button type="submit" name="Botoningresar" class="buton" id="Entrar_boton">Entrar</button>
                </form>
            </div>
        </div>

        <div class="ContainerConsulta">
            <i class="uil uil-times Consultar_close"></i>
            <div class="Forma">
                <form action="#">
                    <h2>Consultar</h2>
                    <div class="input_box Consultar">
                        <select id="tipoDocumento" required>
                            <option value="" disabled selected>Seleccione tipo de documento</option>
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="RC">Registro Civil</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="PT">Permiso de Proteccion</option>
                        </select>
                        <i class="uil uil-document-info document-type"></i>
                    </div>
                    <div class="input_box Consultar">
                        <input type="text" placeholder="Ingrese número de documento" required id="numeroDocumento">
                        <i class="uil uil-document document-number"></i>
                    </div>
                    <button class="buto" id="Realizar_consulta">Consultar</button>
                </form>
            </div>
        </div>
    </section>
<script src="../Script/script.js"> </script> 
</body>
</html>
