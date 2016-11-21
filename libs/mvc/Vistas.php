<?php
/*
  Es una peque�a clase que hace de motor de plantilla,
  aunque con poquitas funcionalidades. Solo nos permite incluir una plantilla
  y asignarle variables.
 */
class Vistas extends Base {

  function __construct() {
    parent::__construct();
  }

  public static function html($nombreVista, $varsVista = array(), $componente = '') {
    $response = '';
    if($componente == '') {
      $componente = isset(self::$datos['componente']) ? strtolower(self::$datos['componente']) : $componente;
    }
    $ruta_interna = $componente . DS . DIR_VISTAS . DS . $nombreVista . EXT_VISTAS;
    $path_base = PATH_COMPONENTES . $ruta_interna;

    if(!file_exists($path_base)) {
      echo " Error Cargando Vista " . $componente . "/" . $nombreVista;
      return false;
    }
    $url_interna = $componente . '/' . DIR_VISTAS . '/' . $nombreVista . EXT_VISTAS;
    echo $urlInterface = URL_COMPONENTES . '/' . $url_interna;
    $datosString = array();
    if(is_array($varsVista)) {
      foreach($varsVista as $key => $value) {
        $datosString[$key] = $value;
      }
    }
    $postdata = http_build_query($datosString);
    $opts = array('http' =>
     array(
      'method' => 'GET',
      'header' => 'Content-type: application/x-www-form-urlencoded',
      'content' => $postdata,
      'Content-Length' => '4000'
     )
    );
    $context = stream_context_create($opts);
    $response = file_get_contents($urlInterface, 0, $context);
    return $response;
  }

  public static function cargar($nombreVista, $varsVista = array(), $componente = '') {
    if($componente == '') {
      $componente = isset(self::$datos['componente']) ? strtolower(self::$datos['componente']) : $componente;
    }
    $ruta_interna = $componente . DS . DIR_VISTAS . DS . $nombreVista . EXT_VISTAS;
    $path_base = PATH_COMPONENTES . $ruta_interna;

    if(!file_exists($path_base)) {
      if($desdeErrores) {
        echo " Error Cargando Vista " . $componente . "/" . $nombreVista;
      } else {
        Errores::mensaje_error(101);
      }
      return false;
    }
    if(is_array($varsVista)) {
      foreach($varsVista as $key => $value) {
        $$key = $value;
      }
    }
    include $path_base;
  }

  public static function mostrar($nombreVista, $varsVista = array(), $componente = '', $controlador = '',
   $desdeErrores = false) {
       
    if($componente == '') {
      $componente = isset(self::$datos['componente']) ? strtolower(self::$datos['componente']) : $componente;
    }
    if($controlador == '') {
      $controlador = isset(self::$datos['controlador']) ? strtolower(self::$datos['controlador']) : $controlador;
    }
    $ruta_interna = $componente . DS . DIR_VISTAS . DS . $controlador . DS . $nombreVista . EXT_VISTAS;
    $path_base = PATH_COMPONENTES . $ruta_interna;
    $path_base_css = PATH_COMPONENTES . $componente . DS . DIR_ESTILOS . DS . $controlador . DS . ( $desdeErrores ? 'errores' : self::$datos['controlador'] ) . ".css";
    $path_base_datos = PATH_COMPONENTES . $componente . DS . $controlador . DS . DIR_VISTAS . DS . $controlador . DS;


    if(file_exists($path_base_css)) {
      echo '<style>';
      echo Archivos::leer_archivo($path_base_css);
      echo '</style>';
    }

    if(!file_exists($path_base)) {
      if($componente != '') {
        $ruta_interna = $componente . DS . $controlador . DS . $nombreVista . EXT_VISTAS;
        $path_base = Plantillas::$ruta . $ruta_interna;
      }
      if(!file_exists($path_base)) {
        $ruta_interna = 'sistema' . DS . DIR_VISTAS . DS . $controlador . DS . $nombreVista . EXT_VISTAS;
        $path_base = PATH_COMPONENTES . $ruta_interna;
        if(!file_exists($path_base)) {
          if($desdeErrores) {
            echo " Error Cargando Vista " . $componente . "/" . $controlador . DS . $nombreVista;
          } else {
            echo " Error Cargando Vista " . $componente . "/" . $controlador . DS . $nombreVista . " [$path_base] ";
//            Errores::mensaje_error(101);
          }
          return false;
        }
      }
    }
    if(is_array($varsVista)) {
      foreach($varsVista as $key => $value) {
        $$key = $value;
      }
    }

//    $ruta_navegacion = Xml::datos_en_archivo($nombreVista, $path_base_datos);
//    $nav = Plantillas::html_navegacion_sistema();
//    if (!is_null($nav)) {
//      include $nav;
//    } else {
//      include 'libs' . DS . 'sistema' . DS . 'plantilla' . DS . 'navegacion.php';
//    }

    $msgSys = Sesion::mensajeOperacion();
    Sesion::mensajeOperacion("");
    echo $msgSys;
    include $path_base;
    GoogleServices::google_analitycs();
  }

}
$ObjCtrVistas = new Vistas();
