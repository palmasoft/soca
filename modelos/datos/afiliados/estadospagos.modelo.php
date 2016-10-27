<?php
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class EstadosPagos extends Modelos {
  private static
   $nTabla = "estadopagos";
  private static
   $sqlBase = "SELECT estadopagos.* FROM estadopagos ";
  private static
   $sqlCompleta = "";
  private static
   $sqlJoin = "";

  static public
   function todos() {
    $query = self::$sqlBase; //. ' WHERE tipoDocumentoEstado = "' . $ESTADO . '"';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static function datos($idEstado) {
    $query = self::$sqlBase . "WHERE estadopagos.estadoPagoId = " . $idEstado . "";
    $consulta = self::consulta($query);
    if(count($consulta) > 0) {
      return $consulta[0];
    }
    return null;
  }

  static public
   function idPorCodigo($codigoEstado) {
    $query = self::$sqlBase . ' WHERE estadoPagoCodigo = "' . $codigoEstado . '"';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado[0]->estadoPagoId;
    }
    return NULL;
  }

  static public
   function segunPagoInicial($pagoinicial, $porcentajepago) {

    $pagoinicial = floatval($pagoinicial);
    $porcentajepago = floatval($porcentajepago);
    if($pagoinicial > 0) {
      if($pagoinicial < 500) {
        return EstadosPagos::idPorCodigo('SEPARACION');
      } else if($pagoinicial == 500) {
        return EstadosPagos::idPorCodigo('GASTOLEGAL');
      } else if($pagoinicial > 500) {
        if($porcentajepago >= 0 and $porcentajepago < 50) {
          return EstadosPagos::idPorCodigo('PENDING');
        } else if($porcentajepago >= 50 and $porcentajepago < 100) {
          return EstadosPagos::idPorCodigo('PROCE');
        } else if($porcentajepago == 100) {
          return EstadosPagos::idPorCodigo('CASH');
        }
      }
    } else {
      return EstadosPagos::idPorCodigo('CERO');
    }
    return NULL;
  }

  static public
   function porcentajePagoInicial($pagoinicial, $GASTOS, $vXPACK, $IVA, $NANOS, $VANOS) {
    $stdPagado = abs(($pagoinicial) - (($GASTOS + $vXPACK) * (1 + ($IVA / 100)))) / ($NANOS * ($VANOS * (1 + ($IVA / 100))));
    if($pagoinicial > 0 && $stdPagado > 0) {
      return floatval($stdPagado * 100);
    }
    return 0.0;
  }

}