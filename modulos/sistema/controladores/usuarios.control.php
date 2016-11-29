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
Modelos::cargar("Datos" . DS . "Directorio" . DS . "Personas");
class usuariosControlador extends Controladores {

  function mostrarPerfil() {
    Vistas::mostrar('perfilUsuario');
  }

  function actualizarDatosUsuarios() {

    if(isset(self::$datos['nombreUsuario'])) {
      $resultNombre = Usuarios::cambiarNombreUsuario(Usuario::idUsuario(), self::$datos['nombreUsuario']);
    }

    if(isset(self::$datos['claveUsuario']) and ! empty(self::$datos['claveUsuario'])) {
      $resultClave = Usuarios::cambiarClave(Usuario::idUsuario(), self::$datos['claveUsuario']);
    }

    if(isset(self::$archivos['imagenFoto'])and self::$archivos['imagenFoto']['error'] == 0) {
      $nombreArchivo = "foto-" . uniqid() . "." . Archivos::nombre_extension(self::$archivos['imagenFoto']);
      $resultFoto = Archivos::mover_archivo_recibido(self::$archivos['imagenFoto'],
        PATH_ARCHIVOS . "usuarios" . DS . Usuario::idUsuario() . DS, $nombreArchivo);
      Personas::cambiarFoto(Usuario::idPersona(),
       "archivos" . WS . "usuarios" . WS . Usuario::idUsuario() . WS . $nombreArchivo);
    }

    if(isset(self::$archivos['imagenFirma']) and self::$archivos['imagenFirma']['error'] == 0) {
      $nombreArchivo = "firma-" . uniqid() . "." . Archivos::nombre_extension(self::$archivos['imagenFirma']);
      $resultFirma = Archivos::mover_archivo_recibido(self::$archivos['imagenFirma'],
        PATH_ARCHIVOS . "usuarios" . DS . Usuario::idUsuario() . DS, $nombreArchivo);
      Personas::cambiarFirma(Usuario::idPersona(),
       "archivos" . WS . "usuarios" . WS . Usuario::idUsuario() . WS . $nombreArchivo);
    }

    Usuario::actualizarSesion(Usuarios::datos_del_usuario(Usuario::idUsuario()));
    echo Respuestas::JSON('EXITO',
     AlertasHTML5::exito(
      'ACTUALIZADO CORRECTAMENTE. <br /> Para que los cambios tengan efectos debes salir y entrar nuevamente.'
     )
    );
  }

}