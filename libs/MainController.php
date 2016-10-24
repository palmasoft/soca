<?php
/*
  El FrontController es el que recibe todas las peticiones,
  incluye algunos ficheros, busca el controlador y llama a la acci�n que corresponde.
 */
require 'libs/Plantillas.php';
require 'libs/Parametros.php';
class Soca2 {

  static function frontUI() {
    if(Visitante::esta_logueado()) {
      Plantillas::admin();
    } else {
      Plantillas::login();
    }
  }

  static function ejecutarAccion() {


    $controller = NULL;
    $_SESSION['INICIA_TAREA'] = date('Y-m-d h:i:s');


    if(!empty($_POST['modulo'])) {
      $nombreModulo = strtolower($_POST['modulo']);
    } elseif(!empty($_GET['modulo'])) {
      $nombreModulo = strtolower($_GET['modulo']);
    } elseif(!empty($GLOBALS['argv'][1])) {
      $nombreModulo = strtolower($GLOBALS['argv'][1]);
    } else {
      $nombreModulo = "sistema";
    }

    if(!empty($_POST['controlador'])) {
      $controlador = $_POST['controlador'];
    } elseif(!empty($_GET['controlador'])) {
      $controlador = $_GET['controlador'];
    } elseif(!empty($GLOBALS['argv'][2])) {
      $controlador = $GLOBALS['argv'][2];
    } else {
      $controlador = "sistema";
    }
    $nombreControlador = $controlador . "Controlador";


    if(!empty($_POST['accion'])) {
      $nombreAccion = $_POST['accion'];
    } elseif(!empty($_GET['accion'])) {
      $nombreAccion = $_GET['accion'];
    } elseif(!empty($GLOBALS['argv'][3])) {
      $nombreAccion = $GLOBALS['argv'][3];
    } else {
      $nombreAccion = "inicio";
    }

    $controllerPath = PATH_COMPONENTES . $nombreModulo . DS . 'controladores' . DS . $controlador . '.php';
    if(is_file($controllerPath)) {
      require_once $controllerPath;
    } else {
//      Errores::contenido_error(103);
      return false;
    }
    if(class_exists($nombreControlador)) {
      $controller = new $nombreControlador();
    } else {
//      Errores::contenido_error(201);
      return false;
    }

    if(is_callable(array($nombreControlador, $nombreAccion))) {
      $controller->$nombreAccion();
    } else {
//      Errores::contenido_error(202);
      return false;
    }
  }

}