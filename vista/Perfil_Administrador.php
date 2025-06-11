<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: Paginaprincipal.php");
    exit();
}
?>
<div class="perfil-admin-container"  method="POST" style="max-width: 400px; margin: 40px auto; padding: 32px 24px 24px 24px; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.10); display: flex; flex-direction: column; align-items: center;">
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
            <button type="button" id="btn-abrir-modal-contra" style="font-size: 0.95em; color: #007bff; background: #f7f9fa; border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 14px; cursor:pointer;" onclick="btnAbrirModal('modal-cambiar-contra')">Cambiar contraseña</button>
        </div>
    </div>
</div>
<?php include '../modales/Modal_contraseña.php'; ?>
<script src="../Script/modal.js"></script>
<script>
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