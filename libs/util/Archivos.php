<?php
class Archivos {

  static
   function conteo_archivo($dirArchivo) {
    $archivo = fopen($dirArchivo, "r");
    $conteo['num_lineas'] = 0;
    $conteo['caracteres'] = 0;
    while(!feof($archivo)) {
      if($linea = fgets($archivo)) {
        $conteo['num_lineas'] ++;
        $conteo['caracteres'] += strlen($linea);
      }
    }
    fclose($archivo);
    return $conteo;
  }

  public static
   function nombre_extension($archivo) {
    return $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
  }

  static public
   function limpiarCaracteresEspeciales($string) {
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
    return $string;
  }

  static public
   function leer_archivo($archivo) {
    if(file_exists($archivo)) {
      return file_get_contents($archivo);
    }
    return "";
  }

  static public
   function leer_linea_archivo($archivo, $linea = 0) {
    $leida = "";
    $numLinea = 0;
    if(file_exists($archivo)) {
      $file = fopen($archivo, "r");
      while(!feof($file)) {
        $lineaLeida = fgets($file);
        if($numLinea == $linea) {
          $leida = $lineaLeida;
          break;
        }
        $numLinea++;
      }
      fclose($file);
    }
    return $leida;
  }

  static public
   function borrar_linea_archivo($archivo, $linea = 0) {
    $leidas = array();
    $numLinea = 0;
    if(file_exists($archivo)) {
      $file = fopen($archivo, "r");
      while(!feof($file)) {
        $lineaLeida = fgets($file);
        if($numLinea != $linea) {
          array_push($leidas, $lineaLeida);
          break;
        }
        $numLinea++;
      }
      fclose($file);
    }
    return file_put_contents($archivo, $leidas);
  }

  static public
   function leer_archivo_plano_separado_por_linea($archivo, $separador = ";") {

    $arreglo = array();
    if(file_exists($archivo)) {
      $file = fopen($archivo, "r");
      $numLinea = 0;
      while(!feof($file)) {
        $linea = fgets($file);
        $datos = explode($separador, $linea);
        if(count($datos)) {
          $linea = array();
          foreach($datos as $kndex => $valor) {
            array_push($linea, utf8_encode($valor));
          }
          array_push($arreglo, $linea);
          $numLinea++;
        }
      }
      fclose($file);
      return $arreglo;
    }
    return NULL;
  }

  static public
   function leer_archivo_plano_separado_por_linea_encabezado($archivo, $separador = ";") {

    $arregloEncabezados = array();
    $arregloObjetos = array();
    if(file_exists($archivo)) {
      $file = fopen($archivo, "r");
      $numLinea = 0;
      while(!feof($file)) {
        $linea = fgets($file);
        $datos = explode($separador, $linea);
        if(count($datos)) {
          $linea = new stdClass();
          foreach($datos as $kndex => $valor) {
            if($numLinea == 0) {
              array_push($arregloEncabezados, Urls::limpiar_url(utf8_encode($valor)));
              continue;
            }
            if(isset($arregloEncabezados[$kndex])) {
              $nombreCampo = $arregloEncabezados[$kndex];
              $linea->$nombreCampo = utf8_encode($valor);
            }
          }
          array_push($arregloObjetos, $linea);
          $numLinea++;
        }
      }
      fclose($file);
      return $arregloObjetos;
    }
    return NULL;
  }

  static public
   function leer_archivo_plano_separado($archivo, $separador = ";") {
    $datosArchivo = array();
    if(file_exists($archivo)) {
      $lineas = file($archivo);
      foreach($lineas as $linea_num => $linea) {
        $datos = explode($separador, $linea);
        array_push($datosArchivo, $datos);
      }
      return $datosArchivo;
    }
    return NULL;
  }

  static public
   function leer_archivo_tabulado($archivo) {
    $datosArchivo = array();
    if(file_exists($archivo)) {
      $lineas = file($archivo);
      foreach($lineas as $linea_num => $linea) {
        $datos = explode('\t', $linea);
        array_push($datosArchivo, $datos);
      }
      return $datosArchivo;
    }
    return NULL;
  }

  static public
   function escribir_en_archivo($archivo, $texto) {
    $file = fopen($archivo, "a");
    fwrite($file, "" . $texto . "" . PHP_EOL);
    fclose($file);
  }

