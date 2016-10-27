<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class Documentos extends Modelos {

  private static
   $nTabla = "documentos";
  private static
   $sqlBase = "SELECT documentos.* FROM documentos ";
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
   function datos($documentoId) {
    $query = self::$sqlBase . " WHERE documentos.documentoId = ? ";
    $resultado = self::consulta($query, array($documentoId));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function datosPorCodigo($documentoCodigo) {
    $query = self::$sqlBase . " WHERE documentos.documentoCodigo = ? ";
    $resultado = self::consulta($query, array($documentoCodigo));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function insertar($documentoCodigo, $documentoTipo, $documentoConsecutivo, $documentoTitulo, $documentoUrl) {
    $query = " INSERT INTO documentos ("
     . "documentoCodigo , documentoTipo , documentoConsecutivo , documentoTitulo , documentoUrl, documentoUsuario "
     . ") VALUES ( ?, ?, ?, ?, ?, ? ) ; ";
    $resultado = self::crearUltimoId(
      $query,
      array($documentoCodigo, $documentoTipo, $documentoConsecutivo,
      $documentoTitulo, $documentoUrl, Visitante::idUsuario())
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function actualizar($idTipoEquipo, $tipoEquipoCodigo, $tipoEquipoTitulo, $tipoEquipoDesc) {
    $query = " UPDATE `tiposequipos` SET "
     . "`tipoEquipoCodigo` = ?, `tipoEquipoTitulo` = ?, `tipoEquipoDesc` = ? "
     . "WHERE `tipoEquipoId` = ? ; ";
    $resultado = self::modificarRegistros($query,
                                          array($tipoEquipoCodigo, $tipoEquipoTitulo,
      $tipoEquipoDesc, $idTipoEquipo)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function activar($idTipoEquipo) {
    $query = " UPDATE `tiposequipos` SET tipoEquipoEstado = 'ACTIVO' WHERE `tipoEquipoId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idTipoEquipo));
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function desactivar($idTipoEquipo) {
    $query = " UPDATE `tiposequipos` SET tipoEquipoEstado = 'INACTIVO' WHERE `tipoEquipoId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idTipoEquipo));
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
