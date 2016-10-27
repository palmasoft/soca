<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class TiposIdentificacion extends Modelos {

  private static
   $nTabla = "tiposidentificacion";
  private static
   $sqlBase = "SELECT tiposidentificacion.* FROM tiposidentificacion ";
  private static
   $sqlCompleta = "";
  private static
   $sqlJoin = "";

  const 
   Cedula = 1; 
  const
   NIT = 1;

  static public
   function todos($ESTADO = 'ACTIVO') {
    $query = self::$sqlBase . ' WHERE tipoIdentificacionEstado = "' . $ESTADO . '"';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function datos($idTipoEquipo) {
    $query = self::$sqlBase . " WHERE tiposidentificacion.tipoIdentificacionId = ? ";
    $resultado = self::consulta($query, array($idTipoEquipo));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function insertar($tipoIdentificacionCodigo, $tipoIdentificacionTitulo, $tipoIdentificacionDesc) {
    $query = " INSERT INTO `tiposidentificacion` ( "
     . "`tipoIdentificacionCodigo`, `tipoIdentificacionTitulo`, `tipoIdentificacionDesc` "
     . ") VALUES ( ?, ?, ? ) ; ";
    $resultado = self::crearUltimoId($query,
                                     array($tipoIdentificacionCodigo, $tipoIdentificacionTitulo,
      $tipoIdentificacionDesc)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function actualizar($idTipoEquipo, $tipoIdentificacionCodigo, $tipoIdentificacionTitulo, $tipoIdentificacionDesc) {
    $query = " UPDATE `tiposidentificacion` SET "
     . "`tipoIdentificacionCodigo` = ?, `tipoIdentificacionTitulo` = ?, `tipoIdentificacionDesc` = ? "
     . "WHERE `tipoIdentificacionId` = ? ; ";
    $resultado = self::modificarRegistros($query,
                                          array($tipoIdentificacionCodigo, $tipoIdentificacionTitulo,
      $tipoIdentificacionDesc, $idTipoEquipo)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function activar($idTipoEquipo) {
    $query = " UPDATE `tiposidentificacion` SET tipoIdentificacionEstado = 'ACTIVO' WHERE `tipoIdentificacionId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idTipoEquipo));
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function desactivar($idTipoEquipo) {
    $query = " UPDATE `tiposidentificacion` SET tipoIdentificacionEstado = 'INACTIVO' WHERE `tipoIdentificacionId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idTipoEquipo));
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