  static public
   function escribir_log($archivo, $texto) {

    if(!file_exists(PATH_LOGS . $archivo)) {
      $file = fopen(PATH_LOGS . $archivo, "c+");
//            fwrite($file, $texto. "; " .Usuarios::mensajes_sistema() . PHP_EOL );
      fwrite($file, $texto . "; " . PHP_EOL);
      fclose($file);
    } else {
      $file = fopen(PATH_LOGS . $archivo, "r+");
      $contenido = fread($file, intval(filesize(PATH_LOGS . $archivo)));
      rewind($file);
//            fwrite($file, $texto . "; " . Usuarios::mensajes_sistema() . PHP_EOL. $contenido  );
      fwrite($file, $texto . "; " . PHP_EOL . $contenido);
      fclose($file);
    }
  }

  public static
   function probar_crear_directorio($ruta) {   
    $ok = TRUE;
    $carpetas = explode(DS, $ruta);
    $rActual = "";
    foreach($carpetas as $carpeta) {
      $rActual .= $carpeta . DS;
      if(!is_dir($rActual)) {
        if(mkdir($rActual, 0777)) {
          $ok = FALSE;
        }
      }
    }
    return $ok;
  }

  public static
   function listar_archivos_directorio($rutaDir, $ext = null) {

    $listado = array();
    if(is_dir($rutaDir)) {

      if($dh = opendir($rutaDir)) {
        while(($file = readdir($dh)) !== false) {
          if(!is_dir($rutaDir . $file) && $file != "." && $file != "..") {
            if(is_null($ext)) {
              $listado[] = $file;
            } else {
              $partesFile = pathinfo($file);
              if($partesFile['extension'] == $ext) {
                $listado[] = $file;
              }
            }
          }
        }
        closedir($dh);
      }
    } else {
      return null;
    }
    return $listado;
  }

  public static
   function mover_archivo($viejaUbicacion, $nuevaUbicacion, $nombreArchivo = '') {
//    echo "       ".$viejaUbicacion."     --       ". $nuevaUbicacion."               ";
    if(!rename($viejaUbicacion, $nuevaUbicacion)) {
      return false;
    }
    return true;
  }

  public static
   function mover_archivo_recibido($archivo, $rutaCarpeta, $nombreArchivo = '') {
    $dondeGuardar = $rutaCarpeta;
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      if(($archivo["type"] != "application/exe") /* && ($archivo["size"] < 8000000) */) {
        $file = ( empty($nombreArchivo) ? Archivos::limpiarCaracteresEspeciales($archivo['name']) : $nombreArchivo );
        self::probar_crear_directorio($dondeGuardar);
        if($file && move_uploaded_file($archivo ['tmp_name'], $dondeGuardar . $file)) {
          return TRUE;
        } else {
          $error = "";
          switch($archivo['error']) {
            case UPLOAD_ERR_OK:
              break;
            case UPLOAD_ERR_NO_FILE:
              $error = ('No se ha enviado archivo.');
              break;
            case UPLOAD_ERR_PARTIAL:
              $error = ('El archivo subido fue sólo parcialmente cargado.');
              break;
            case UPLOAD_ERR_NO_TMP_DIR:
              $error = ('Falta la carpeta temporal.');
              break;
            case UPLOAD_ERR_CANT_WRITE:
              $error = ('No se pudo escribir el archivo en el disco.');
              break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
              $error = ('Tamaño de archivo excede le permitido.');
              break;
            default:
              $error = ('Error Desconocido.');
              break;
          }
          return "<h5>Error Cargando el archivo " . $archivo ['name'] . ". " . $error . " </h5>";
        }
      } else {
        return "<h3>El archivo " . $archivo ['name'] . " excede el tamaño permitido.</h3><h5>Tamaño del Archivo: " . ($archivo["size"] / 1) . ";</h5s>";
      }
    } else {
      return "<h3>Error Procesando el archivo " . $archivo ['name'] . ".</h3>";
    }
  }

  public static
   function listar_directorios_rutas($rutaDir) {

    $listado = array();
    if(is_dir($rutaDir)) {
      if($dh = opendir($rutaDir)) {
        while(($file = readdir($dh)) !== false) {
          $listado[] = $rutaDir . $file;
          if(is_dir($rutaDir . $file) && $file != "." && $file != "..") {
            $listado = array_merge($listado, Archivos::listar_directorios_ruta($rutaDir . $file . "/"));
          } else {
            
          }
        }
        closedir($dh);
      }
    } else {
      return null;
    }
    return $listado;
  }

  public static
   function listar_directorios_nombre($rutaDir) {

    $listado = array();
    if(is_dir($rutaDir)) {
      if($dh = opendir($rutaDir)) {
        while(($file = readdir($dh)) !== false) {
          if(is_dir($rutaDir . $file) && $file != "." && $file != "..") {
            array_push($listado, $file);
          } else {
            
          }
        }
        closedir($dh);
      }
    } else {
      return null;
    }
    return $listado;
  }

}