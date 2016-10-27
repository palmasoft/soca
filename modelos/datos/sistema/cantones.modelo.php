<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class Cantones extends Modelos {

  private static
   $id_cargo;
  private
   $codigo_cargo;
  private
   $nombre_cargo;
  private
   $permisos_cargo = '{}';
  private static
   $nTabla = "cantones";
  private static
   $sqlBase = "SELECT cantones.* FROM cantones ";
  private static
   $sqlCompleta = " ";

  public static
   function todos() {
    $query = self::$sqlBase;
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function datos($idCanton) {
    $query = self::$sqlBase . " WHERE cantones.cantonId = " . $idCanton . " ; ";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta[0];
    }
    return 0;
  }

  public static
   function porProvincia($idProvincia) {
    $query = self::$sqlBase . " WHERE cantones.cantonProvincia = ? ";
    $consulta = self::consulta($query, array($idProvincia));
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

}
