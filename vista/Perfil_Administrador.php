<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: Paginaprincipal.php");
    exit();
}
?>
<?php if(isset($_GET['usuario'])): ?>
    <div id="mensaje-usuario-admin" style="position:fixed; top:30px; left:50%; transform:translateX(-50%); z-index:9999; min-width:280px; padding:18px 32px; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.18); font-size:1.1em; font-weight:600; display:flex; align-items:center; gap:12px; background:<?php echo $_GET['usuario']==='ok' ? '#e6f9ed' : '#ffeaea'; ?>; color:<?php echo $_GET['usuario']==='ok' ? '#1a7f4f' : '#b30000'; ?>; border:2px solid <?php echo $_GET['usuario']==='ok' ? '#1a7f4f' : '#b30000'; ?>;">
        <?php if($_GET['usuario']==='ok'): ?>
            <svg width="28" height="28" fill="#1a7f4f" viewBox="0 0 24 24"><path d="M20.285 6.709l-11.285 11.285-5.285-5.285 1.414-1.414 3.871 3.871 9.871-9.871z"/></svg>
            ¡Usuario actualizado con éxito!
        <?php else: ?>
            <svg width="28" height="28" fill="#b30000" viewBox="0 0 24 24"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95 1.414-1.414z"/></svg>
            Error al actualizar el usuario.
        <?php endif; ?>
    </div>
    <script>setTimeout(function(){var msg=document.getElementById('mensaje-usuario-admin');if(msg)msg.style.display='none';},3500);</script>
<?php endif; ?>
<?php if(isset($_GET['correo'])): ?>
    <div id="mensaje-correo-admin" style="position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:9999; min-width:280px; padding:18px 32px; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.18); font-size:1.1em; font-weight:600; display:flex; align-items:center; gap:12px; background:<?php echo $_GET['correo']==='ok' ? '#e6f9ed' : '#ffeaea'; ?>; color:<?php echo $_GET['correo']==='ok' ? '#1a7f4f' : '#b30000'; ?>; border:2px solid <?php echo $_GET['correo']==='ok' ? '#1a7f4f' : '#b30000'; ?>;">
        <?php if($_GET['correo']==='ok'): ?>
            <svg width="28" height="28" fill="#1a7f4f" viewBox="0 0 24 24"><path d="M20.285 6.709l-11.285 11.285-5.285-5.285 1.414-1.414 3.871 3.871 9.871-9.871z"/></svg>
            ¡Correo actualizado con éxito!
        <?php else: ?>
            <svg width="28" height="28" fill="#b30000" viewBox="0 0 24 24"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95 1.414-1.414z"/></svg>
            Error al actualizar el correo.
        <?php endif; ?>
    </div>
    <script>setTimeout(function(){var msg=document.getElementById('mensaje-correo-admin');if(msg)msg.style.display='none';},3500);</script>
<?php endif; ?>
<?php if(isset($_GET['telefono'])): ?>
    <div id="mensaje-telefono-admin" style="position:fixed; top:130px; left:50%; transform:translateX(-50%); z-index:9999; min-width:280px; padding:18px 32px; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.18); font-size:1.1em; font-weight:600; display:flex; align-items:center; gap:12px; background:<?php echo $_GET['telefono']==='ok' ? '#e6f9ed' : '#ffeaea'; ?>; color:<?php echo $_GET['telefono']==='ok' ? '#1a7f4f' : '#b30000'; ?>; border:2px solid <?php echo $_GET['telefono']==='ok' ? '#1a7f4f' : '#b30000'; ?>;">
        <?php if($_GET['telefono']==='ok'): ?>
            <svg width="28" height="28" fill="#1a7f4f" viewBox="0 0 24 24"><path d="M20.285 6.709l-11.285 11.285-5.285-5.285 1.414-1.414 3.871 3.871 9.871-9.871z"/></svg>
            ¡Teléfono actualizado con éxito!
        <?php else: ?>
            <svg width="28" height="28" fill="#b30000" viewBox="0 0 24 24"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95 1.414-1.414z"/></svg>
            Error al actualizar el teléfono.
        <?php endif; ?>
    </div>
    <script>setTimeout(function(){var msg=document.getElementById('mensaje-telefono-admin');if(msg)msg.style.display='none';},3500);</script>
