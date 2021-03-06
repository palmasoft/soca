<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>S.O.C.A. 2 | Inicio | Solo empleados.</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="plantillas/AdminLTE-2.3.6/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="plantillas/AdminLTE-2.3.6/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plantillas/AdminLTE-2.3.6/plugins/iCheck/square/blue.css">

    <!--Animaciones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="./"><b>S.O.C.A.</b>v2</a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">digite sus datos de usuario</p>

        <form id="frm-login" method="post" onsubmit="return false;" >
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="txt_correo_usuario" placeholder="correo">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="txt_clave_usuario" placeholder="clave">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">      
              <div id="div-resp-login" class="animated " style="font-style: italic; font-weight: 900; font-color: red;" ></div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
            </div>
            <!-- /.col -->
          </div>
          <input type="hidden" name="modulo" value="sistema" />
          <input type="hidden" name="controlador" value="sesion" />
          <input type="hidden" name="accion" value="validarUsuario" />
        </form>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.2.3 -->
    <script src="plantillas/AdminLTE-2.3.6/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="plantillas/AdminLTE-2.3.6/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plantillas/AdminLTE-2.3.6/plugins/iCheck/icheck.min.js"></script>
    <script>
          $(function () {
            $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%' // optional
            });

            $("#frm-login").submit(function () {
              $.post("api.php", $(this).serialize(), function (data) {
                alert(data);
                var respuesta = JSON.parse(data);
                $("#div-resp-login").removeClass('hinge');
                $("#div-resp-login").html(respuesta.MENSAJE_RESPUESTA);
                $("#div-resp-login").addClass('flash shake');
                if (respuesta.TIPO_RESPUESTA == 'EXITO') {
                  location = './';
                } else {
                  setTimeout(function () {
                    $("#div-resp-login").removeClass('flash shake');
                    $("#div-resp-login").addClass('hinge');
                  }, 4321);
                }
              });
            });

          });
    </script>
  </body>
</html>
