<?php
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class PermisosUsuarios extends Modelos {
  private static
   $id_permiso;
  private static
   $titulo_permiso;
  private static
   $desc_permiso;
  private static
   $icono_permiso = 'fa fa-cubes';
  private static
   $modulo_permiso = 'sistema';
  private static
   $controlador_permiso = 'sistema';
  private static
   $accion_permiso = 'info';
  /**
   * Puede ser <b>SI </b>para mostrarce en el emnu principal del sistema, o <b>NO
   * </b>para evitar mostrarce
   */
  private static
   $menu_permiso = 'SI';
  private static
   $UQ_Modulos_codigo_modulo;
  private static
   $nTabla = "usuariosfunciones";
  private static
   $sqlBase = <<<sqlBase
   
   SELECT 
  funciones.*
  , usuariosfunciones.*
  , usuarios.* 
FROM
  usuariosfunciones 
  INNER JOIN funciones 
    ON (
      usuariosfunciones.usuarioFuncionAsignada = funciones.funcionId
    ) 
  INNER JOIN usuarios 
    ON (
      usuariosfunciones.usuarioFuncion = usuarios.usuarioId
    )
   
sqlBase;
  private static
   $sqlCompleta = <<<EOD
        SELECT 
  modulos.*
  , funciones.*
  , usuariosfunciones.*
  , usuarios.*
  , cargosempleados.*
  , personas.* 
FROM
  usuariosfunciones 
  INNER JOIN usuarios 
    ON (
      usuariosfunciones.usuarioFuncion = usuarios.usuarioId
    ) 
  INNER JOIN funciones 
    ON (
      usuariosfunciones.usuarioFuncionAsignada = funciones.funcionId
    ) 
  INNER JOIN personas 
    ON (
      usuarios.usuarioPersona = personas.personaId
    ) 
  INNER JOIN cargosempleados 
    ON (
      usuarios.usuarioCargo = cargosempleados.cargoEmpleadoId
    ) 
  INNER JOIN modulos 
    ON (
      funciones.funcionModulo = modulos.moduloCodigo
    )    
EOD;
  private static
   $sqlModulosUsuario = <<<EOD
        SELECT   modulos.*        FROM   usuariosfunciones         
        LEFT JOIN     funciones ON (usuariosfunciones.usuarioFuncionAsignada = funciones.funcionId)        
        LEFT JOIN    modulos ON ( funciones.funcionModulo = modulos.moduloCodigo)        
        WHERE usuariosfunciones.usuarioFuncion= ? GROUP BY modulos.moduloId 
EOD;
  private static
   $sqlPermisosModulo = <<<EOD
        SELECT   funciones.* FROM   usuariosfunciones  
        LEFT JOIN     funciones ON (usuariosfunciones.usuarioFuncionAsignada = funciones.funcionId)   
        LEFT JOIN    modulos ON ( funciones.funcionModulo = modulos.moduloCodigo)   
        WHERE modulos.moduloId = ? AND usuariosfunciones.usuarioFuncion = ?    GROUP BY funciones.funcionOrden  
EOD;

  /**
   * 
   * @param ninguno
   * @name consulta select general
   * @abstract 
   * 
   */
  static public
   function todos() {
    $query = self::$sqlBase . " ";
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function todos_del_usuario($usuario_permiso) {
    self::$campos = array();
    $query = self::$sqlBase . " WHERE " . self::$nTabla . ".usuarioFuncion = ? ";
    array_push(self::$campos, $usuario_permiso);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function modulos_asignados($usuario_permiso) {
    self::$campos = array();
    $query = self::$sqlModulosUsuario . " ";
    array_push(self::$campos, $usuario_permiso);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function permisos_asignados_por_modulo($usuario_permiso, $id_modulo) {
    self::$campos = array();
    $query = self::$sqlPermisosModulo . "";
    array_push(self::$campos, $id_modulo);
    array_push(self::$campos, $usuario_permiso);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  /**
   * 
   * @param $id_tabla ; identificacion en la tabla del registro
   * @name consultad de registro general.
   * @abstract .
   * 
   */
  static public
   function datos($id_tabla) {
    self::$campos = array();
    $query = self::$sqlBase . " WHERE " . self::$nTabla . ".usuarioFuncionId = ? ";
    array_push(self::$campos, $id_tabla);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function
  asignar_permiso($permiso_asignado, $usuario_permiso) {
    $query = "INSERT INTO   " . self::$nTabla . " (  usuarioFuncionAsignada , usuarioFuncion, usuarioFuncionAsigna )  "
     . " VALUES ( ?, ?, ? ) ";
    $resultado = self::crearUltimoId($query, array($permiso_asignado, $usuario_permiso, Visitante::idUsuario()));
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function
  quitar_permisos($usuario_permiso) {
    self::$campos = array();
    $query = "DELETE FROM  " . self::$nTabla . "   WHERE " . self::$nTabla . ".usuarioFuncion = ? ; ";
    array_push(self::$campos, $usuario_permiso);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}