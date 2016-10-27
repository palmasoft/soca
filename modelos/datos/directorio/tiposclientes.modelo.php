<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class TiposClientes extends Modelos {

  private static $nTabla = "tiposclientes";
  private static $sqlBase = "SELECT tiposclientes.* FROM tiposclientes ";
  private static $sqlCompleta = "";
  private static $sqlJoin = "";

  static public function todos($ESTADO = 'ACTIVO') {
	$query = self::$sqlBase . ' WHERE tipoClienteEstado = "' . $ESTADO . '"';
	$resultado = self::consulta($query);
	if (count($resultado) > 0) {
	  return $resultado;
	}
	return NULL;
  }

  static public function datos($idTipoCliente) {
	$query = self::$sqlBase . " WHERE tiposclientes.tipoClienteId = ? ";
	$resultado = self::consulta($query, array($idTipoCliente));
	if (count($resultado) > 0) {
	  return $resultado[0];
	}
	return NULL;
  }

  static public function insertar($tipoClienteCodigo, $tipoClienteTitulo,
   $tipoClienteDesc) {
	$query = " INSERT INTO `tiposclientes` ( "
	 . "`tipoClienteCodigo`, `tipoClienteTitulo`, `tipoClienteDefinicion` "
	 . ") VALUES ( ?, ?, ? ) ; ";
	$resultado = self::crearUltimoId($query,
	  array($tipoClienteCodigo, $tipoClienteTitulo,
	  $tipoClienteDesc)
	);
	if (($resultado) > 0) {
	  return $resultado;
	}
	return NULL;
  }

  static public function actualizar($idTipoCliente, $tipoClienteCodigo,
   $tipoClienteTitulo, $tipoClienteDesc) {
	$query = " UPDATE `tiposclientes` SET "
	 . "`tipoClienteCodigo` = ?, `tipoClienteTitulo` = ?, `tipoClienteDefinicion` = ? "
	 . "WHERE `tipoClienteId` = ? ; ";
	$resultado = self::modificarRegistros($query,
	  array($tipoClienteCodigo, $tipoClienteTitulo,
	  $tipoClienteDesc, $idTipoCliente)
	);
	if (($resultado) > 0) {
	  return $resultado;
	}
	return NULL;
  }

  static public function activar($idTipoCliente) {
	$query = " UPDATE `tiposclientes` SET tipoClienteEstado = 'ACTIVO' WHERE `tipoClienteId` = ? ; ";
	$resultado = self::modificarRegistros($query, array($idTipoCliente));
	if (($resultado) > 0) {
	  return $resultado;
	}
	return NULL;
  }

  static public function desactivar($idTipoCliente) {
	$query = " UPDATE `tiposclientes` SET tipoClienteEstado = 'INACTIVO' WHERE `tipoClienteId` = ? ; ";
	$resultado = self::modificarRegistros($query, array($idTipoCliente));
	if (($resultado) > 0) {
	  return $resultado;
	}
	return NULL;
  }

}
