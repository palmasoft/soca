<form id="frm-datosusuario" class="form-horizontal" onsubmit="return false;">
  <div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Nombre de Usuario</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="<?php echo Usuario::nombreUsuario() ?>" required=""
             id="nombreUsuario" name="nombreUsuario" placeholder="">
    </div>
  </div>
  <div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Clave</label>
    <div class="col-sm-4">
      <input type="password" class="form-control" id="claveUsuario" name="claveUsuario" >
    </div>
    <label for="inputName" class="col-sm-2 control-label">Repitela</label>
    <div class="col-sm-4">
      <input type="password" class="form-control"  id="clave2Usuario" name="clave2Usuario" >
    </div>
  </div>

  <!--  <hr />
    <div class="form-group">
      <label for="inputEmail" class="col-sm-2 control-label">Correo</label>
      <div class="col-sm-10">
        <input type="email" class="form-control"  value="<?php echo Usuario::correoUsuario() ?>"
               id="correoContacto" name="correoContacto" placeholder="">
      </div>
    </div>
    <div class="form-group">
      <label for="inputName" class="col-sm-2 control-label">Télefono</label>
      <div class="col-sm-10">
        <input type="text" class="form-control"  value="<?php echo Usuario::telefonoUsuario() ?>"
               id="telefonoUsuario" name="telefonoUsuario" placeholder="Name">
      </div>
    </div>
    <div class="form-group">
      <label for="inputExperience" class="col-sm-2 control-label">Formacíon</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="formacionUsuario"  name="formacionUsuario" rows="7"
                  placeholder="escriba su experiencia y formación académica"><?php echo Usuario::formacionEmpleado() ?></textarea>
      </div>
    </div>-->

  <hr />
  <div class="form-group" title="Imagen de Usuario">
    <label for="imagenFoto" class="col-sm-2 control-label">Foto</label>
    <div class="col-sm-10">
      <input type="file" id="imagenFoto" name="imagenFoto" />
    </div>
  </div>
  <div class="form-group" title="Imagen de Usuario">
    <label for="imagenFirma" class="col-sm-2 control-label">Firma escaneada</label>
    <div class="col-sm-10">
      <input type="file" id="imagenFirma" name="imagenFirma" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-danger">Guardar Cambios</button>
    </div>
  </div>

</form>
<script>
  $(document).ready(function () {
    $("#frm-datosusuario").submit(function (evt) {

      if ($("#claveUsuario").val() !== $("#clave2Usuario").val()) {
        alert('No coinciden los datos de la nueva clave.');
        return false;
      }

      var formData = new FormData(document.getElementById("frm-datosusuario"));
      ejecutarAccionArchivos('sistema', 'usuarios', 'actualizarDatosUsuarios', formData,
        function (resp) {
          mostrarRespuesta(resp);
          mostrarContenidos('sistema', 'usuarios', 'mostrarPerfil');
        });
    });
  });

</script>



