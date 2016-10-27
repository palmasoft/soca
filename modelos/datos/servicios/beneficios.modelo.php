<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class Beneficios extends Modelos {

  private static
   $nTabla = "beneficios";
  private static
   $sqlBase = "SELECT beneficios.* FROM beneficios ";
  private static
   $sqlCompleta = "";
  private static
   $sqlJoin = "";

  static public
   function todos() {
    $query = self::$sqlBase . '';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function conEstado($ESTADO = 'ACTIVO') {
    $query = self::$sqlBase . ' WHERE beneficioEstado = "' . $ESTADO . '"';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function datos($idBeneficio) {
    $query = self::$sqlBase . " WHERE beneficios.beneficioId = ? ";
    $resultado = self::consulta($query, array($idBeneficio));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function insertar($beneficioCodigo, $beneficioTitulo, $beneficioDesc) {
    $query = " INSERT INTO `beneficios` ( "
     . "`beneficioCodigo`, `beneficioTitulo`, `beneficioDesc` "
     . ") VALUES ( ?, ?, ? ) ; ";
    $resultado = self::crearUltimoId($query, array($beneficioCodigo, $beneficioTitulo,
      $beneficioDesc)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function actualizar($idBeneficio, $beneficioCodigo, $beneficioTitulo, $beneficioDesc) {
    $query = " UPDATE `beneficios` SET "
     . "`beneficioCodigo` = ?, `beneficioTitulo` = ?, `beneficioPorcentaje`, `beneficioDesc` = ? "
     . "WHERE `beneficioId` = ? ; ";
    $resultado = self::modificarRegistros($query,
                                          array($beneficioCodigo, $beneficioTitulo,
      $beneficioDesc, $idBeneficio)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function activar($idBeneficio) {
    $query = " UPDATE `beneficios` SET beneficioEstado = 'ACTIVO' WHERE `beneficioId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idBeneficio));
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function desactivar($idBeneficio) {
    $query = " UPDATE `beneficios` SET beneficioEstado = 'INACTIVO' WHERE `beneficioId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idBeneficio));
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
