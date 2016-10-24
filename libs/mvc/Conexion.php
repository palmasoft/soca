<?php
/*
  SPDO es una clase que extiende de PDO, su �nica ventaja es que nos permite
  aplicar el patron Singleton para mantener una �nica instancia de PDO.
 */
class BaseDatosSistema extends PDO {
  public static $instance = null;
  private static $transaccion = null;

  public function __construct() {
    try {
      $options = array(
       PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8; ",
       PDO::ATTR_PERSISTENT => true,
       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );
      parent::__construct(
       '' . dbtype_basico .
       ':dbname=' . dbname_basico .
       ';host=' . dbhost_basico . ''
       , dbuser_basico
       , dbpass_basico
       , $options
      );
      //$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } catch(PDOException $e) {
      echo '<script>alert( "HA OCURRIDO UN ERROR AL INTENTAR CONECTARCE CON '
      . 'EL MOTOR DE DATOS DEL SISTEMA EN ' . dbtype_basico . ':dbname=' . dbname_basico . ';host=' . dbhost_basico . ' \n\r' .
      $e->getMessage() . '");</script>';
    }
  }

  public function updSistema($query, $valores = NULL) {
    $consulta = $this->prepare($query);
    if(!is_null($valores)) {
      foreach($valores as $pos => $valor) {
        $consulta->bindParam(($pos + 1), $valor);
      }
    }
    if($consulta->execute()) {
      return $consulta->rowCount();
    }
    return 0;
  }

  public function qrySistema($query, $valores = NULL) {
    $pos = 0;
    $resp = NULL;
    $consulta = $this->prepare($query);
    if(!is_null($valores)) {
      foreach($valores as $pos => $valor) {
        $consulta->bindParam(($pos + 1), $valor);
      }
    }
    if($consulta->execute()) {
      $resp = $consulta->fetchAll(PDO::FETCH_CLASS);
    }
    return $resp;
  }

  public static function singleton() {
    if(self::$instance == null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

}
$ObjConexSistema = new BaseDatosSistema();
