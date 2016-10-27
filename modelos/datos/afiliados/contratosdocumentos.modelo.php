<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
Modelos::cargar('Documentos' . DS . 'TiposDocumentos');

class ContratosAfiliadosDocumentos extends Modelos {

  private static
   $nTabla = "contratosafiliadosdocumentos";
  private static
   $sqlBase = <<<sqlBase
SELECT
  contratosafiliadosdocumentos.*, documentos.*
FROM contratosafiliadosdocumentos
INNER JOIN documentos ON ( contratosafiliadosdocumentos.contratodocumentoDocumento = documentos.documentoId )
   
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
    $query = self::$sqlBase . ' WHERE ' . self::$nTabla . '.contratodocumentoContrato = ? ';
    $resultado = self::consulta($query, array($contratoId));
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function delTipoDelContrato($tipoDocId, $contratoId) {
    $query = self::$sqlBase . ' WHERE '
     . '' . self::$nTabla . '.contratodocumentoTipodocumento = ? AND '
     . '' . self::$nTabla . '.contratodocumentoContrato = ? ';
    $resultado = self::consulta($query, array($tipoDocId, $contratoId));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function insertar($contratodocumentoContrato, $contratodocumentoTipodocumento, $contratodocumentoDocumento) {
    $query = "INSERT INTO " . self::$nTabla . " (  "
     . "contratodocumentoContrato  , contratodocumentoTipodocumento  , contratodocumentoDocumento , contratodocumentoGenero "
     . ") VALUES  (?, ?, ?, ? ) ; ";
    $resultado = self::crearUltimoId(
      $query,
      array($contratodocumentoContrato, $contratodocumentoTipodocumento, $contratodocumentoDocumento, Visitante::idUsuario())
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function eliminar($contratodocumentoContrato, $contratodocumentoTipodocumento) {
    $query = "DELETE FROM " . self::$nTabla . "  "
     . "WHERE  contratodocumentoContrato = ? AND contratodocumentoTipodocumento = ?  ";
    $resultado = self::modificarRegistros(
      $query, array($contratodocumentoContrato, $contratodocumentoTipodocumento)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
