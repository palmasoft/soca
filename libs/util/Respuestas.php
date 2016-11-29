<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Respuestas
 *
 * @author Puro Ingenio Samario
 */
class Respuestas {

  public static
   function JSON($tipoRespuesta, $mensajeRespuesta) {
    return '{ '
     . '"TIPO_RESPUESTA": ' . json_encode($tipoRespuesta) . ','
     . '"MENSAJE_RESPUESTA": ' . json_encode($mensajeRespuesta) . ''
     . ' }';
  }

  public static
   function HTML($tipoRespuesta, $mensajeRespuesta) {
    if($tipoRespuesta == 'ERROR') {
      return '' . $tipoRespuesta . '@pis_ ' . Errores::texto_error($mensajeRespuesta) . '';
    } else {
      return $tipoRespuesta . '@pis_ ' . ($mensajeRespuesta) . '';
    }
  }

}