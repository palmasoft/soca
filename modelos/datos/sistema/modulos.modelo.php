<?php
Modelos::cargar('sistema' . DS . 'Permisos');
Modelos::cargar('sistema' . DS . 'PermisosUsuarios');
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class Modulos extends Modelos {
  private static
   $id_modulo;
  private static
   $codigo_modulo;
  private static
   $icono_modulo = 'fa fa-dashboard';
  private static
   $nombre_modulo;
  private static
   $desc_modulo;
  private static
   $nTabla = "modulos";
  private static
   $sqlBase = "SELECT modulos.* FROM modulos ";
  private static
   $sqlDelUsuario = <<<sqlDelUsuario
      SELECT
          modulos.*
      FROM
          modulos
          INNER JOIN funciones 
              ON (modulos.moduloCodigo = funciones.funcionModulo)
          INNER JOIN usuariosfunciones 
              ON (funciones.funcionId = usuariosfunciones.usuarioFuncionAsignada)   
sqlDelUsuario;
  private static
   $sqlJoin = "";

  /**
   * 
   * @param ninguno
   * @name todos los modulos del sistema
   * @abstract ejecutar para traer todos los componenetes guardasdos en la base de datos
   * 
   */
  static public
   function todos() {
    $query = self::$sqlBase;
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  /**
   * 
   * @param ninguno
   * @name todos los modulos del sistema
   * @abstract ejecutar para traer todos los componenetes guardasdos en la base de datos
   * 
   */
  static public
   function DelUsuarioConPermisos($idUsuario) {
    $query = self::$sqlDelUsuario . "  "
     . "WHERE  usuariosfunciones.usuarioFuncion = " . $idUsuario . " "
     . "GROUP BY modulos.moduloId "; //. " ORDER BY id_modulo ASC";
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      foreach($resultado as $indice => $comp) {
        $resultado[$indice]->permisos = Permisos::todosDelUsuarioModulo($comp->moduloCodigo, $idUsuario);
      }
      return $resultado;
    }
    return NULL;
  }

  static public
   function todos_con_permisos() {
    $query = self::$sqlBase; //. " ORDER BY id_modulo ASC";
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      foreach($resultado as $indice => $comp) {
        $resultado[$indice]->permisos = Permisos::todos_del_modulo($comp->moduloCodigo);
      }
      return $resultado;
    }
    return NULL;
  }

  static public
   function asignados_con_permisos($idUsuario) {
    $resultado = PermisosUsuarios::modulos_asignados($idUsuario);
    if(count($resultado) > 0) {
      foreach($resultado as $indice => $comp) {
        $resultado[$indice]->permisos = PermisosUsuarios::permisos_asignados_por_modulo($idUsuario,
          $comp->moduloId);
      }
      return $resultado;
    }
    return NULL;
  }

  /**
   * 
   * @param codigo_modulo
   */
  public
   function por_codigo_modulo(varchar $codigo_modulo) {
    
  }

  /**
   * 
   * @param id_modulo
   */
  public
   function por_id_modulo(integer $id_modulo) {
    
  }

  /**
   * 
   * @param id_modulo
   */
  public
   function datos(integer $id_modulo) {
    
  }

  /**
   * 
   * @param newVal
   */
  public
   function setdesc_modulo(text $newVal) {
    
  }

  public
   function getdesc_modulo() {
    return desc_modulo;
  }

  /**
   * 
   * @param newVal
   */
  public
   function setnombre_modulo(varchar $newVal) {
    
  }

  public
   function getnombre_modulo() {
    return nombre_modulo;
  }

  /**
   * 
   * @param newVal
   */
  public
   function seticono_modulo(varchar $newVal) {
    
  }

  public
   function geticono_modulo() {
    return icono_modulo;
  }

  /**
   * 
   * @param newVal
   */
  public
   function setcodigo_modulo(varchar $newVal) {
    
  }

  public
   function getcodigo_modulo() {
    return codigo_modulo;
  }

  /**
   * 
   * @param newVal
   */
  public
   function setid_modulo(integer $newVal) {
    
  }

  public
   function getid_modulo() {
    return id_modulo;
  }

}