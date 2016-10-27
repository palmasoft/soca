<?php
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class EstadisticasSede extends Modelos {

  public static
   function cantidadContratosValidos() {
    $query = <<<sql
    SELECT sedes.*, COUNT(contratosafiliados.contratoId ) AS cantContratos 
    FROM contratosafiliados
    INNER JOIN sedes ON ( contratosafiliados.contratoSede = sedes.sedeId )
    WHERE contratosafiliados.contratoEstado = 1 
    GROUP BY sedes.sedeId 
sql;
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function cantidadContratosAnulados() {
    $query = <<<sql
    SELECT sedes.*, COUNT(contratosafiliados.contratoId ) AS cantContratos 
    FROM contratosafiliados
    INNER JOIN sedes ON ( contratosafiliados.contratoSede = sedes.sedeId )
    WHERE contratosafiliados.contratoEstado = 'ANULADO' 
    GROUP BY sedes.sedeId 
sql;
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function ultimos12Meses() {
    $query = <<<sql
SELECT 
  YEAR(contratoFecha) AS anio
  , MONTH(contratoFecha) AS mes
  , contratoSede AS sede
  , COUNT(contratoId) AS cant
  , SUM(contratoValorContrato) AS vendido
  , SUM(contratoPagoInicial) AS ingreso
  , SUM(contratoSaldoFinanciar) AS financiado
FROM  contratosafiliados 
WHERE contratosafiliados.contratoFecha BETWEEN NOW() - INTERVAL 12 MONTH AND NOW() 
GROUP BY YEAR(contratoFecha)
  , MONTH(contratoFecha)
  , contratoSede 
  ORDER BY YEAR(contratoFecha)DESC 
  , MONTH(contratoFecha) DESC
sql;
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

  public static
   function diaAdiaUltimos12Meses() {
    $query = <<<sql
SELECT 
  YEAR(contratoFecha) AS anio
  , MONTH(contratoFecha) AS mes
  , DAY(contratoFecha) AS dia
  , contratoSede AS sede
  , COUNT(contratoId) AS cant
  , SUM(contratoValorContrato) AS vendido
  , SUM(contratoPagoInicial) AS ingreso
  , SUM(contratoSaldoFinanciar) AS financiado
FROM  contratosafiliados 
WHERE contratosafiliados.contratoFecha BETWEEN NOW() - INTERVAL 12 MONTH AND NOW() 
GROUP BY YEAR(contratoFecha)
  , MONTH(contratoFecha)
  , DAY(contratoFecha)
  , contratoSede 
ORDER BY YEAR(contratoFecha)DESC 
  , MONTH(contratoFecha) DESC
  , DAY(contratoFecha) DESC  
sql;
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

}