<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Usuario
 *
 * @author Puro Ingenio Samario
 */
Modelos::cargar('Datos' . DS . 'Sistema' . DS . 'Sesion');
class Usuario extends Modelos {
  
  
  public static function actualizarSesion($OBJ_USR) {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR'] = $OBJ_USR;
    }
    return "";
  }

  public static function fecha_hora_sistema() {
    $query = "SELECT CURRENT_TIMESTAMP AS FECHA_SISTEMA FROM DUAL;";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta[0]->FECHA_SISTEMA;
    }
    return 0;
  }

  public static function esta_logueado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return true;
    }
    return false;
  }

  public static function cerrar_sesion() {
    session_start();
    $_SESSION = array();
    session_unset();
    session_destroy();
  }

  public static function nombreUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->usuarioCorreo;
    }
    return "";
  }

  public static function dato($DATOS_USUARIO) {
    if(isset($_SESSION['OBJ_USR']->$DATOS_USUARIO)) {
      return $_SESSION['OBJ_USR']->$DATOS_USUARIO;
    } elseif(isset($_SESSION['SINAP_USUARIO_EMPRESA']->$DATOS_USUARIO)) {
      return $_SESSION['SINAP_USUARIO_EMPRESA']->$DATOS_USUARIO;
    }
    return false;
  }

  public static function mensajes_sistema($msn_txt = "") {
    if(!isset($_SESSION['mensajesSistema'])) {
      $_SESSION['mensajesSistema'] = "";
    }
    return $_SESSION['mensajesSistema'] .= $msn_txt;
  }

  public static function limpiar_mensajes_sistema() {
    if(!isset($_SESSION['mensajesSistema'])) {
      $_SESSION['mensajesSistema'] = "";
    }
    return $_SESSION['mensajesSistema'] = "";
  }

  public static function codigoSedeEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->sedeCodigo;
    }
    return "";
  }

  public static function sedeEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->sedeNombre;
    }
    return "";
  }

  public static function tipoEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->tipoempleadoTitulo;
    }
    return "";
  }

  public static function cargoEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->cargoEmpleadoTitulo;
    }
    return "";
  }

  public static function fechaInicioEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->empleadoInicia;
    }
    return "";
  }

  public static function fechaFinEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->empleadoTermina;
    }
    return "";
  }

  public static function nombreCompletoUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaNombres . " " . $_SESSION['OBJ_USR']->personaApellidos;
    }
    return "";
  }

  public static function tipoDeUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->cargoEmpleadoTitulo;
    }
    return "";
  }

  public static function nombresUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaNombres;
    }
    return "";
  }

  public static function apellidosUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaApellidos;
    }
    return "";
  }

  public static function avatarUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->usuarioAvatar;
    }
    return "";
  }

  public static function fotoPersona() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaFotoReferencia;
    }
    return "";
  }

  public static function edadUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return Fechas::edad($_SESSION['OBJ_USR']->personaFechaNacimiento) . " años";
    }
    return "";
  }

  public static function firmaEscaneadaUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaFirmaEscaneada;
    }
    return "";
  }

  public static function correoUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->usuarioCorreo;
    }
    return "";
  }

  public static function telefonoUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaTelefono;
    }
    return "";
  }

  public static function direccionUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaDireccion;
    }
    return "";
  }

  public static function provinciaUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->provinciaNombre;
    }
    return "";
  }

  public static function cantonUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->cantonNombre;
    }
    return "";
  }

  public static function observacionesUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaObservaciones;
    }
    return "";
  }

  public static function formacionEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->empleadoFormacion;
    }
    return "";
  }

  public static function salarioEmpleado() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->empleadoSalarioBase;
    }
    return "";
  }

  public static function vigenciaUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['VIGENCIA'];
    }
    return "";
  }

  public static function ultimaVisitaUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->usuarioUltimoIngreso;
    }
    return "";
  }

  public static function fechaRegistroUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->usuarioCreado;
    }
    return "";
  }

  public static function fechaActualizacionUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['FECHA_ACTUALIZACION'];
    }
    return "";
  }

  public static function informacionAdicionalUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['INFO_ADICIONAL'];
    }
    return "";
  }

  public static function numeroClienteUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['NUMERO_CLIENTE'];
    }
    return "";
  }

  public static function identificacionUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaIdentificacion;
    }
    return "";
  }

  public static function visitasUsuario() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['VISITAS'];
    }
    return "";
  }

  public static function idUsuario() {

    if(Consola::$activada) {
      return 0;
    }

    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->usuarioId;
    }
    return "";
  }

  public static function idPersona() {

    if(Consola::$activada) {
      return 0;
    }

    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->personaId;
    }
    return "";
  }

  public static function ipUsuario() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $ip;
  }

  public static function registrar_logs($datos) {
//
//        if ( $datos['accion'] == "estoy_trabajando") {
//            return NULL;
//        }

    if(Usuarios::idUsuario()) {
      Log::nuevo(
       Usuarios::idUsuario(), $datos['controlador'], $datos['accion'], json_encode($datos), ''
      );
    }
    Archivos::escribir_log(
     'logs' . Usuarios::idUsuario() . '.txt',
     date('Ymd H:i:s') . " - " . $datos['controlador'] . "=>" . $datos['accion'] . " - " . Usuarios::ipUsuario()
    );
  }

  public static function componentes() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->componentes;
    }
    return "";
  }

  /**
   * 
   * @param $id_componente Identificacion del Componente
   * @name todos los permisos del componente
   * @abstract obtiene todos los permisos asociados a un componente que se le hayan asignado al usuario
   * 
   */
  public static function permisosComponente($id_componente) {
    if(isset($_SESSION['OBJ_USR'])) {

      $permisos = array();
      foreach($_SESSION['OBJ_USR']->componentes as $Componente) {
        if($Componente->id_componente == $id_componente) {
          return $Componente->permisos;
        }
      }
    }
    return "";
  }

  public static function menu() {
    if(isset($_SESSION['OBJ_USR'])) {
      return $_SESSION['OBJ_USR']->modulos;
    }
    return "";
  }

}