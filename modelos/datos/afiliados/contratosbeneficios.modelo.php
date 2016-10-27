<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class ContratosAfiliadosBeneficios extends Modelos {

  private static
   $nTabla = "contratosafiliadosbeneficios";
  private static
   $sqlBase = <<<sqlBase
SELECT
  contratosafiliadosbeneficios.*, beneficios.*
FROM contratosafiliadosbeneficios
INNER JOIN beneficios ON ( contratosafiliadosbeneficios.contratobeneficioBeneficio = beneficios.beneficioId )
   
sqlBase;
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
   function delContrato($contratoId) {
    $query = self::$sqlBase . ' WHERE ' . self::$nTabla . '.contratobeneficioContrato = ? ';
    $resultado = self::consulta($query, array($contratoId));
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function insertar($contratobeneficioContrato, $contratobeneficioBeneficio) {
    $query = "INSERT INTO contratosafiliadosbeneficios (  "
     . "contratobeneficioContrato  , contratobeneficioBeneficio  , contratobeneficioCreo "
     . ") VALUES  (? , ? , ? ) ; ";
    $resultado = self::crearUltimoId(
      $query, array($contratobeneficioContrato, $contratobeneficioBeneficio, Visitante::idUsuario())
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
