<?php

class Plantillas extends Base {
  protected
   $usuario;
  protected
   $controlador;
  protected
   $sesion;
  protected
   $modelo;
  static
   $ruta;
  static
   $ruta_archivos_usuario;
  static
   $ruta_tmpl_login;
  static
   $ruta_tmpl_admin;
  static
   $ruta_tmpl_offline;
  static
   $url;
  static
   $url_archivos_usuario;
  static
   $url_tmpl_login;
  static
   $url_tmpl_admin;
  static
   $idioma = 'set_locale(LC_ALL,"es_ES@euro","es_ES","esp")';

  function __construct() {
    self::$ruta = PATH_PLANTILLAS . Parametros::valor("plantilla") . DS;
    self::$url = URL_PLANTILLAS . Parametros::valor("plantilla") . "/";

    self::$ruta_tmpl_login = self::$ruta . "login.php";
    self::$ruta_tmpl_admin = self::$ruta . "admin.php";
    self::$ruta_tmpl_offline = self::$ruta . "offline.php";
    try {
      if(Usuario::esta_logueado()) {
        //Usuario::cerrar();
        //print_r( $_SESSION );
        $namePlantilla = Parametros::valor('plantilla_admin');
        self::$ruta = PATH_PLANTILLAS . $namePlantilla . DS;
        self::$ruta_archivos_usuario = PATH_ARCHIVOS . Usuario::nombreUsuario() . DS;
        self::$ruta_tmpl_login = self::$ruta . "login.php";
        self::$ruta_tmpl_admin = self::$ruta . "admin.php";

        self::$url = URL_PLANTILLAS . $namePlantilla . "/";
        self::$url_archivos_usuario = URL_ARCHIVOS . Usuario::nombreUsuario() . "/";
      }
    } catch(Exception $e) {
      
    }
  }

  public static
   function login() {
    //self::encabezado();
    if(file_exists(Plantillas::$ruta)) {
      if(is_file(Plantillas::$ruta_tmpl_login)) {
        include Plantillas::$ruta_tmpl_login;
      } else {
        Errores::mensaje_error(105);
      }
    } else {
      Errores::mensaje_error(104);
    }
    //self::piecera();
  }

  public static
   function admin() {
    //echo Plantillas::$ruta_tmpl_admin."<br />";
    //self::encabezado();
    //self::min_css();
    Modelos::cargar('Sistema' . DS . 'Componentes');
    Modelos::cargar('Sistema' . DS . 'Usuarios');
    $User = Usuarios::datos_del_usuario(Usuario::idUsuario());

    if($User->usuarioId == '0') {
      $User->componentes = Componentes::todos_con_permisos();
    } else {
      $User->componentes = Componentes::asignados_con_permisos(Usuario::idUsuario());
    }
    Config::set('OXYMED_USR', $User);

    if(file_exists(Plantillas::$ruta)) {
      if(is_file(Plantillas::$ruta_tmpl_admin)) {
        include Plantillas::$ruta_tmpl_admin;
      } else {
        Errores::mensaje_error(106);
      }
    } else {
      Errores::mensaje_error(104);
    }

    //print_r($_SESSION);
    //self::sonidos_sistema();
    //  self::min_js();
    //Zopim::chat_soporte();
    //self::piecera();
  }

  static
   function encabezado($titulo = '') {
    return '
            <meta charset="UTF-8">         
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
         <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
         <link rel="shortcut icon" href="media/favicon/favicon.ico" type="image/x-icon">
         <link rel="icon" href="media/favicon/favicon.ico" type="image/x-icon">

         <title>' . ( empty($titulo) ? Parametros::valor('titulo_sistema') : $titulo ) . '</title>
         <meta name="description" content="sistema de informacion de la camara de comercio de santa marta">
         <meta name="keywords" content="camara, comercio, santa marta">
         <meta name="author" content="Ing. Juan Pablo Llinas Ramirez"> 

  ' .
     '';
  }

  static
   function min_css() {
    return '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/basico.css" />'
     . '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/animaciones.css" />'
     . '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/jquery.msgbox.css" />'
     . '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/flaticon-contacto.css" />'
     . '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/flaticon-soporte.css" />'
     . '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/flaticon-interfaces.css" />'
     . '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/dropzone.css" />'
     . '<link rel="stylesheet" type="text/css" href="/libs/ui/estilos/plugins/select2.min.css" />';
  }