<?php endif; ?>
<div class="perfil-admin-container" method="POST" style="max-width: 400px; margin: 40px auto; padding: 32px 24px 24px 24px; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.10); display: flex; flex-direction: column; align-items: center;">
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: -70px; margin-bottom: 20px;">
        <img id="foto-perfil-admin" src="<?php echo isset($_SESSION['img']) ? '../imagen/' . $_SESSION['img'] : '../imagen/Fondo1.jpg'; ?>" alt="Foto de perfil" style="width:140px; height:140px; border-radius:50%; object-fit:cover; border:4px solid #007bff; box-shadow: 0 2px 8px rgba(0,0,0,0.10); background:#f4f4f4; display:block; margin:0 auto;">
        <form id="form-foto-admin" action="../Controladores/ActualizarFotoAdministrador.php" method="POST" enctype="multipart/form-data" style="margin-top:10px; text-align:center;">
            <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <input type="file" name="nueva_foto" accept="image/*" required style="margin-bottom:10px; border-radius:6px; border:1px solid #007bff; padding:4px;">
            <button type="submit" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:6px 16px; cursor:pointer; font-weight:600;">Cambiar foto</button>
        </form>
        <div id="mensaje-foto-admin"></div>
    </div>
    <div style="width:100%;">
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Nombre</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Usuario</label>
            <form id="form-usuario-admin" action="../Controladores/ActualizarUsuarioAdministrador.php" method="POST" style="display:flex; gap:8px; align-items:center;">
                <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                <input id="input-usuario-admin" type="text" name="nuevo_usuario" value="<?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : ''; ?>" required style="flex:1; padding:8px 10px; border-radius:8px; border:1px solid #e0e0e0; font-size:1.1em;">
                <button type="submit" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:6px 14px; cursor:pointer; font-weight:600;">Guardar</button>
            </form>
            <div id="mensaje-ajax-usuario-admin"></div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Correo</label>
            <form id="form-correo-admin" action="../Controladores/ActualizarCorreoAdministrador.php" method="POST" style="display:flex; gap:8px; align-items:center;">
                <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                <input id="input-correo-admin" type="email" name="nuevo_correo" value="<?php echo isset($_SESSION['correo']) ? htmlspecialchars($_SESSION['correo']) : ''; ?>" required style="flex:1; padding:8px 10px; border-radius:8px; border:1px solid #e0e0e0; font-size:1.1em;">
                <button type="submit" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:6px 14px; cursor:pointer; font-weight:600;">Guardar</button>
            </form>
            <div id="mensaje-ajax-correo-admin"></div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Teléfono</label>
            <form id="form-telefono-admin" action="../Controladores/ActualizarTelefonoAdministrador.php" method="POST" style="display:flex; gap:8px; align-items:center;">
                <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                <input id="input-telefono-admin" type="text" name="nuevo_telefono" value="<?php echo isset($_SESSION['telefono']) ? htmlspecialchars($_SESSION['telefono']) : ''; ?>" required style="flex:1; padding:8px 10px; border-radius:8px; border:1px solid #e0e0e0; font-size:1.1em;">
                <button type="submit" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:6px 14px; cursor:pointer; font-weight:600;">Guardar</button>
            </form>
            <div id="mensaje-ajax-telefono-admin"></div>
        </div>
        <div style="text-align:right; margin-top: 18px;">
            <button type="button" id="btn-abrir-modal-contra" style="font-size: 0.95em; color: #007bff; background: #f7f9fa; border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 14px; cursor:pointer;" onclick="btnAbrirModal('modal-cambiar-contra')">Cambiar contraseña</button>
        </div>
    </div>
</div>
<?php include '../modales/Modal_contraseña.php'; ?>
<script src="../Script/modal.js"></script>
<script>
// Interceptar el submit del formulario para actualizar la foto por AJAX y refrescar solo la imagen
const formFotoAdmin = document.getElementById('form-foto-admin');
const imgPerfilAdmin = document.getElementById('foto-perfil-admin');
const mensajeFotoAdmin = document.getElementById('mensaje-foto-admin');
const formCorreoAdmin = document.getElementById('form-correo-admin');
const inputCorreoAdmin = document.getElementById('input-correo-admin');
const mensajeAjaxCorreo = document.getElementById('mensaje-ajax-correo-admin');
const formUsuarioAdmin = document.getElementById('form-usuario-admin');
const inputUsuarioAdmin = document.getElementById('input-usuario-admin');
const mensajeAjaxUsuario = document.getElementById('mensaje-ajax-usuario-admin');
const formTelefonoAdmin = document.getElementById('form-telefono-admin');
const inputTelefonoAdmin = document.getElementById('input-telefono-admin');
const mensajeAjaxTelefono = document.getElementById('mensaje-ajax-telefono-admin');

if(formFotoAdmin) {
    formFotoAdmin.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formFotoAdmin);
        fetch('../Controladores/ActualizarFotoAdministrador.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => {
            if(res.ok) {
                // Si la respuesta es JSON, mostrar mensaje AJAX
                res.json().then(data => {
                    if(data && data.success) {
                        // Actualizar la imagen en la tabla del sidebar si existe
                        if (window.parent && window.parent.document) {
                            const sidebarImg = window.parent.document.querySelector('.usuario img');
                            if (sidebarImg) {
                                const timestamp = new Date().getTime();
                                let src = imgPerfilAdmin.src.split('?')[0];
                                sidebarImg.src = src + '?t=' + timestamp;
                            }
                        }
                        // Actualizar la imagen en el perfil
                        const timestamp = new Date().getTime();
                        let src = imgPerfilAdmin.src.split('?')[0];
                        imgPerfilAdmin.src = src + '?t=' + timestamp;
                        mensajeFotoAdmin.innerHTML = '<span style="color:green; font-size:0.95em;">Foto actualizada correctamente.</span>';
                    } else {
                        mensajeFotoAdmin.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar la foto.</span>';
                    }
                    setTimeout(() => { mensajeFotoAdmin.innerHTML = ''; }, 3500);
                }).catch(() => {
                    // Si no es JSON, recargar la imagen como antes
                    const timestamp = new Date().getTime();
                    let src = imgPerfilAdmin.src.split('?')[0];
                    imgPerfilAdmin.src = src + '?t=' + timestamp;
                    mensajeFotoAdmin.innerHTML = '<span style="color:green; font-size:0.95em;">Foto actualizada correctamente.</span>';
                    setTimeout(() => { mensajeFotoAdmin.innerHTML = ''; }, 3500);
                });
            } else {
                mensajeFotoAdmin.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar la foto.</span>';
                setTimeout(() => { mensajeFotoAdmin.innerHTML = ''; }, 3500);
            }
        })
        .catch(() => {
            mensajeFotoAdmin.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar la foto.</span>';
            setTimeout(() => { mensajeFotoAdmin.innerHTML = ''; }, 3500);
        });
    });
}

