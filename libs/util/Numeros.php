<?php

/**
 * Description of Numeros
 *
 * @author Puro Ingenio Samario
 */
class Numeros {

  static public
   function sumar_uno(&$param = 0) {
    if(isset($param)) {
      $param += 1;
    } else {
      $param = 1;
    }
    return $param;
  }

  private static
   $UNIDADES = [
   '',
   'UN ',
   'DOS ',
   'TRES ',
   'CUATRO ',
   'CINCO ',
   'SEIS ',
   'SIETE ',
   'OCHO ',
   'NUEVE ',
   'DIEZ ',
   'ONCE ',
   'DOCE ',
   'TRECE ',
   'CATORCE ',
   'QUINCE ',
   'DIECISEIS ',
   'DIECISIETE ',
   'DIECIOCHO ',
   'DIECINUEVE ',
   'VEINTE '
  ];
  private static
   $DECENAS = [
   'VENTI',
   'TREINTA ',
   'CUARENTA ',
   'CINCUENTA ',
   'SESENTA ',
   'SETENTA ',
   'OCHENTA ',
   'NOVENTA ',
   'CIEN '
  ];
  private static 
   $CENTENAS = [
   'CIENTO ',
   'DOSCIENTOS ',
   'TRESCIENTOS ',
   'CUATROCIENTOS ',
   'QUINIENTOS ',
   'SEISCIENTOS ',
   'SETECIENTOS ',
   'OCHOCIENTOS ',
   'NOVECIENTOS '
  ];
  private static
   $MONEDAS = [
   ['country' => 'Colombia', 'currency' => 'COP', 'singular' => 'PESO COLOMBIANO',
    'plural' => 'PESOS COLOMBIANOS', 'symbol', '$'],
   ['country' => 'Estados Unidos', 'currency' => 'USD', 'singular' => 'DÓLAR', 'plural' => 'DÓLARES',
    'symbol', 'US$'],
   ['country' => 'Europa', 'currency' => 'EUR', 'singular' => 'EURO', 'plural' => 'EUROS',
    'symbol', '€'],
   ['country' => 'México', 'currency' => 'MXN', 'singular' => 'PESO MEXICANO', 'plural' => 'PESOS MEXICANOS',
    'symbol', '$'],
   ['country' => 'Perú', 'currency' => 'PEN', 'singular' => 'NUEVO SOL', 'plural' => 'NUEVOS SOLES',
    'symbol', 'S/'],
   ['country' => 'Reino Unido', 'currency' => 'GBP', 'singular' => 'LIBRA', 'plural' => 'LIBRAS',
    'symbol', '£']
  ];

  public static
   function a_letras($number, $miMoneda = null) {
    if($miMoneda !== null) {
      try {
        $moneda = array_filter(self::$MONEDAS,
                               function($m) use ($miMoneda) {
          return ($m['currency'] == $miMoneda);
        });
        $moneda = array_values($moneda);
        if(count($moneda) <= 0) {
          throw new Exception("Tipo de moneda inválido");
          return;
        }
        if($number < 2) {
          $moneda = $moneda[0]['singular'];
        } else {
          $moneda = $moneda[0]['plural'];
        }
      } catch(Exception $e) {
        echo $e->getMessage();
        return;
      }
    } else {
      $moneda = " ";
    }
    $converted = '';
    if(($number < 0) || ($number > 999999999)) {
      return 'No es posible convertir el numero a letras';
    }
    $numberStr = (string) $number;
    $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
    $millones = substr($numberStrFill, 0, 3);
    $miles = substr($numberStrFill, 3, 3);
    $cientos = substr($numberStrFill, 6);
    if(intval($millones) > 0) {
      if($millones == '001') {
        $converted .= 'UN MILLON ';
      } else if(intval($millones) > 0) {
        $converted .= sprintf('%sMILLONES ', self::$convertGroup($millones));
      }
    }

    if(intval($miles) > 0) {
      if($miles == '001') {
        $converted .= 'MIL ';
      } else if(intval($miles) > 0) {
        $converted .= sprintf('%sMIL ', self::convertGroup($miles));
      }
    }
    if(intval($cientos) > 0) {
      if($cientos == '001') {
        $converted .= 'UN ';
      } else if(intval($cientos) > 0) {
        $converted .= sprintf('%s ', self::$convertGroup($cientos));
      }
    }
    $converted .= $moneda;
    return $converted;
  }

  private
   function convertGroup($n) {
    $output = '';
    if($n == '100') {
      $output = "CIEN ";
    } else if($n[0] !== '0') {
      $output = self::$CENTENAS[$n[0] - 1];
    }
    $k = intval(substr($n, 1));
    if($k <= 20) {
      $output .= self::$UNIDADES[$k];
    } else {
      if(($k > 30) && ($n[2] !== '0')) {
        $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2],
                                                           self::$UNIDADES[intval($n[2])]);
      } else {
        $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2],
                                                         self::$UNIDADES[intval($n[2])]);
      }
    }

    return $output;
  }

}
