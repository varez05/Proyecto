<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'lider') {
    header("Location: Paginaprincipal.php");
    exit();
}
?>
<?php if(isset($_GET['correo'])): ?>
    <div id="mensaje-correo-lider" style="position:fixed; top:30px; left:50%; transform:translateX(-50%); z-index:9999; min-width:280px; padding:18px 32px; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.18); font-size:1.1em; font-weight:600; display:flex; align-items:center; gap:12px; background:<?php echo $_GET['correo']==='ok' ? '#e6f9ed' : '#ffeaea'; ?>; color:<?php echo $_GET['correo']==='ok' ? '#1a7f4f' : '#b30000'; ?>; border:2px solid <?php echo $_GET['correo']==='ok' ? '#1a7f4f' : '#b30000'; ?>;">
        <?php if($_GET['correo']==='ok'): ?>
            <svg width="28" height="28" fill="#1a7f4f" viewBox="0 0 24 24"><path d="M20.285 6.709l-11.285 11.285-5.285-5.285 1.414-1.414 3.871 3.871 9.871-9.871z"/></svg>
            ¡Correo actualizado con éxito!
        <?php else: ?>
            <svg width="28" height="28" fill="#b30000" viewBox="0 0 24 24"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95 1.414-1.414z"/></svg>
            Error al actualizar el correo.
        <?php endif; ?>
    </div>
    <script>setTimeout(function(){var msg=document.getElementById('mensaje-correo-lider');if(msg)msg.style.display='none';},3500);</script>
<?php endif; ?>
<?php if(isset($_GET['telefono'])): ?>
    <div id="mensaje-telefono-lider" style="position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:9999; min-width:280px; padding:18px 32px; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.18); font-size:1.1em; font-weight:600; display:flex; align-items:center; gap:12px; background:<?php echo $_GET['telefono']==='ok' ? '#e6f9ed' : '#ffeaea'; ?>; color:<?php echo $_GET['telefono']==='ok' ? '#1a7f4f' : '#b30000'; ?>; border:2px solid <?php echo $_GET['telefono']==='ok' ? '#1a7f4f' : '#b30000'; ?>;">
        <?php if($_GET['telefono']==='ok'): ?>
            <svg width="28" height="28" fill="#1a7f4f" viewBox="0 0 24 24"><path d="M20.285 6.709l-11.285 11.285-5.285-5.285 1.414-1.414 3.871 3.871 9.871-9.871z"/></svg>
            ¡Teléfono actualizado con éxito!
        <?php else: ?>
            <svg width="28" height="28" fill="#b30000" viewBox="0 0 24 24"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95 1.414-1.414z"/></svg>
            Error al actualizar el teléfono.
        <?php endif; ?>
    </div>
    <script>setTimeout(function(){var msg=document.getElementById('mensaje-telefono-lider');if(msg)msg.style.display='none';},3500);</script>
<?php endif; ?>
<div class="perfil-admin-container" method="POST" style="max-width: 400px; margin: 40px auto; padding: 32px 24px 24px 24px; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.10); display: flex; flex-direction: column; align-items: center;">
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-top: -70px; margin-bottom: 20px;">
        <img id="foto-perfil" src="<?php echo isset($_SESSION['img']) ? '../uploads/' . $_SESSION['img'] : '../uploads/'; ?>" alt="Foto de perfil" style="width:140px; height:140px; border-radius:50%; object-fit:cover; border:4px solid #007bff; box-shadow: 0 2px 8px rgba(0,0,0,0.10); background:#f4f4f4; display:block; margin:0 auto;">
        <form id="form-foto-lider" action="../Controladores/ActualizarFotoLider.php" method="POST" enctype="multipart/form-data" style="margin-top:10px; text-align:center;">
            <input type="file" name="nueva_foto" accept="image/*" required style="margin-bottom:10px; border-radius:6px; border:1px solid #007bff; padding:4px;">
            <button type="submit" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:6px 16px; cursor:pointer; font-weight:600;">Cambiar foto</button>
        </form>
        <div id="mensaje-foto-lider"></div>
    </div>
    <div style="width:100%;">
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Tipo de documento</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['tipo_documento']) ? htmlspecialchars($_SESSION['tipo_documento']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Número de documento</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['numero_documento']) ? htmlspecialchars($_SESSION['numero_documento']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Nombres</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Apellidos</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['apellidos']) ? htmlspecialchars($_SESSION['apellidos']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Fecha de nacimiento</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['fecha_nacimiento']) ? htmlspecialchars($_SESSION['fecha_nacimiento']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Sexo</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['sexo']) ? htmlspecialchars($_SESSION['sexo']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Correo</label>
            <form action="../Controladores/ActualizarCorreoLider.php" method="POST" style="display:flex; gap:8px; align-items:center;">
                <input type="email" name="nuevo_correo" value="<?php echo isset($_SESSION['correo']) ? htmlspecialchars($_SESSION['correo']) : ''; ?>" required style="flex:1; padding:8px 10px; border-radius:8px; border:1px solid #e0e0e0; font-size:1.1em;">
                <button type="submit" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:6px 14px; cursor:pointer; font-weight:600;">Guardar</button>
            </form>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Teléfono</label>
            <form action="../Controladores/ActualizarTelefonoLider.php" method="POST" style="display:flex; gap:8px; align-items:center;">
                <input type="text" name="nuevo_telefono" value="<?php echo isset($_SESSION['telefono']) ? htmlspecialchars($_SESSION['telefono']) : ''; ?>" required style="flex:1; padding:8px 10px; border-radius:8px; border:1px solid #e0e0e0; font-size:1.1em;">
                <button type="submit" style="background:#007bff; color:#fff; border:none; border-radius:6px; padding:6px 14px; cursor:pointer; font-weight:600;">Guardar</button>
            </form>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Rol</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['rol']) ? htmlspecialchars($_SESSION['rol']) : 'No definido'; ?>
            </div>
        </div>
    </div>
</div>
<?php include '../modales/Modal_contraseña.php'; ?>
<script src="../Script/modal.js"></script>
<script>
// Interceptar el submit del formulario para actualizar la foto por AJAX y refrescar solo la imagen
const formFoto = document.getElementById('form-foto-lider');
const imgPerfil = document.getElementById('foto-perfil');
const mensajeFoto = document.getElementById('mensaje-foto-lider');
if(formFoto) {
    formFoto.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(formFoto);
        fetch('../Controladores/ActualizarFotoLider.php', {
            method: 'POST',
            body: formData
        })
        .then(res => {
            if(res.ok) {
                // Forzar recarga de la imagen sin recargar la página
                const timestamp = new Date().getTime();
                let src = imgPerfil.src.split('?')[0];
                imgPerfil.src = src + '?t=' + timestamp;
                mensajeFoto.innerHTML = '<span style="color:green; font-size:0.95em;">Foto actualizada correctamente.</span>';
            } else {
                mensajeFoto.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar la foto.</span>';
            }
        })
        .catch(() => {
            mensajeFoto.innerHTML = '<span style="color:red; font-size:0.95em;">Error al actualizar la foto.</span>';
        });
    });
}
</script>
