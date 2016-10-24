<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Textos
 *
 * @author Toshiba
 */
class Textos {

  static
   function paraCorreos($texto) {
    return utf8_decode($texto);
  }

  /**
   * @param String $texto Description
   * @name $limpiarTexto
   */
  static
   function limpiar($string) {

    $string = trim($string);

    $string = str_replace(
     array('"', '\''), array('', ''), $string
    );

    $string = str_replace(
     array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string
    );

    $string = str_replace(
     array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
    );

    $string = str_replace(
     array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
    );

    $string = str_replace(
     array('ó', 'ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
    );

    $string = str_replace(
     array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
    );

    $string = str_replace(
     array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
     array("\\", "¨", "º", "~",
     "#", "@", "|", "!", "\"",
     "·", "$", "%", "&", "/",
     "(", ")", "?", "'", "¡",
     "¿", "[", "^", "`", "]",
     "+", "}", "{", "¨", "´",
     ">", "< ", ";", ",", ":",
     "."), '', $string
    );

    $string = str_replace(array("- ", "-", " "), "_", $string);
    $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
    $string = strtolower($string);
    return $string;
  }

  static
   function quitar_comillas($string) {

    $string = trim($string);

    $string = str_replace(
     array('"', '\''), array('', ''), $string
    );

    return $string;
  }

  /**
   * 
   * @param Strin $nombre
   * @abstract Regresa el nombre partido en NOMBRE_1, NOMBRE_2, APELLIDO_1, APELLIDO_2 dentro de un arreglo de 4 posiciones.
   * @return array
   */
  static public
   function separar_nombre($nombre) {
    $nombreSeparado = array();
    $nombre = self::evaluar_nombres_apellidos($nombre);
    $partes = explode(" ", $nombre);
    switch(count($partes)) {
      case 1:
        array_push($nombreSeparado, NULL);
        array_push($nombreSeparado, NULL);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, NULL);
        break;
      case 2:
        array_push($nombreSeparado, $partes[1]);
        array_push($nombreSeparado, NULL);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, NULL);
        break;
      case 3:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado, NULL);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);
        break;
      case 4:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado, $partes[3]);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);
        break;
      case 5:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado, $partes[3] . " " . $partes[4]);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);
        break;
      case 6:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado, $partes[3] . " " . $partes[4] . " " . $partes[5]);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);
        break;
      case 7:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado, $partes[3] . " " . $partes[4] . " " . $partes[5] . " " . $partes[6]);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);
        break;
      case 8:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado,
                   $partes[3] . " " . $partes[4] . " " . $partes[5] . " " . $partes[6] . " " . $partes[7]);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);
        break;
      case 9:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado,
                   $partes[3] . " " . $partes[4] . " " . $partes[5] . " " . $partes[6] . " " . $partes[7] . " " . $partes[8]);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);
        break;
      case 10:
      default:
        array_push($nombreSeparado, $partes[2]);
        array_push($nombreSeparado,
                   $partes[3] . " " . $partes[4] . " " . $partes[5] . " " . $partes[6] . " " . $partes[7] . " " . $partes[8] . " " . $partes[9]);
        array_push($nombreSeparado, $partes[0]);
        array_push($nombreSeparado, $partes[1]);

        break;
    }
    return $nombreSeparado;
  }

  /**
   * 
   * @param String $texto     
   * @return String
   * @abstract evalua la cadena enviada y agrupa los apellidos que tenga de, del, de la, 
   * @name $evaluar_nombre
   * 
   */
  static public
   function evaluar_nombres_apellidos($nombreCompleto) {
    $str = $nombreCompleto;
    if(self::apellidos_variables($nombreCompleto)) {
      $str = self::transformar_apellidos_variables($nombreCompleto);
    }
    return $str;
  }

  static public
   function apellidos_variables($nombresYapellidos) {
    $cumpleExpresion = false;
    foreach(self::$patronApellidos as $patron) {
      if(preg_match($patron['gramatica'], $nombresYapellidos)) {
        $cumpleExpresion = true;
      }
    }
    return $cumpleExpresion;
  }

  static public
   function transformar_apellidos_variables($nombresYapellidos) {

    $str = $nombresYapellidos;
    foreach(self::$patronApellidos as $patron) {
      if(preg_match($patron['gramatica'], $str)) {
        $str = preg_replace(
         $patron['gramatica'], $patron['remplazo'], $str
        );
      }
    }


    return $str;
  }

  public static
   function traducir($texto) {
    return $texto;
  }

  public static
   function ceros_izquierda($texto, $largo = 2) {
    return str_pad($texto, $largo, "0", STR_PAD_LEFT);
  }

  public static
   function ceros_derecha($texto, $largo = 2) {
    return str_pad($texto, $largo, "0", STR_PAD_RIGHT);
  }

  public static
   function ceros_ambos_lados($texto, $largo = 2) {
    return str_pad($texto, $largo, "0", STR_PAD_BOTH);
  }

  static public
   function quitarEspaciosExtremos($param) {
    return rtrim(ltrim($param));
  }

  static public
   function quitarEspaciosEnBlanco($texto) {
    return str_replace(" ", "", $texto);
  }

  static public
   function quitar_ceros_izquierda($texto) {
    return (string) (floatval($texto));
  }

  static public
   function quitar_ceros_derecha($texto) {
    return (string) (rtrim($texto, '0'));
  }

  static
   $patronApellidos = array(
   array(
    'gramatica' => '/\sde\sla\s/',
    'remplazo' => ' dela'
   ),
   array(
    'gramatica' => '/de\sla\s/',
    'remplazo' => 'dela',
   ),
   array(
    'gramatica' => '/\sde\s/',
    'remplazo' => ' de'
   ),
   array(
    'gramatica' => '/\sdel\s/',
    'remplazo' => ' del'
   ),
   array(
    'gramatica' => '/\sDE\sLOS\s/',
    'remplazo' => ' DELOS'
   ),
   array(
    'gramatica' => '/\sDELOS\s/',
    'remplazo' => ' DELOS'
   ),
   array(
    'gramatica' => '/\sDE\sLAS\s/',
    'remplazo' => ' DELAS'
   ),
   array(
    'gramatica' => '/\sDELAS\s/',
    'remplazo' => ' DELAS'
   ),
   array(
    'gramatica' => '/\sDE\sLA\s/',
    'remplazo' => ' DELA'
   ),
   array(
    'gramatica' => '/DE\sLA\s/',
    'remplazo' => 'DELA'
   ),
   array(
    'gramatica' => '/\sDEL\s/',
    'remplazo' => ' DEL'
   ),
   array(
    'gramatica' => '/\sDE\s/',
    'remplazo' => ' DE'
   ),
   array(
    'gramatica' => '/DE\s/',
    'remplazo' => 'DE'
   )
  );
  static
   $apellidosExtranos = array(
   array(
    "apellido" => 'FERNANDEZ DE CASTRO',
    "remplazo" => 'FERNANDEZDECASTRO'
   ),
   array(
    "apellido" => 'FERNANDEZ DECASTRO',
    "remplazo" => 'FERNANDEZDECASTRO'
   ),
   array(
    "apellido" => 'DIAZ GRANADOS',
    "remplazo" => 'DIAZGRANADOS '
   ),
   array(
    "apellido" => 'GUTIERREZ DEPINERES',
    "remplazo" => 'GUTIERREZDEPIÑERES'
   ),
   array(
    "apellido" => 'GUTIERREZ DE PINERES',
    "remplazo" => 'GUTIERREZDEPIÑERES'
   ),
   array(
    "apellido" => 'GUTIERREZ DEPIÑERES',
    "remplazo" => 'GUTIERREZDEPIÑERES'
   ),
   array(
    "apellido" => 'GUTIERREZ DE PIÑERES',
    "remplazo" => 'GUTIERREZDEPIÑERES'
   )
  );

}
