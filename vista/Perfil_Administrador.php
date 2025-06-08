<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: Paginaprincipal.php");
    exit();
}
?>
<div class="perfil-admin-container" style="max-width: 400px; margin: 40px auto; padding: 32px 24px 24px 24px; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.10); display: flex; flex-direction: column; align-items: center;">
    <div style="margin-top: -70px; margin-bottom: 20px;">
        <img src="<?php echo isset($_SESSION['img']) ? '../imagen/' . $_SESSION['img'] : '../imagen/Fondo1.jpg'; ?>" alt="Foto de perfil" style="width:140px; height:140px; border-radius:50%; object-fit:cover; border:4px solid #007bff; box-shadow: 0 2px 8px rgba(0,0,0,0.10); background:#f4f4f4;">
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
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Correo</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['correo']) ? htmlspecialchars($_SESSION['correo']) : 'No definido'; ?>
            </div>
        </div>
        <div style="margin-bottom: 18px;">
            <label style="font-weight:600; color:#555;">Teléfono</label>
            <div style="padding:10px 14px; border-radius:8px; background:#f7f9fa; border:1px solid #e0e0e0; color:#222; font-size:1.1em;">
                <?php echo isset($_SESSION['telefono']) ? htmlspecialchars($_SESSION['telefono']) : 'No definido'; ?>
            </div>
        </div>
        <div style="text-align:right; margin-top: 18px;">
            <button type="button" id="btn-abrir-modal-contra" style="font-size: 0.95em; color: #007bff; background: #f7f9fa; border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 14px; cursor:pointer;">Cambiar contraseña</button>
        </div>
    </div>
</div>
<!-- Modal Cambiar Contraseña -->
<div id="modal-cambiar-contra" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); justify-content:center; align-items:center;">
  <div style="background:#fff; border-radius:12px; max-width:350px; width:90vw; margin:auto; padding:28px 20px 20px 20px; position:relative; box-shadow:0 2px 16px rgba(0,0,0,0.15);">
    <button id="cerrar-modal-contra" style="position:absolute; top:10px; right:14px; background:none; border:none; font-size:1.5em; color:#888; cursor:pointer;">&times;</button>
    <h3 style="text-align:center; margin-bottom:18px;">Cambiar Contraseña</h3>
    <form id="form-cambiar-contra">
      <div style="margin-bottom:14px;">
        <label>Contraseña actual</label>
        <input type="password" name="actual" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
      </div>
      <div style="margin-bottom:14px;">
        <label>Nueva contraseña</label>
        <input type="password" name="nueva" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
      </div>
      <div style="margin-bottom:14px;">
        <label>Confirmar nueva contraseña</label>
        <input type="password" name="confirmar" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
      </div>
      <div id="mensaje-contra" style="color:red; text-align:center; margin-bottom:10px;"></div>
      <button type="submit" class="boton" style="width:100%;">Guardar</button>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const btnAbrir = document.getElementById('btn-abrir-modal-contra');
  const modal = document.getElementById('modal-cambiar-contra');
  const btnCerrar = document.getElementById('cerrar-modal-contra');
  if(btnAbrir && modal && btnCerrar) {
    btnAbrir.onclick = () => { modal.style.display = 'flex'; };
    btnCerrar.onclick = () => { modal.style.display = 'none'; document.getElementById('mensaje-contra').textContent = ''; };
    window.onclick = (e) => { if(e.target === modal) { modal.style.display = 'none'; document.getElementById('mensaje-contra').textContent = ''; } };
    // Enviar formulario por AJAX
    const form = document.getElementById('form-cambiar-contra');
    form.onsubmit = async function(e) {
      e.preventDefault();
      const datos = new FormData(form);
      const resp = await fetch('../Controladores/CambiarContrasena.php', {
        method: 'POST',
        body: datos
      });
      const texto = await resp.text();
      document.getElementById('mensaje-contra').textContent = texto;
      if(texto.includes('correctamente')) {
        setTimeout(()=>{ modal.style.display = 'none'; form.reset(); document.getElementById('mensaje-contra').textContent = ''; }, 1500);
      }
    };
  }
});
</script>