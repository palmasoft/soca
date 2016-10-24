<?php
/*
  Es una pequeña clase de configuración con un funcionamiento muy sencillo,
  implementa el patron singleton para mantener una única instancia y poder acceder
  a sus valores desde cualquier sitio.
 */
class Parametros {
  public static
   $parametros;
  public static
   $instance;

  public
   function __construct() {
    self::$parametros = Xml::datos_en_archivo('libs/parametros');
    //var_dump(self::$parametros);
  }

  public static
   function valor($parametro) {
    $parametro = strtolower($parametro);
    if(isset(self::$parametros->$parametro)) {
      return self::$parametros->$parametro;
    }
    return "";
  }

  public
   function cambiarValor($parametro, $valor) {

    return $resultado;
  }

  public
   function nombre($parametro) {
    return $resultado;
  }

  public
   function descripcion($parametro) {
    return $resultado;
  }

  public
   function tieneValor($parametro, $valor) {
    $parametro = strtolower($parametro);
    $vParam = $this->valor($parametro);
    if($vParam == $valor) {
      return true;
    }
    return false;
  }

  public static
   function singleton() {
    if(!isset(self::$instance)) {
      $c = __CLASS__;
      self::$instance = new $c;
    }

    return self::$instance;
  }

}
class Params extends Parametros {

  function __construct() {
    parent::__construct();
  }

}
$ObjParametros = new Parametros();
