<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class CargosEmpleados extends Modelos {

  private static $nTabla = "cargosempleados";
  private static $sqlBase = "SELECT cargosempleados.* FROM cargosempleados ";
  private static $sqlCompleta = "";
  private static $sqlJoin = "";

  static public function todos($ESTADO = 'ACTIVO') {
    $query = self::$sqlBase . ' WHERE cargoEmpleadoEstado = "' . $ESTADO . '"';
    $resultado = self::consulta($query);
    if (count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public function datos($idCargoEmpleado) {
    $query = self::$sqlBase . " WHERE cargosempleados.cargoEmpleadoId = ? ";
    $resultado = self::consulta($query, array($idCargoEmpleado));
    if (count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public function insertar($cargoEmpleadoCodigo, $cargoEmpleadoTitulo,
          $cargoEmpleadoDesc) {
    $query = " INSERT INTO `cargosempleados` ( "
            . "`cargoEmpleadoCodigo`, `cargoEmpleadoTitulo`, `cargoEmpleadoDesc` "
            . ") VALUES ( ?, ?, ? ) ; ";
    $resultado = self::crearUltimoId($query,
                    array($cargoEmpleadoCodigo, $cargoEmpleadoTitulo,
                $cargoEmpleadoDesc)
    );
    if (($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public function actualizar($idCargoEmpleado, $cargoEmpleadoCodigo,
          $cargoEmpleadoTitulo, $cargoEmpleadoDesc) {
    $query = " UPDATE `cargosempleados` SET "
            . "`cargoEmpleadoCodigo` = ?, `cargoEmpleadoTitulo` = ?, `cargoEmpleadoDesc` = ? "
            . "WHERE `cargoEmpleadoId` = ? ; ";
    $resultado = self::modificarRegistros($query,
                    array($cargoEmpleadoCodigo, $cargoEmpleadoTitulo,
                $cargoEmpleadoDesc, $idCargoEmpleado)
    );
    if (($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public function activar($idCargoEmpleado) {
    $query = " UPDATE `cargosempleados` SET cargoEmpleadoEstado = 'ACTIVO' WHERE `cargoEmpleadoId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idCargoEmpleado));
    if (($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public function desactivar($idCargoEmpleado) {
    $query = " UPDATE `cargosempleados` SET cargoEmpleadoEstado = 'INACTIVO' WHERE `cargoEmpleadoId` = ? ; ";
    $resultado = self::modificarRegistros($query, array($idCargoEmpleado));
    if (($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