  static
   function min_js() {
    return '<script type="text/javascript" src="/libs/ui/parametros.js"></script>  '
     . '<script type="text/javascript" src="/libs/ui/js/msgbox/jquery.msgbox.js"></script>        '
     . '<script type="text/javascript" src="/libs/ui/js/dropzone.js"></script>        '
     . '<script type="text/javascript" src="/libs/ui/js/window.js" ></script>        '
     . '<script type="text/javascript" src="/libs/ui/js/tablas.js" ></script>         '
     . '<script type="text/javascript" src="/libs/ui/js/funciones.js" ></script>        '
     . '<script type="text/javascript" src="/libs/ui/js/ajax.js" ></script>          '
     . '<script type="text/javascript" src="/libs/ui/js/ayuda.js" ></script>          '
     . '<script type="text/javascript" src="/libs/ui/js/formularios.js"></script>                       '
     . '<script type="text/javascript" src="/libs/ui/js/listas.js" ></script>        '
     . '<script type="text/javascript" src="/libs/ui/js/plugins/select2.min.js"></script>';
  }

  /*
   * 
   * 
   * 
   * 
   * */

  //
  //
    //
    //
    //
    //
    //
    //
    
static
   function piecera() {
    return '<div>'
     . 'Este sistema es <a href="http://opensource.org/" target="_blank" >Codigo Abierto</a> u <a href="http://opensource.org/" target="_blank" >OpenSource</a>. '
     . 'Está bajo una <a href="http://http://opensource.org/licenses/CDDL-1.0/" target="_blank" >Licencia Common Development and Distribution License (CDDL-1.0)</a> '
     . 'y <a href="http://creativecommons.org/licenses/by-nc-nd/4.0/" target="_blank" >licencia Attribution-NonCommercial-NoDerivatives 4.0 International</a>.'
     . '</div>' . self::derechos();
  }

  static
   function derechos() {
    return;
    '<div>'
     . '<strong>Derechos de Copia y Distribución &copy; ' . date('Y') . ' '
     . '<a href="' . Parametros::valor('web_organizacion') . '" target="_blank" >' . Parametros::valor('nombre_organizacion') . '</a>.</strong> '
     . 'Todos los derechos reservados.'
     . '</div>';
  }

  static
   function js_modulos() {
    $strSricpts = '';
    $componentes = Archivos::listar_directorios_nombre(PATH_COMPONENTES);
    foreach($componentes as $directorio) {
      $dirScript = PATH_COMPONENTES . $directorio . DS . "funciones" . DS;
      $pathScript = "componentes/" . $directorio . "/funciones/";
      $archivos = Archivos::listar_archivos_directorio($dirScript, 'js');
      if(!is_null($archivos)) {
        foreach($archivos as $key => $value) {
          $strSricpts .= ' <script type="text/javascript" src="' . $pathScript . $value . '"></script> ';
        }
      }
    }
    return $strSricpts;
  }

  static
   function control_sesion_activa() {
    if(Usuario::esta_logueado()) {
      echo " 
            <script type=\"text/javascript\">
                $( document ).ready(function() {
                    setInterval(function () { esActivaSesion(); }, 360000);
                });
            </script>
            ";
    }
  }

  static
   function sonidos_sistema() {
    ?>
    <audio id="snd_beep_1" style="display:none;" >
      <source src="media/audios/Robot_blip.mp3" type="audio/mpeg">                
    </audio>

    <audio id="snd_beep_2" style="display:none;" >
      <source src="media/audios/Beep_Ping.mp3" type="audio/mpeg">                
    </audio>

    <script>
      function beep(num) {
        $('#snd_beep_' + num).trigger("play");
      }
    </script>

    <audio id="snd_alerta_1" style="display:none;" >
      <source src="media/audios/Answer_Beep.mp3" type="audio/mpeg">                
    </audio>

    <audio id="snd_alerta_2" style="display:none;" >
      <source src="media/audios/Error_Alert.mp3" type="audio/mpeg">                
    </audio>
    <script>
      function alerta(num) {
        $('#snd_alerta_' + num).trigger("play");
      }
    </script>
    <?php
  }

  static
   function mensajes_usuarios_conectados() {
    if(Usuario::esta_logueado()) {
      echo " 
            <script type=\"text/javascript\">
                $( document ).ready(function() {
                    setInterval(function () { consulta_mensajes_para_usuarios(); }, 30000);
                });
            </script>
            ";
    }
  }