if(formCorreoAdmin) {
    formCorreoAdmin.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formCorreoAdmin);
        fetch('../Controladores/ActualizarCorreoAdministrador.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                mensajeAjaxCorreo.innerHTML = '<span style="color:green; font-size:0.95em;">¡Correo actualizado con éxito!</span>';
                setTimeout(() => { mensajeAjaxCorreo.innerHTML = ''; }, 3500);
                // Actualizar el valor del input y la sesión visualmente
                inputCorreoAdmin.value = data.correo;
                // Actualizar correo en la tabla del sidebar si existe
                if (window.parent && window.parent.document) {
                    const sidebarEmail = window.parent.document.querySelector('.usuario .email');
                    if (sidebarEmail) {
                        sidebarEmail.textContent = data.correo;
                    }
                }
            } else {
                mensajeAjaxCorreo.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar el correo.</span>';
                setTimeout(() => { mensajeAjaxCorreo.innerHTML = ''; }, 3500);
            }
        })
        .catch(() => {
            mensajeAjaxCorreo.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar el correo.</span>';
            setTimeout(() => { mensajeAjaxCorreo.innerHTML = ''; }, 3500);
        });
    });
}

if(formUsuarioAdmin) {
    formUsuarioAdmin.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formUsuarioAdmin);
        fetch('../Controladores/ActualizarUsuarioAdministrador.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                mensajeAjaxUsuario.innerHTML = '<span style="color:green; font-size:0.95em;">¡Usuario actualizado con éxito!</span>';
                setTimeout(() => { mensajeAjaxUsuario.innerHTML = ''; }, 3500);
                inputUsuarioAdmin.value = data.usuario;
                // Actualizar usuario en la tabla del sidebar si existe
                if (window.parent && window.parent.document) {
                    const sidebarNombre = window.parent.document.querySelector('.usuario .nombre');
                    if (sidebarNombre) {
                        sidebarNombre.textContent = data.usuario;
                    }
                }
            } else {
                mensajeAjaxUsuario.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar el usuario.</span>';
                setTimeout(() => { mensajeAjaxUsuario.innerHTML = ''; }, 3500);
            }
        })
        .catch(() => {
            mensajeAjaxUsuario.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar el usuario.</span>';
            setTimeout(() => { mensajeAjaxUsuario.innerHTML = ''; }, 3500);
        });
    });
}

if(formTelefonoAdmin) {
    formTelefonoAdmin.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formTelefonoAdmin);
        fetch('../Controladores/ActualizarTelefonoAdministrador.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                mensajeAjaxTelefono.innerHTML = '<span style="color:green; font-size:0.95em;">¡Teléfono actualizado con éxito!</span>';
                setTimeout(() => { mensajeAjaxTelefono.innerHTML = ''; }, 3500);
                inputTelefonoAdmin.value = data.telefono;
                // Actualizar teléfono en la tabla del sidebar si existe
                if (window.parent && window.parent.document) {
                    const sidebarTelefono = window.parent.document.querySelector('.usuario .telefono');
                    if (sidebarTelefono) {
                        sidebarTelefono.textContent = data.telefono;
                    }
                }
            } else {
                mensajeAjaxTelefono.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar el teléfono.</span>';
                setTimeout(() => { mensajeAjaxTelefono.innerHTML = ''; }, 3500);
            }
        })
        .catch(() => {
            mensajeAjaxTelefono.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar el teléfono.</span>';
            setTimeout(() => { mensajeAjaxTelefono.innerHTML = ''; }, 3500);
        });
    });
}

document.getElementById('form-cambiar-contra').addEventListener('submit', function(e) {
  e.preventDefault();
  var form = e.target;
  var datos = new FormData(form);
  fetch('../Controladores/CambiarContrasena.php', {
    method: 'POST',
    body: datos
  })
  .then(response => response.text())
  .then(mensaje => {
    document.getElementById('mensaje-contra').textContent = mensaje;
    if (mensaje.includes('correctamente')) {
      form.reset();
      setTimeout(() => cerrarModal('modal-cambiar-contra'), 1500);
    }
  })
  .catch(() => {
    document.getElementById('mensaje-contra').textContent = 'Error de conexión.';
  });
});
</script>