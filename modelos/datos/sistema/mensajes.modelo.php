<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class Mensajes {

  static function operacion($tipoMensaje, $mensaje) {

    $htmlMensaje = "";
    switch ($tipoMensaje) {
      case 'EXITO':
        $htmlMensaje = AlertasHTML5::exito($mensaje);
        break;
      case 'ALERTA':
        $htmlMensaje = AlertasHTML5::advertencia($mensaje);
        break;
      case 'INFO':
        $htmlMensaje = AlertasHTML5::informacion($mensaje);
        break;
      case 'ERROR':
        $htmlMensaje = AlertasHTML5::error($mensaje);
        break;
      default:
        break;
    }
    Config::set('mensajeOperacion', Config::get('mensajeOperacion')."". $htmlMensaje);
  }

  static function sistema(
  $aQuien, $mensaje, $titulo = 'MENSAJE DEL SISTEMA', $tipo = 'SISTEMA',
          $enviarCorreo = false) {
    Archivos::escribir_en_archivo(
            PATH_ARCHIVOS . "mensajes" . DS . $aQuien . ".msj",
            $tipo . ";" . $tipo . ";" . $mensaje . ";" . $aQuien . ";"
    );

    if ($enviarCorreo) {
      
    }
  }

  static function leer_del_usuario($aQuien) {
    $mensaje = Archivos::leer_linea_archivo(PATH_ARCHIVOS . "mensajes" . DS . $aQuien . ".msj");
    Archivos::borrar_linea_archivo(PATH_ARCHIVOS . "mensajes" . DS . $aQuien . ".msj");
    if (!empty($mensaje)) {
      return ( explode(";", $mensaje) );
    }
    return null;
  }

}