  static
   function reloj_hora_sistema() {
    echo '
             <script>
            var fechaHoraSistema = new Date("' . Usuario::fecha_hora_sistema() . '");
            function muestraRelojSistema() {
                
                var valorFecha = fechaHoraSistema.valueOf();
                var valorFechaTermino = valorFecha +  ( 1000 );
                fechaHoraSistema = new Date(valorFechaTermino);
                    
                var horas = fechaHoraSistema.getHours();
                var minutos = fechaHoraSistema.getMinutes();
                var segundos = fechaHoraSistema.getSeconds();

                if(horas < 10) { horas = "0" + horas; }
                if(minutos < 10) { minutos = "0" + minutos; }
                if(segundos < 10) { segundos = "0" + segundos; }

                document.getElementById("relojSistema").innerHTML = horas+":"+minutos+":"+segundos;
            }
            setInterval(muestraRelojSistema, 1000);
          </script>
          <span id="relojSistema" ></span>';
  }

  static
   function reloj_hora_cliente() {
    echo '
            <script>
            function muestraRelojCliente() {
                var fechaHora = new Date();
                var horas = fechaHora.getHours();
                var minutos = fechaHora.getMinutes();
                var segundos = fechaHora.getSeconds();

                if(horas < 10) { horas = "0" + horas; }
                if(minutos < 10) { minutos = "0" + minutos; }
                if(segundos < 10) { segundos = "0" + segundos; }

                document.getElementById("relojCliente").innerHTML = horas+":"+minutos+":"+segundos;
            }
            setInterval(muestraRelojCliente, 1000);
          </script>
          <span id="relojCliente" ></span>';
  }

  static
   function estilos_scripts_modulos() {
    $this->cargar_estilos_modulos();
    $this->cargar_scripts_modulos();
  }

  static
   function html_navegacion_sistema() {
    $filename = self::$ruta . "navegacion.php";
    if(file_exists($filename)) {
      return $filename;
    }
    return NULL;
  }

  function ruta() {
    echo $this->ruta_tmpl_login;
  }

  function ruta_admin() {

    echo $this->ruta_tmpl_admin;
  }

  function ruta_archivos() {

    echo $this->ruta_url_archivos;
  }

  function cargar_scripts_modulos($value = '') {
    foreach($_SESSION['SESION_MODULOS_ACTIVOS'] as $key => $value) {
      $dirScript = "componentes" . DS . $value->NOMBRE_MODULO . DS . "funciones" . DS;
      $pathScript = "componentes/" . $value->NOMBRE_MODULO . "/funciones/";
      $archivos = Archivos::listar_archivos_directorio(PATH_BASE . $dirScript, 'js');
      if(!is_null($archivos))
          foreach($archivos as $key => $value) {
          echo ' <script type="text/javascript" src="' . $pathScript . $value . '"></script> ';
        }
    }
  }

  function cargar_estilos_modulos($value = '') {

    foreach($_SESSION['SESION_MODULOS_ACTIVOS'] as $key => $modulo) {
      $dirEstilo = "componentes" . DS . $modulo->NOMBRE_MODULO . DS . "estilos" . DS;
      $pathEstilo = "componentes/" . $modulo->NOMBRE_MODULO . "/estilos/";
      $archivos = Archivos::listar_archivos_directorio(PATH_BASE . $dirEstilo, 'css');
      if(!is_null($archivos))
          foreach($archivos as $key => $value) {
          echo '<link rel="stylesheet" type="text/css" href="' . $pathEstilo . $value . '" /> ';
        }
    }
  }

  function breadcrumbs() {
    
  }

  function detalles_usuario() {
    echo '
            <img class="img-left framed" src="' . $this->ruta_url_archivos . 'usuarios/' . $_SESSION["SESION_URL_FOTO"] . '"	alt="Hello ' . $_SESSION["SESION_NOMBRE"] . '" />
            <h3>Ha ingresado como</h3>
            <h2><a class="user-button" href="javascript:void(0);">' . $_SESSION["SESION_NICK"] . '&nbsp;<span class="arrow-link-down"></span></a></h2>
            <ul class="dropdown-username-menu">
                    <li><a href="#">Perfil</a></li>
                    <li><a href="#">Ajustes</a></li>
                    <li><a href="#">Mensajes</a></li>
                    <li><a href="#" onclick="cerrar_sesion();">Cerrar Sesión</a></li>
            </ul>';
  }

  function menu_usuario() {
    return Usuario::menu();
  }

}
$ObjPlantillas = new Plantillas();
