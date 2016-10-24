<?php
/**
 * Clase base para la carga de todas las clases de lalibreria class
 *
 * @package Bases
 * @author  Juan Pablo Llinas Ramirez
 */
abstract class Base {
  protected static $datosScript = array();
  protected static $datos = array();
  protected static $archivos = array();
  protected $plantilla;
  protected $vista;
  protected $errores;
  protected $modelo;
  protected $controlador;
  protected $fechas;
  protected $correos;
  protected $formularios;
  protected $spdo;
  protected $spdo_base;

  function __construct() {
    if(count($_POST)) {
      foreach($_POST as $key => $value) {
        self::$datos[str_replace("-", "_", $key)] = $value;
      }
    }
    if(isset($GLOBALS['argv'])) {
      Consola::$activada = true;
      foreach($GLOBALS['argv'] as $key => $value) {
        self::$datosScript[str_replace("-", "_", $key)] = $value;
        switch($key) {
          case "1": $key = "componente";
            break;
          case "2": $key = "controlador";
            break;
          case "3": $key = "accion";
            break;
        }
        self::$datos[str_replace("-", "_", $key)] = $value;
      }
    }
    self::$archivos = array();
    if(count($_FILES)) {
      foreach($_FILES as $key => $value) {
        self::$archivos[str_replace("-", "_", $key)] = $value;
      }
    }
  }

}