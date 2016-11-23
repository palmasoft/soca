<?php
abstract class Fechas {

  static function edad($fechaNacimiento) {
    list($Y, $m, $d) = explode("-", $fechaNacimiento);
    return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
  }

  CONST sin_separador = 'Ymd';
  CONST invertido = 'd-m-Y';
  CONST fecha_con_hora = 'Y-m-d h:i A';
  CONST f_MySql = 'Y-m-d';
  CONST f_PostgreSql = 'Y-m-d';
  CONST f_c_MySql = 'Y-m-d H:i:s';
  CONST f_c_PostgreSql = 'Y-m-d H:i:s';
  CONST h_MySql = 'H:i:s';
  CONST h_PostgreSql = 'H:i:s';

  static function cambiarFormato($fecha, $formatoOrigen, $formatoDestino = 'Y-m-d H:i:s') {
    if(!empty($fecha)) {
      try {
        $date = DateTime::createFromFormat($formatoOrigen, $fecha);
        if(!$date) {
          $date = DateTime::createFromFormat($formatoOrigen . ".u", $fecha);
        }
      } catch(Exception $e) {
        
      }
      if($date) {
        return $date->format($formatoDestino);
      }
      return NULL;
    }
    return NULL;
  }

  static function cambiaf_a_normal($fecha) {
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
  }

  static function cambiaf_a_mysql($fecha) {
    ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
    return $lafecha;
  }

  static function segundosEntreFechas($date1, $date2) {
    if(!is_integer($date1)) $date1 = strtotime($date1);
    if(!is_integer($date2)) $date2 = strtotime($date2);

    $dias = abs($date1 - $date2);
    return $dias;
  }

  static function diasEntreFechas($date1, $date2) {
    if(!is_integer($date1)) $date1 = strtotime($date1);
    if(!is_integer($date2)) $date2 = strtotime($date2);

    $dias = abs($date1 - $date2) / 60 / 60 / 24;
    return $dias;
  }

  static function sumardias($fecha, $dias) {

    if(preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha)) {
      list($dia, $mes, $ano) = explode("/", $fecha);
    }

    if(preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha)) {
      list($ano, $mes, $dia) = explode("-", $fecha);
    }

    $nueva = mktime(0, 0, 0, $mes, $dia, $ano) + $dias * 24 * 60 * 60;
    $nuevafecha = date("Y-m-d", $nueva);
    return $nuevafecha;
  }

  static function dias_mes($Month, $Year) {
    //Si la extensi�n que mencion� est� instalada, usamos esa.
    if(is_callable("cal_days_in_month")) {
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
    } else {
      //Lo hacemos a mi manera.
      return date("d", mktime(0, 0, 0, $Month + 1, 0, $Year));
    }
  }

  static function convertirFecha2Texto($inputDate, $dateFormat = NULL) {
    //eval($idioma);

    setlocale(LC_ALL, "es_ES");
    switch($dateFormat) {
      case 1:
        return date('F d, Y h:i:s A', strtotime($inputDate));
        break;

      case 2:
        return date('F d, Y G:i:s', strtotime($inputDate));
        break;

      case 3:
        return date('M d, Y h:i:s A', strtotime($inputDate));
        break;

      case 4:
        return date('M d, Y G:i:s', strtotime($inputDate));
        break;

      case 5:
        //echo Fechas::dia_espanol( date('N') );
        //echo "<br />";
        return date('M d', strtotime($inputDate)) . ", " . substr(Fechas::dia_espanol(intval(date('N',
             strtotime($inputDate))) - 1), 0, 5);
        break;
      default: return date('Y-m-d H:i:s', strtotime($inputDate));
        break;
    }
  }

  static public $dias = array(
   "Lunes",
   "Martes",
   "Miercoles",
   "Jueves",
   "Viernes",
   "Sabado",
   "Domingo"
  );

  static function dia_espanol($dia) {
    return self::$dias[$dia];
  }

  static public $meses = array(
   "Enero",
   "Febrero",
   "Marzo",
   "Abril",
   "Mayo",
   "Junio",
   "Julio",
   "Agosto",
   "Septiembre",
   "Octubre",
   "Noviembre",
   "Diciembre"
  );

  static function mes_espanol($mes) {
    self::$meses = array(
     "Enero",
     "Febrero",
     "Marzo",
     "Abril",
     "Mayo",
     "Junio",
     "Julio",
     "Agosto",
     "Septiembre",
     "Octubre",
     "Noviembre",
     "Diciembre"
    );
    return self::$meses[$mes];
  }

  static function obtenerListaDias($sStartDate, $sEndDate) {
    // Firstly, format the provided dates.  
    // This function works best with YYYY-MM-DD  
    // but other date formats will work thanks  
    // to strtotime().  
    $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
    $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));

    // Start the variable off with the start date  
    $aDays[] = $sStartDate;

    // Set a 'temp' variable, sCurrentDate, with  
    // the start date - before beginning the loop  
    $sCurrentDate = $sStartDate;

    // While the current date is less than the end date  
    while($sCurrentDate < $sEndDate) {
      // Add a day to the current date  
      $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

      // Add this new day to the aDays array  
      $aDays[] = $sCurrentDate;
    }

    // Once the loop has finished, return the  
    // array of days.  
    return $aDays;
  }

}