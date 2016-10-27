<?php
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class ContratosAfiliadosPlanPagos extends Modelos {
  private static
   $nTabla = "contratosafiliadosplanpagos";
  private static
   $sqlBase = "SELECT contratosafiliadosplanpagos.* FROM contratosafiliadosplanpagos ";
  private static
   $sqlCompleta = "";
  private static
   $sqlJoin = "";
  const
   CuotaInicial = 'SALDO CUOTA INCIAL';
  const
   ValorContrato = 'VALOR A FINANCIAR';

  static public
   function todos() {
    $query = self::$sqlBase; //. ' WHERE tipoDocumentoEstado = "' . $ESTADO . '"';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function deCuotaInicialdelContrato($contratoId) {
    $query = self::$sqlBase . ' '
     . 'WHERE ' . self::$nTabla . '.planpagosContrato = ? '
     . 'AND ' . self::$nTabla . '.planpagosTipoCuota = ? '
     . 'ORDER BY ' . self::$nTabla . '.planpagosNumCuota ASC  ';
    $resultado = self::consulta($query, array($contratoId, self::CuotaInicial));
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function delContrato($contratoId) {
    $query = self::$sqlBase . ' '
     . 'WHERE ' . self::$nTabla . '.planpagosContrato = ? '
     . 'AND ' . self::$nTabla . '.planpagosTipoCuota = ? '
     . 'ORDER BY ' . self::$nTabla . '.planpagosNumCuota ASC  ';
    $resultado = self::consulta($query, array($contratoId, self::ValorContrato));
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function deValordelContrato($contratoId) {
    $query = self::$sqlBase . ' WHERE ' . self::$nTabla . '.planpagosContrato = ? AND ' . self::$nTabla . '.planpagosTipoCuota = ?  '
     . 'ORDER BY ' . self::$nTabla . '.planpagosNumCuota ASC  ';
    $resultado = self::consulta($query, array($contratoId, self::ValorContrato));
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function insertar($planpagosContrato, $planpagosTipoCuota, $planpagosNumCuota, $planpagosFechaCuota,
   $planpagosValorCuota, $planpagosSaldoProyectado) {
    $query = "INSERT INTO contratosafiliadosplanpagos (  "
     . "planpagosContrato , planpagosTipoCuota , planpagosNumCuota , planpagosFechaCuota , planpagosValorCuota , planpagosSaldoProyectado "
     . ") VALUES  (? , ? , ? , ? , ? , ? ) ; ";
    $resultado = self::crearUltimoId(
      $query,
      array($planpagosContrato, $planpagosTipoCuota, $planpagosNumCuota, $planpagosFechaCuota,
      $planpagosValorCuota, $planpagosSaldoProyectado)
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}