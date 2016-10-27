<?php
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class EstadosContratos extends Modelos {
  private static
   $nTabla = "estadocontratos";
  private static
   $sqlBase = "SELECT estadocontratos.* FROM estadocontratos ";
  private static
   $sqlCompleta = "";
  private static
   $sqlJoin = ""; 

  static public
   function todos() {
    $query = self::$sqlBase; //. ' WHERE tipoDocumentoEstado = "' . $ESTADO . '"';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static function datos($idEstado) {
    $query = self::$sqlBase . "WHERE estadocontratos.estadoContratoId = " . $idEstado . "";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta[0];
    }
    return NULL;
  }

  static public
   function idPorCodigo($codigoEstado) {
    $query = self::$sqlBase . ' WHERE estadoPagoCodigo = "' . $codigoEstado . '"';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado[0]->estadoPagoId;
    }
    return NULL;
  }

}