<?php

Modelos::cargar("Sistema" . DS . "CargosEmpleados");

class Usuarios extends Modelos {

  private static
   $nTabla = "usuarios";
  private static
   $sqlBase = "SELECT usuarios.* FROM usuarios ";
  private static
   $sqlCompleta = <<<EOD
SELECT
    sedes.*
    , tiposempleado.*
    , cargosempleados.*
    , personas.*
    , tiposidentificacion.*
    , empleados.*
    , usuarios.*
FROM
    empleados
    INNER JOIN usuarios 
        ON (empleados.empleadoUsuario = usuarios.usuarioId)
    INNER JOIN cargosempleados 
        ON (empleados.empleadoCargo = cargosempleados.cargoEmpleadoId)
    INNER JOIN sedes 
        ON (empleados.empleadoSede = sedes.sedeId)
    INNER JOIN tiposempleado 
        ON (empleados.empleadoTipo = tiposempleado.tipoempleadoId)
    INNER JOIN personas 
        ON (empleados.empleadoDatosPersonales = personas.personaId)
    INNER JOIN tiposidentificacion 
        ON (personas.personaTipoIdentificacion = tiposidentificacion.tipoIdentificacionId) 
EOD;
  
  private static
   $sqlJoin = "";

  public static
   function datos($idUsuario) {
    self::$campos = array();
    $query = self::$sqlBase . " WHERE " . self::$nTabla . ".usuarioId = ? ";
    array_push(self::$campos, $idUsuario);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function datos_del_usuario($idUsuario) {
    self::$campos = array();
    $query = self::$sqlCompleta . self::$sqlJoin . " WHERE " . self::$nTabla . ".usuarioId = ? ";
    array_push(self::$campos, $idUsuario);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function datos_por_persona($idPersona) {
    self::$campos = array();
    $query = self::$sqlCompleta . self::$sqlJoin . " WHERE personas.personaId = ? ";
    array_push(self::$campos, $idPersona);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function datos_por_identificacion($tipoIdentificacion, $numeroIdentificacion) {
    self::$campos = array();
    $query = self::$sqlCompleta . self::$sqlJoin . " WHERE personas.personaTipoIdentificacion = ? AND personas.personaIdentificacion = ? ";
    array_push(self::$campos, $tipoIdentificacion);
    array_push(self::$campos, $numeroIdentificacion);
    $resultado = self::consulta($query, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function esCorrectoClaveCorreo($nick, $pass) {
    self::$campos = array();
    $sql = self::$sqlBase . " "
     . "WHERE ( "
     . "" . self::$nTabla . ".usuarioClave = md5( ? )   "
     . "AND "
     . "" . self::$nTabla . ".usuarioCorreo = ? AND " . self::$nTabla . ".usuarioEstado = 'ACTIVO' "
     . " ) ; ";
    array_push(self::$campos, $pass);
    array_push(self::$campos, $nick);
    $resultado = self::consulta($sql, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function esCorrectoClaveNombre($nick, $pass) {
    self::$campos = array();
    $sql = self::$sqlBase . " "
     . "WHERE ( "
     . "" . self::$nTabla . ".usuarioClave = md5( ? )   "
     . "AND "
     . "" . self::$nTabla . ".usuarioNombre = ? AND " . self::$nTabla . ".usuarioEstado = 'ACTIVO' "
     . " ) ; ";
    array_push(self::$campos, $pass);
    array_push(self::$campos, $nick);
    $resultado = self::consulta($sql, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function existeNombreUsuario($nick) {
    self::$campos = array();
    $sql = self::$sqlCompleta . " WHERE " . self::$nTabla . ".usuarioNombre = ? ";
    array_push(self::$campos, $nick);
    $resultado = self::consulta($sql, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function existeCorreoUsuario($email) {
    self::$campos = array();
    $sql = self::$sqlBase . " WHERE " . self::$nTabla . ".usuarioCorreo = ? ";
    array_push(self::$campos, $email);
    $resultado = self::consulta($sql, self::$campos);
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  public static
   function cambiar_avatar($idUsuario, $ruta_imagen) {
    self::$campos = array();
    $query = "UPDATE " . self::$nTabla . " SET fecha_modificacion = CURRENT_TIMESTAMP ,  url_avatar_usuario = ?   WHERE " . self::$nTabla . ".usuarioId = ? ; ";
    array_push(self::$campos, $ruta_imagen);
    array_push(self::$campos, $idUsuario);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function actualizar_fechavisita($idUsuario) {
    self::$campos = array();
    $query = "UPDATE " . self::$nTabla . " "
     . "SET usuarioUltimoIngreso = CURRENT_TIMESTAMP   "
     . "WHERE " . self::$nTabla . ".usuarioId = ? ; ";
    array_push(self::$campos, $idUsuario);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function actualizar_ultima_ip($idUsuario) {
    $query = "UPDATE " . self::$nTabla . "  "
     . "SET  usuarioUltimaIp = '" . self::ipUsuario() . "'  "
     . "WHERE " . self::$nTabla . ".usuarioId = ?;";
    self::$campos = array();
    array_push(self::$campos, $idUsuario);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function actualizar_ultima_ubicacion($idUsuario, $latitud, $longitud) {
    $query = "UPDATE " . self::$nTabla . "  "
     . "SET  usuarioUltimaUbicacionLatitud = ?, usuarioUltimaUbicacionLongitud = ?  "
     . "WHERE " . self::$nTabla . ".usuarioId = ?;";
    self::$campos = array();
    array_push(self::$campos, $latitud);
    array_push(self::$campos, $longitud);
    array_push(self::$campos, $idUsuario);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function ipUsuario() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $ip;
  }

  /*
   * 
   * 
   * 
   * 
   * 
   * 
   * 
   */

  public static
   function validar_datos_usuario($nick, $pass) {
    $query = " select * from " . self::$nTabla . " WHERE usuarioNombre = '" . $nick . "' ";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      $query = "select * from " . self::$nTabla . " WHERE usuarioNombre = '" . $nick . "' AND usuarioEstado = 'ACTIVO' ";
      $consulta = self::consulta($query);
      if(count($consulta) > 0) {
        $query = "select * FROM " . self::$nTabla . " WHERE ( usuarioClave = MD5( '" . $pass . "' ) AND usuarioNombre = '" . $nick . "');
";
        $consulta = self::consulta($query);
        if(count($consulta) > 0) {
          return "CORRECTO";
        } else {
          return "ERROR_CLAVE";
        }
      } else {
        return "ERROR_NOMBRE_INACTIVO";
      }
    } else {
      return "ERROR_NOMBRE";
    }
  }

  public static
   function esUsuarioCedula($cedula) {
    $query = self::$sqlBase . " WHERE ( "
     . "" . self::$nTabla . ".PASSWORD = AES_ENCRYPT('" . $pass . "', '" . self::$config->get("passEncript") . "') AND "
     . "" . self::$nTabla . ".NICK = '" . $nick . "' AND "
     . "" . self::$nTabla . ".ESTADO = 'ACTIVO' )";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) return $consulta[0];
    return 0;
  }

  public static
   function todos($Estado = 'ACTIVO') {
    $query = self::$sqlBase . " WHERE usuarioEstado = '" . $Estado . "'  ";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function todosActivos() {
    $query = self::$sqlCompleta . " WHERE usuarioEstado = 'ACTIVO'  ";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function todos_completo($Estado = 'ACTIVO') {
    $query = self::$sqlCompleta . "  ORDER BY personas.personaNombres  ";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function permisos($id_usuario) {
    $query = 'SELECT
    funciones_sistema.TITULO_MENU,
    permisos_usuario.*
    FROM
    permisos_usuario
    LEFT JOIN funciones_sistema 
        ON (permisos_usuario.ID_MENU = funciones_sistema.ID_MENU)
        WHERE permisos_usuario.ID_USUARIO = ' . $id_usuario . ' GROUP BY funciones_sistema.ID_MENU ORDER BY funciones_sistema.ORDEN ASC';
    $consulta = self::consulta($query);

    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function registrar_entrada($idUsuario, $idPersona = NULL) {
    $query = "
INSERT INTO " . self::$nTabla . "_log ( SESION_USUARIOLOG, TIPO_USUARIOLOG, USUARIO_USUARIOLOG, PERSONA_USUARIOLOG, IP_USUARIOLOG )
VALUES ( '" . session_id() . "', 'ENTRADA', " . $idUsuario . ", " . $idPersona . ", '" . self::ipUsuario() . "' )";
    return self::modificarRegistros($query);
  }

  public static
   function registrar_salida($idUsuario, $idPersona = NULL) {
    $query = "
INSERT INTO " . self::$nTabla . "_log ( SESION_USUARIOLOG, TIPO_USUARIOLOG, USUARIO_USUARIOLOG, PERSONA_USUARIOLOG, IP_USUARIOLOG )
VALUES ( '" . session_id() . "', 'SALIDA', " . $idUsuario . ", " . $idPersona . ", '" . self::ipUsuario() . "' )";
    return self::modificarRegistros($query);
  }

  public static
   function insertar($usuarioPersona, $usuarioCargo, $usuarioTipo, $usuarioNombre, $usuarioClave, $usuarioCorreo,
                     $usuarioTelefono = NULL, $usuarioAvatar = NULL) {
    $query = "INSERT INTO usuarios ( "
     . "usuarioPersona , usuarioCargo , usuarioTipo , usuarioNombre , usuarioClave , usuarioCorreo , usuarioTelefono , "
     . "usuarioAvatar , usuarioCreo  ) VALUES ( ? , ? , ? , ? , md5( ? ) , ? , ? , ?, ? ) ;";
    $resultado = self::crearUltimoId(
      $query,
      array($usuarioPersona, $usuarioCargo, $usuarioTipo, $usuarioNombre, $usuarioClave, $usuarioCorreo,
      $usuarioTelefono, $usuarioAvatar, Visitante::idUsuario())
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function actualizar($usuarioId, $usuarioPersona, $usuarioCargo, $usuarioTipo, $usuarioNombre, $usuarioCorreo,
                       $usuarioTelefono = NULL, $usuarioAvatar = NULL) {
    $query = "UPDATE usuarios SET usuarioPersona = ?  , usuarioCargo = ?  , usuarioTipo = ?  , usuarioNombre = ?  , usuarioCorreo = ?  , usuarioTelefono = ? , usuarioAvatar = ? WHERE usuarioId = ?;";
    $resultado = self::modificarRegistros(
      $query,
      array($usuarioPersona, $usuarioCargo, $usuarioTipo, $usuarioNombre, $usuarioCorreo,
      $usuarioTelefono, $usuarioAvatar, $usuarioId)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function actualizarSinAvatar($usuarioId, $usuarioPersona, $usuarioCargo, $usuarioTipo, $usuarioNombre,
                                $usuarioCorreo, $usuarioTelefono = NULL) {
    $query = "UPDATE usuarios SET usuarioPersona = ?  , usuarioCargo = ?  , usuarioTipo = ?  , usuarioNombre = ?  , usuarioCorreo = ?  , usuarioTelefono = ? WHERE usuarioId = ?;";
    $resultado = self::modificarRegistros(
      $query,
      array($usuarioPersona, $usuarioCargo, $usuarioTipo, $usuarioNombre, $usuarioCorreo,
      $usuarioTelefono, $usuarioId)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function cambiarClave($usuarioId, $usuarioClave) {
    $query = "UPDATE usuarios SET usuarioClave = md5( ? )  WHERE usuarioId = ?;";
    $resultado = self::modificarRegistros(
      $query, array($usuarioClave, $usuarioId)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function nuevoSinFoto($NICK, $PASSWORD, $EMAIL) {
    $config = Config::singleton();
    $query = "INSERT INTO " . self::$nTabla . "(NICK, PASSWORD, EMAIL )"
     . "VALUES ('$NICK', AES_ENCRYPT('" . $PASSWORD . "', '" . $config->get("passEncript") . "'), '$EMAIL' )";
    return self::crear_ultimo_id($query);
  }

  public static
   function editarSinFoto($ID_USUARIO, $NICK, $PASSWORD, $EMAIL) {
    $config = Config::singleton();
    $query = "
UPDATE " . self::$nTabla . "
SET
NICK = '$NICK',
 PASSWORD = AES_ENCRYPT('" . $PASSWORD . "', '" . $config->get("passEncript") . "'),
 EMAIL = '$EMAIL'
WHERE ID_USUARIO = $ID_USUARIO ";
    return self::modificarRegistros($query);
  }

  public static
   function insertarPermisos($ID_USUARIO, $ID_MENU) {
    $query = "
INSERT INTO permisos_usuario
( ID_USUARIO,
 ID_MENU)
VALUES (
$ID_USUARIO,
 $ID_MENU)";

    return self::crear_ultimo_id($query);
  }

  public static
   function eliminarPermisos($ID_USUARIO) {
    $query = "DELETE
FROM permisos_usuario
WHERE ID_USUARIO = '$ID_USUARIO'";
    return self::modificarRegistros($query);
  }

  function listado() {
//realizamos la consulta de todos los items
    return self::consulta('SELECT * FROM ".self::$nTabla."');
  }

  function getNombreUsuario($id) {
    $query = 'SELECT NOMBRE FROM ".self::$nTabla." WHERE ID_USUARIO="' . $id . '"';
    $consulta = self::consulta($query);
    return $consulta[0]->NOMBRE;
  }

  function getNickUsuario($id) {
    $query = 'SELECT NICK FROM ".self::$nTabla." WHERE ID_USUARIO="' . $id . '"';
    $consulta = self::consulta($query);
    return $consulta[0]->NICK;
  }

  function obtenerContrasenaNick($nick) {
    $config = Config::singleton();
    $query = "
SELECT AES_DECRYPT(
(SELECT " . self::$nTabla . ".PASSWORD FROM " . self::$nTabla . " WHERE NICK = '" . $nick . "' ),
 '" . $config->get("passEncript") . "'
) AS decoded";
    $consulta = self::consulta($query);
    return $consulta[0]->decoded;
  }

  function obtenerContrasenaId($id) {
    $config = Config::singleton();
    $query = "
SELECT AES_DECRYPT(
(SELECT " . self::$nTabla . ".PASSWORD FROM " . self::$nTabla . " WHERE ID_USUARIO = '" . $id . "' ),
 '" . $config->get("passEncript") . "'
) AS decoded";
    $consulta = self::consulta($query);
    return $consulta[0]->decoded;
  }

  function getUsuarioTodoModulos() {
    $query = 'SELECT *
                  FROM ".self::$nTabla."modulos LEFT JOIN tbl_modulos
                  ON  ".self::$nTabla."modulos.pk_fk_k_idm = tbl_modulos.pk_k_id 
				  ORDER BY tbl_modulos.pk_k_id';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function getUsuarioModulos($id) {
    $query = 'SELECT *
                  FROM ".self::$nTabla."modulos LEFT JOIN tbl_modulos
                  ON ".self::$nTabla."modulos.pk_fk_k_idu =' . $id . ' AND ".self::$nTabla."modulos.pk_fk_k_idm = tbl_modulos.pk_k_id WHERE ".self::$nTabla."modulos.pk_fk_k_idu =' . $id . ' ORDER BY tbl_modulos.pk_k_id';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function getUsuarioMenSup($id) {
    $query = 'SELECT *
                  FROM ".self::$nTabla."menus LEFT JOIN tbl_menus
                  ON ".self::$nTabla."menus.pk_fk_k_idu =' . $id . ' AND ".self::$nTabla."menus.pk_fk_k_idmen = tbl_menus.pk_k_id WHERE ".self::$nTabla."menus.pk_fk_k_idu =' . $id . ' AND ISNULL(tbl_menus.k_idpadre)';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function getUsuarioTodoMenuSup() {
    $query = 'SELECT * FROM tbl_menus WHERE ISNULL(k_idpadre) ORDER BY tbl_menus.pk_k_id ASC ';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function getUsuarioAllMenParent($id) {
    $query = 'SELECT *
                  FROM ".self::$nTabla."menus LEFT JOIN tbl_menus
                  ON ".self::$nTabla."menus.pk_fk_k_idu =' . $id . ' AND ".self::$nTabla."menus.pk_fk_k_idmen = tbl_menus.pk_k_id 
				  WHERE ".self::$nTabla."menus.pk_fk_k_idu =' . $id . ' AND tbl_menus.s_accionmenu IS NOT NULL 
				  ORDER BY tbl_menus.pk_k_id ASC';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function getAllUsuarios() {
    $query = 'SELECT * FROM ".self::$nTabla."';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function getUsuarioAllSubMen($id) {
    $query = 'SELECT *
                  FROM ".self::$nTabla."menus LEFT JOIN tbl_menus
                  ON ".self::$nTabla."menus.pk_fk_k_idu =' . $id . ' AND ".self::$nTabla."menus.pk_fk_k_idmen = tbl_menus.pk_k_id 
				  WHERE ".self::$nTabla."menus.pk_fk_k_idu =' . $id . ' AND tbl_menus.k_idpadre IS NOT NULL 
				  ORDER BY tbl_menus.pk_k_id ASC';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function getNombresUsuario() {
    $query = 'SELECT ID_USUARIO, NOMBRE FROM ".self::$nTabla."';
    $consulta = self::consulta($query);
    return $consulta;
  }

  function nuevo($nombre, $nick, $pass, $email, $tel, $foto, $estado) {
    $config = Config::singleton();
    $query = "INSERT INTO " . self::$nTabla . " ( ID_USUARIO, NOMBRE, NICK, PASSWORD, EMAIL, TELEFONO, URL_FOTO, ESTADO ) VALUES(NULL, '"
     . $nombre . "', '" . $nick . "', AES_ENCRYPT('" . $pass . "', '" . $config->get("passEncript") . "'), '" . $email . "', '" . $tel . "', '" . $foto . "', '" . $estado . "' )";
    return self::$crear_ultimo_id($query);
  }

  function editar($id, $nombre, $nick, $pass, $email, $tel, $foto, $estado) {
    $config = Config::singleton();
    $query = "UPDATE " . self::$nTabla . " SET NOMBRE = '"
     . $nombre . "', NICK = '" . $nick . "', PASSWORD = (AES_ENCRYPT('" . $pass . "', '" . $config->get("passEncript") . "')), EMAIL = '" . $email . "', TELEFONO = '" . $tel . "', URL_FOTO = '" . $foto . "', ESTADO = '" . $estado . "' WHERE ID_USUARIO = " . $id . " LIMIT 1";
    return self::$modificarRegistros($query);
  }

  function borrar($id) {
    $query = "DELETE FROM " . self::$nTabla . " WHERE ID_USUARIO = " . $id;
    self::$modificarRegistros($query);
  }

  function desactivar($usuarioId) {
    $query = "update " . self::$nTabla . " set usuarioEstado = 'DESACTIVO' where usuarioId = ? ";
    $resultado = self::modificarRegistros(
      $query, array($usuarioId)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  function activar($usuarioId) {
    $query = "update " . self::$nTabla . " set usuarioEstado = 'ACTIVO' where usuarioId = ?";
    $resultado = self::modificarRegistros(
      $query, array($usuarioId)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}
