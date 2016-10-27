<?php
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class Sedes extends Modelos {
  private static $nTabla = "sedes";
  private static $sqlBase = "SELECT sedes.* FROM sedes ";
  private static $sqlCompleta = " ";

  public static function todos() {
    $query = self::$sqlBase;
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return null;
  }

  public static function datos($idSede) {
    $query = self::$sqlBase . "WHERE sedes.sedeId = " . $idSede . "";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta[0]; 
    }
    return null;
  }

}