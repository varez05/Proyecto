<!-- Modal Cambiar Contraseña -->
<div id="modal-cambiar-contra" class="modal">
  <div class="modal-content" style="background:#fff; border-radius:12px; max-width:350px; width:90vw; margin:auto; padding:28px 20px 20px 20px; position:relative; box-shadow:0 2px 16px rgba(0,0,0,0.15);">
    <button id="cerrar-modal-contra" type="button" onclick="cerrarModal('modal-cambiar-contra')" style="position:absolute; top:10px; right:14px; background:none; border:none; font-size:1.5em; color:#888; cursor:pointer;">&times;</button>
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