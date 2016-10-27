<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class EstadisticasAgentes extends Modelos {

  public static
   function cantidadContratosValidos() {
    $query = <<<sql
  SELECT usuarios.*, sedes.*, COUNT(contratosafiliados.contratoId) AS cantContratos
  FROM contratosafiliados
  INNER JOIN usuarios  ON (contratosafiliados.contratoCreo = usuarios.usuarioId)
  LEFT JOIN sedes     ON (  usuarios.usuarioSede = sedes.sedeId    ) 
  WHERE contratosafiliados.contratoEstado = 1
  GROUP BY usuarios.usuarioId , sedes.sedeId       
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
  SELECT usuarios.*, COUNT(contratosafiliados.contratoId) AS cantContratos
  FROM contratosafiliados
  INNER JOIN usuarios  ON (contratosafiliados.contratoCreo = usuarios.usuarioId)
  WHERE contratosafiliados.contratoEstado = 'ANULADO'
  GROUP BY usuarios.usuarioId    
sql;
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta;
    }
    return 0;
  }

}
