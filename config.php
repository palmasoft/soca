<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
setlocale(LC_ALL, "es_ES@euro", "es_ES", "esp");
date_default_timezone_set('America/Bogota');

$db = "oneclass_soca2";
$user = "oneclass_usrsoca";
$pass = "#%;^b]B=x^9a";

require_once 'libs/main.php';
Libs::utilidades();

define('_PUROINGENIOSAMARIO', 1);
define('DS', DIRECTORY_SEPARATOR);
define('WS', '/');
define('PATH_BASE', dirname(__file__) . DS);
define('URL_BASE', Urls::servidor());

define('PATH_LOGS', PATH_BASE . 'logs' . DS);
define('PATH_PLANTILLAS', PATH_BASE . 'plantillas' . DS);
define('PATH_ARCHIVOS', PATH_BASE . 'archivos' . DS);
define('PATH_LIBS', PATH_BASE . 'libs' . DS);
define('PATH_COMPONENTES', PATH_BASE . 'modulos' . DS);
define('PATH_MODELOS', PATH_BASE . 'modelos' . DS);
define('EXT_MODELOS', '.modelo.php');
define('DIR_CONTROLADORES', 'controladores');
define('EXT_CONTROLADORES', '.control.php');
define('DIR_VISTAS', 'vistas');
define('EXT_VISTAS', '.vista.php');
define('DIR_ESTILOS', 'estilos');
define('EXT_ESTILOS', '.css');
define('DIR_SCRIPTS', 'funciones');
define('EXT_SCRIPTS', '.js');


define('URL_PLANTILLAS', URL_BASE . 'plantillas' . WS);
define('URL_ARCHIVOS', URL_BASE . 'archivos' . WS);
define('URL_LIBS', URL_BASE . 'libs' . WS);
define('URL_COMPONENTES', URL_BASE . 'componentes' . WS);

//CONEXION A LA BSE DE DATOS DEL ADMINISTRADOR
define('dbtype_basico', 'mysql');
define('dbhost_basico', 'localhost');
define('dbport_basico', '');
define('dbname_basico', $db);
define('dbuser_basico', $user);
define('dbpass_basico', $pass);

require_once 'libs/MainController.php';