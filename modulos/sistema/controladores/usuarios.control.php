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

    print_r($_FILES);



    if(isset(self::$datos['nombreUsuario'])) {
      echo $resultNombre = Usuarios::cambiarNombreUsuario(Usuario::idUsuario(), self::$datos['nombreUsuario']);
    }

    if(isset(self::$datos['claveUsuario']) and ! empty(self::$datos['claveUsuario'])) {
      echo $resultClave = Usuarios::cambiarClave(Usuario::idUsuario(), self::$datos['claveUsuario']);
    }

    if(isset(self::$archivos['imagenFoto'])) {
      $nombreArchivo = "foto-" . uniqid() . "." . Archivos::nombre_extension(self::$archivos['imagenFoto']);
      $resultFirma = Archivos::mover_archivo_recibido(self::$archivos['imagenFoto'],
        PATH_ARCHIVOS . "usuarios" . DS . Usuario::idUsuario() . DS, $nombreArchivo);
      Personas::cambiarFoto(Usuario::idPersona(),
       "archivos" . WS . "usuarios" . WS . Usuario::idUsuario() . WS . $nombreArchivo);
    }

    if(isset(self::$archivos['imagenFirma'])) {
      $nombreArchivo = "firma-" . uniqid() . "." . Archivos::nombre_extension(self::$archivos['imagenFirma']);
      $resultFirma = Archivos::mover_archivo_recibido(self::$archivos['imagenFirma'],
        PATH_ARCHIVOS . "usuarios" . DS . Usuario::idUsuario() . DS, $nombreArchivo);
      Personas::cambiarFirma(Usuario::idPersona(),
       "archivos" . WS . "usuarios" . WS . Usuario::idUsuario() . WS . $nombreArchivo);
    }

    echo (Respuestas::JSON('EXITO',
     'ACTUALIZADO CORRECTAMENTE. <br /> Para que los cambios tengan efectos debes salir y entrar nuevamente.'));
  }

}