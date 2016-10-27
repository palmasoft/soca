<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class PlanDePagos extends Modelos {

  static
   function sencilloMensual($nCuotas, $sFinanciado, $fPrimerPago) {
    $planPagos = array();
    if($nCuotas == 0) return array();
    $numCuotas = ( isset($nCuotas) ? $nCuotas : 0);
    $valorFinanciadoContrato = floatval(isset($sFinanciado) ? $sFinanciado : 0);
    $cuota = floatval($valorFinanciadoContrato / $numCuotas);
    $fechaInicioPago = ( isset($fPrimerPago) ? $fPrimerPago : date('Y-m-j') );
    $saldo = floatval($valorFinanciadoContrato);
    $pagado = 0;
    foreach(range(0, $numCuotas - 1) as $id):
      $arrcuota = array();
      $arrcuota['numero'] = intval($id) + 1;
      $arrcuota['saldo_a_pagar'] = ($saldo - ($cuota * intval($id)) );
      $arrcuota['fecha_pago'] = date('Y-m-j', strtotime('+' . ( $id ) . ' month', strtotime($fechaInicioPago)));
      $arrcuota['valor_pago'] = $cuota;
      $arrcuota['nuevo_saldo'] = $saldo - ($cuota * ($id + 1) );
      array_push($planPagos, $arrcuota);
    endforeach;   
    return $planPagos;
  }

  static
   function limitadoMensual($maxMeses, $nCuotas, $sFinanciado, $fPrimerPago) {
    
    
    $planPagos = array();
    if($nCuotas == 0) return array();

    $mesesEntrePagos = $maxMeses / $nCuotas;
    $numCuotas = ( isset($nCuotas) ? $nCuotas : 0);
    $valorFinanciadoContrato = ( isset($sFinanciado) ? $sFinanciado : 0);
    $cuota = $valorFinanciadoContrato / $numCuotas;
    $fechaInicioPago = ( isset($fPrimerPago) ? $fPrimerPago : date('Y-m-j') );
    $saldo = $valorFinanciadoContrato;
    $pagado = 0;
    foreach(range(0, $numCuotas - 1) as $id):
      $arrcuota = array();
      $arrcuota['numero'] = intval($id) + 1;
      $arrcuota['saldo_a_pagar'] = ($saldo - ($cuota * intval($id)) );
      $mesPago = $id * $mesesEntrePagos;
      $diasPago = intval(($mesPago - floor($mesPago)) * 30);
      $mesPago = intval($mesPago);
      $arrcuota['fecha_pago'] = date('Y-m-j',
                                     strtotime('+' . ( $mesPago ) . ' month +' . ( $diasPago ) . ' days',
                                               strtotime($fechaInicioPago)));
      $arrcuota['valor_pago'] = $cuota;
      $arrcuota['nuevo_saldo'] = $saldo - ($cuota * ($id + 1) );

      array_push($planPagos, $arrcuota);
    endforeach;

    return $planPagos;
  }

}
