<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Perfil del Colaborador
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="javascript:void(0);">Usuarios</a></li>
    <li class="active">Mi Perfil</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class=" box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="<?php echo Usuario::fotoPersona() ?>" alt="User profile picture">

          <h3 class="profile-username text-center"><?php echo Usuario::nombreCompletoUsuario() ?></h3>

          <p class="text-muted text-center"><?php echo Usuario::cargoEmpleado() ?></p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Sede</b> <a class="pull-right"><?php echo Usuario::sedeEmpleado() ?></a>
            </li>
            <li class="list-group-item">
              <b>Identificación</b> <a class="pull-right"><?php echo Usuario::identificacionUsuario() ?></a>
            </li>
            <li class="list-group-item">
              <b>Teléfono</b> <a class="pull-right"><?php echo Usuario::telefonoUsuario() ?></a>
            </li>
            <li class="list-group-item">
              <b>Último ingreso</b> <a class="pull-right" style="max-width: 100px; text-align: right" ><?php echo Usuario::ultimaVisitaUsuario() ?></a>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Sobre mi</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
<!--          <strong><i class="fa fa-book margin-r-5"></i> Formación</strong>

          <p class="text-muted">
          
          </p>

          <hr>

          <strong><i class="fa fa-map-marker margin-r-5"></i> Ubicación</strong>

          <p class="text-muted"></p>

          <hr>

          <strong><i class="fa fa-pencil margin-r-5"></i> Responsabilidades</strong>

          <p>
            <span class="label label-danger">UI Design</span>
            <span class="label label-success">Coding</span>
            <span class="label label-info">Javascript</span>
            <span class="label label-warning">PHP</span>
            <span class="label label-primary">Node.js</span>
          </p>

          <hr>-->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class=" active"><a href="#datosUsuario" data-toggle="tab">Mis datos</a></li>
          <li class=" "><a href="#settings" data-toggle="tab">Configuración</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="datosUsuario">
            <?php Vistas::cargar('info-datosusuario'); ?>
          </div>
          <div class="tab-pane " id="settings">
            <?php Vistas::cargar('frm-datosusuario'); ?>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->