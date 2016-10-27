<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of enBlanco
 *
 * @author Toshiba
 */
Modelos::cargar("Datos" . DS . "Sistema" . DS . "Usuarios");
Modelos::cargar("Datos" . DS . "Sistema" . DS . "Sesion");
Modelos::cargar("Datos" . DS . "Sistema" . DS . "Modulos");
Modelos::cargar("Datos" . DS . "Sistema" . DS . "Permisos");
class sesionControlador extends Controladores {

  function validarUsuario() {
    $iniciar = false;
    self::$datos['nick'] = self::$datos['txt_correo_usuario'];
    self::$datos['pass'] = self::$datos['txt_clave_usuario'];

    $Usr = Usuarios::existeCorreoUsuario(self::$datos['nick']);
    if(!is_null($Usr)) {
      $iniciar = $this->validarPorCorreo($Usr);
    } else {
      $Usr = Usuarios::existeNombreUsuario(self::$datos['nick']);
      if(!is_null($Usr)) {
        $iniciar = $this->validarPorNombre($Usr);
      } else {
        echo Respuestas::JSON(
         'ERROR', (('El Usuario <strong>NO EXISTE</strong> en el sistema.'))
        );
      }
    }

    if($iniciar) {
      Consola::imprimir("iniciando sesion.....\n\r");
      $User = Usuarios::datos_del_usuario($Usr->usuarioId);
      if($Usr->usuarioId == 0) {
        $User->modulos = Modulos::todos_con_permisos();
      } else {
        $rModulos = Modulos::DelUsuarioConPermisos($Usr->usuarioId);
        $User->modulos = is_null($rModulos) ? array() : $rModulos;
      }
      Sesion::set('OBJ_USR', $User);
      Usuarios::actualizar_fechavisita($User->usuarioId);
      Usuarios::actualizar_ultima_ip($User->usuarioId);
      echo Respuestas::JSON('EXITO', 'CORRECTO');
    }
  }

  function validarPorCorreo($Usr) {
    if(!is_null($Usr)) {
      if($Usr->usuarioEstado == "ACTIVO") {
        $Usr = Usuarios::esCorrectoClaveCorreo(self::$datos['nick'], self::$datos['pass']);
        if(!is_null($Usr)) {
          return true;
        } else {
          echo Respuestas::JSON('ERROR', (('El Usuario y la Clave <strong>NO COINCIDEN</strong>.')));
        }
      } else {
        echo Respuestas::JSON('ERROR', (('EL usuario <strong>NO ESTA ACTIVO</strong>.')));
      }
    }
    return false;
  }

  function validarPorNombre($Usr) {
    if(!is_null($Usr)) {
      if($Usr->usuarioEstado == "ACTIVO") {
        $Usr = Usuarios::esCorrectoClaveNombre(self::$datos['nick'], self::$datos['pass']);
        if(!is_null($Usr)) {
          Config::set('SINAP_USR', Usuarios::datos_del_usuario($Usr->usuarioId));
          return true;
        } else {
          echo Respuestas::JSON('ERROR', (('El Usuario y la Clave <strong>NO COINCIDEN</strong>.')));
        }
      } else {
        echo Respuestas::JSON('ERROR', (('EL Usuario <strong>NO ESTA ACTIVO</strong>.')));
      }
    }
    return false;
  }

  function salir() {
    echo Respuestas::HTML(
     "EXITO",
     "<div class=\"text-center\" >Se ha CERRADO correctamente tu sesion de trabajo. <br /> <i class=\"fa fa-refresh fa-spin\" style=\"font-size: 200%;\" ></i> <br />Espera mientras cerramos el sistema.</div>"
    );
    Usuario::cerrar_sesion();
  }

  function estaActivaSesion() {
    if(isset($_SESSION['SINAP_USR'])) {
      echo json_encode(array("respuesta" => $_SESSION['SINAP_USR']->usuarioNombre));
    }
  }

  function registrarUltimaUbicacion() {
    Usuarios::actualizar_ultima_ubicacion(Visitante::idUsuario(), self::$datos['latitud'], self::$datos['longitud']);
  }

}