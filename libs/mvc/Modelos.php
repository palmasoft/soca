<?php
class Modelos {
  static $campos = array();
  private static $nTabla = "";
  private static $sqlBase = "";
  private static $sqlCompleta = "";
  private static $sqlJoin = "";
  private static $idTabla = "";
  private static $db = NULL;

  public function __construct() {
    self::$db = BaseDatosSistema::singleton();
  }

  public static function iniciarTransaccion() {
// First of all, let's begin a transaction
    self::$db->beginTransaction();
  }

  public static function aceptarTransaccion() {
// First of all, let's begin a transaction
    self::$db->commit();
  }

  public static function cancelarTransaccion() {
// First of all, let's begin a transaction
    self::$db->rollBack();
  }

  public static function prepararConsulta($query) {
    $consulta = null;
    try {
      $consulta = self::$db->prepare($query);
      if(!$consulta) {
        echo "\nInformacion del Error :\n";
        print_r(self::$db->errorInfo());
        return null;
      }
    } catch(PDOException $e) {
      echo "Error de Base de Datos: " . $e->getMessage() . "\r\n";
    }
    return $consulta;
  }

  public static function consulta($query, $datos = NULL) {
    $result = NULL;
    $consulta = self::prepararConsulta($query);
    if($consulta != null) {
      try {
        $consulta->execute($datos);
        $RSL = $consulta->fetchAll(PDO::FETCH_CLASS);
        if(count($RSL) > 0) {
          $result = $RSL;
        }
      } catch(Exception $exc) {
        Consola::imprimir("\r\n");
        Consola::imprimir("\r\n");
        Consola::imprimir("la consulta enviada fue: " . $query . "\r\n");
        echo $exc->getMessage();
        Consola::imprimir("\r\n");
        Consola::imprimir($exc->getMessage());
        Consola::imprimir("\r\n");
        Consola::imprimir($exc->getTraceAsString());
        Consola::imprimir("\r\n");
        Consola::imprimir("\r\n");
      }
    }
    //$consulta->closeCursor();
    //$consulta = NULL;
    return $result;
  }

  public static function crearUltimoId($query, $datos = NULL) {
    $result = null;
    $consulta = self::prepararConsulta($query);
    if($consulta != null) {
      try {
        $consulta->execute($datos);
        $result = self::$db->lastInsertId();
      } catch(Exception $exc) {
        Consola::imprimir("\r\n");
        Consola::imprimir("\r\n");
        Consola::imprimir("la consulta enviada fue: " . $query . "\r\n");
        Consola::imprimir("\r\n");
        echo $exc->getMessage();
        // Consola::imprimir(var_dump($datos, TRUE));
        Consola::imprimir("\r\n");
        Consola::imprimir($exc->getMessage());
        Consola::imprimir("\r\n");
        Consola::imprimir($exc->getTraceAsString());
        Consola::imprimir("\r\n");
        Consola::imprimir("\r\n");
      }
    }
    // and now we're done; close it
    //self::$db = null;
    return $result;
  }

  public static function modificarRegistros($query, $datos = NULL) {
    $regModificados = '0';
    $consulta = self::prepararConsulta($query);
    if($consulta != null) {
      try {
        if($consulta->execute($datos)) {
          return $consulta->rowCount();
        }
      } catch(Exception $exc) {
//        Consola::imprimir("\r\n");
//        Consola::imprimir("\r\n");
        echo"la consulta enviada fue: " . $query . "\r\n";
//        Consola::imprimir("\r\n");
        (var_dump($datos, TRUE));
//        Consola::imprimir("\r\n");
        echo $exc->getMessage();
//        Consola::imprimir("\r\n");
//        Consola::imprimir($exc->getTraceAsString());
//        Consola::imprimir("\r\n");
//        Consola::imprimir("\r\n");
      }
    }
    return $regModificados;
  }

  public static function cargar($nombreModelo) {
    $ruta = PATH_MODELOS . strtolower($nombreModelo) . EXT_MODELOS;
    if(file_exists($ruta)) {
      include_once $ruta;
    }
  }

  /*
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   * */

  public static function _consulta($query, $datos = NULL) {
    $result = NULL;
    $result = self::$db->qrySistema($query, $datos);
    return $result;
  }

  public static function consulta2($query, $datos = NULL) {
    $result = NULL;
    $consulta = self::prepararConsulta($query);
    if($consulta != null) {
      if(!is_null($datos)) {
        foreach($datos as $pos => $valor) {
          $consulta->bindParam(($pos + 1), $valor);
        }
      }

      if($consulta->execute()) {
        $result = $consulta->fetchAll(PDO::FETCH_CLASS);
      }

      return $result;
    }

//$consulta->closeCursor();
//$consulta = NULL;
    return $result;
  }

  public static function _crearUltimoId($query, $datos = NULL) {
    $idUltimoCreado = '0';
    if(self::$db->updSistema($query, $datos)) {
      $idUltimoCreado = self::$db->lastInsertId();
    }

    return $idUltimoCreado;
  }

  public static function _modificarRegistros($query, $datos = NULL) {
    echo self::$db->updSistema($query, $datos);
    echo "<br />";
  }

  public static function __modificarRegistros($query, $datos = NULL) {
    $regModificados = '0';
    $consulta = self::prepararConsulta($query);
    if($consulta != null) {
      $consulta->execute($datos);
      if(!is_null($datos)) {
        foreach($datos as $pos => $valor) {
          echo "" . ($pos + 1) . " => " . $valor . ";  ";
          $consulta->bindParam(($pos + 1), $valor);
        }
      }

      print_r(self::$db);


      if($consulta->execute()) {
        $regModificados = $consulta->rowCount();
      }
    }
    // and now we're done; close it
    //self::$db = null;
    return $regModificados;
  }

}
new Modelos();
