<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class ContratosAfiliadosPagos extends Modelos {

  private static
   $nTabla = "contratosafiliadospagos";
  private static
   $sqlBase = "SELECT contratosafiliadospagos.* FROM contratosafiliadospagos ";
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

  static public
   function insertar($contratoPagoFecha, $contratoPagoContrato, $contratoPagoPersona, $contratoPagoBase,
                     $contratoPagoImpuestos) {
    $query = "INSERT INTO contratosafiliadospagos            ("
     . "contratoPagoFecha, contratoPagoContrato, contratoPagoPersona, contratoPagoBase, contratoPagoImpuestos, contratoPagoRegistro "
     . ") VALUES  ( ? , ? , ? , ? , ? , ? ) ; ";

    $resultado = self::crearUltimoId(
      $query,
      array($contratoPagoFecha, $contratoPagoContrato, $contratoPagoPersona, $contratoPagoBase, $contratoPagoImpuestos, Visitante::idUsuario())
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
