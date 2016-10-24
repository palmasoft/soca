<?php
class Errores extends Base {
  public static $listado;
  public static $instance;

  public function __construct() {
    self::$listado = Xml::datos_en_archivo('errores', 'libs' . DS . 'sys' . DS);
    //print_r(self::$listado);
  }

  public static function singleton() {
    if(!isset(self::$instance)) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }

  public static function texto_error($COD_ERROR) {
    self::$datos['cod_error'] = $COD_ERROR;
    self::$datos['Error'] = self::informacion($COD_ERROR);
    Vistas::mostrar("errores/basico", self::$datos, 'sistema', true);
  }

  public static function mensaje_error($COD_ERROR) {
    self::$datos['cod_error'] = $COD_ERROR;
    self::$datos['Error'] = self::informacion($COD_ERROR);
    Vistas::mostrar("errores/info", self::$datos, 'sistema', true);
  }

  public static function contenido_error($COD_ERROR) {
    self::$datos['cod_error'] = $COD_ERROR;
    self::$datos['Error'] = self::informacion($COD_ERROR);
    Vistas::cargar("errores/contenido", self::$datos, 'sistema', true);
  }

  public static function html_error($COD_ERROR) {
    self::$datos['cod_error'] = $COD_ERROR;
    self::$datos['Error'] = self::informacion($COD_ERROR);
    return Vistas::html("errores/mensaje", self::$datos, 'sistema', true);
  }

  private static function informacion($COD_ERROR) {
    foreach(self::$listado->error as $Error) {
      if($Error->COD_ERROR == $COD_ERROR) {
        return $Error;
      }
    }
    return NULL;
  }

}
new Errores();
