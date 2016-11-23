<div class="post">
  <div class="user-block">
    <img class="img-circle img-bordered-sm" src="media/iconos/textos.png" />
    <span class="username">
      <a href="#">Datos de Contacto</a>
    </span>
  </div>
  <div class="container-fluid">
    <div class="row  person-info">
      <div class="col-md-6">
        <h3 class="about-subtitle">Personal</h3>
        <h5><strong>Identificación :</strong> <?php echo Usuario::identificacionUsuario() ?></h5>
        <h5><strong>Nombres :</strong> <?php echo Usuario::nombresUsuario() ?></h5>
        <h5><strong>Apellidos :</strong> <?php echo Usuario::apellidosUsuario() ?></h5>
        <h5><strong>Edad :</strong> <?php echo Usuario::edadUsuario() ?></h5>      
        <h5><strong>Correo :</strong> <?php echo Usuario::correoUsuario() ?></h5>
        <h5><strong>Dirección :</strong> <?php echo Usuario::direccionUsuario() ?></h5>
        <h5><strong>Ubicación :</strong> <?php echo Usuario::cantonUsuario() ?>, <?php echo Usuario::provinciaUsuario() ?></h5>
      </div>
      <div class="col-md-6">
        <h3 class="about-subtitle">Laborales</h3>
        <h5><strong>Sede :</strong> <?php echo Usuario::codigoSedeEmpleado() ?> - <?php echo Usuario::sedeEmpleado() ?></h5>
        <h5><strong>Cargo / Función :</strong> <?php echo Usuario::cargoEmpleado() ?></h5>
        <h5><strong>Tipo de Vinculación :</strong> <?php echo Usuario::tipoEmpleado() ?></h5>
        <h5><strong>Inicio de Labores :</strong> <?php echo Usuario::fechaInicioEmpleado() ?></h5>      
        <h5><strong>Final de Labores :</strong> <?php echo Usuario::fechaFinEmpleado() ?></h5>  
        <h5><strong>Salario :</strong> <?php echo Textos::dinero(Usuario::salarioEmpleado()) ?></h5>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>


<div class="post">
  <div class="user-block">    
    <img class="img-circle img-bordered-sm" src="media/iconos/fotos.png" />
    <span class="username">
      <a href="#">Imagenes</a>
    </span>
  </div>


  <div class="user-body">    


    <div class="text-center">
      <div class="row fotos">
        <div class="col-sm-12 col-md-6">
          <img class="" src="<?php echo Usuario::fotoPersona() ?>" alt="Photo" style="max-width: 210px;" />
          <br />
          <h4>Foto</h4>
        </div>
        <div class="col-sm-12 col-md-6"> 
          <img class="" src="<?php echo Usuario::firmaEscaneadaUsuario() ?>" alt="Photo" style="max-width: 210px;" />          
          <br />
          <h4>Firma</h4>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="post">
  <div class="user-block">
    <img class="img-circle img-bordered-sm" src="media/iconos/textos.png" />
    <span class="username">
      <a href="#">Observaciones</a>
    </span>
  </div>
  <p><?php echo Usuario::observacionesUsuario() ?></p>
</div>
