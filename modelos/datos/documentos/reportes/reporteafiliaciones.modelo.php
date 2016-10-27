<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Modelos::cargar('Documentos' . DS . 'Documentos');
Modelos::cargar('Documentos' . DS . 'Pdfs');
Modelos::cargar('Sistema' . DS . 'Cantones');
class ReporteAfiliaciones extends Pdfs {

  function generar($DatosConsulta) {

    $this->setPageFormat('A4', 'L');

    $this->SetTextColor(0, 0, 0);
    $this->SetFont('times', 'B', 12);
    $index_link = $this->AddLink();
    $this->SetLink($index_link, 0, '*1');
    $this->SetFont('times', '', 8);
    $this->Cell(0, 10, 'indice', 0, 1, 'R', false, $index_link);
    foreach($DatosConsulta['Resultado'] as $datosSede) {
      $this->AddPage();

      $this->SetFont('times', 'B', 12);
      $this->Cell(0, 5, 'Reporte de Afiliaciones ', 0, 1, 'C');
      $this->Cell(0, 5, 'entre ' . $DatosConsulta['fecha_desde'] . ' - ' . $DatosConsulta['fecha_hasta'] . '', 0, 1, 'C');
      $this->Cell(0, 5,
       'Sede: ' . ( is_null($DatosConsulta['objSede']) ? 'Todas' : $DatosConsulta['objSede']->nombreSede ) . ' / ' .
       'Estado: ' . ( is_null($DatosConsulta['objEstadoPago']) ? 'Todos' : $DatosConsulta['objEstadoPago']->estadoPagoTitulo ) . ' / ' .
       'Servicio : ' . ( is_null($DatosConsulta['objEstadoServicio']) ? 'Todos' : $DatosConsulta['objEstadoServicio']->estadoContratoTitulo ) . '',
       0, 1, 'C');


      $this->SetFont('times', 'B', 14);
      $nombreSede = 'Sede: ' . $datosSede->Datos->sedeNombre . ' / ' . $datosSede->Datos->sedeCodigo;
      $this->Bookmark($nombreSede, 0, 0, '', 'B', array(0, 64, 128));
      $this->Cell(140, 10, $nombreSede, 0, 0, 'L');
      $this->Cell(90, 10, " ", 0, 0, 'R');
//      $this->Cell(35, 10, 'Prom. CASH: $' . round($datosSede->vendido / $datosSede->numContratos) . " ", 0, 0, 'C');
//      $this->Cell(35, 10, 'XPACK: $' . round($datosSede->xpack / $datosSede->numContratos) . " ", 0, 0, 'C');
      $this->Cell(30, 10, 'Estado: ' . round($datosSede->porcentaje / $datosSede->numContratos) . "% ", 'R', 0, 'C');
      $this->Cell(20, 10, "$ " . $datosSede->vendido, 0, 0, 'R');
      $this->SetTextColor(160, 160, 160);
      $this->Cell(0, 10, "/" . $datosSede->numContratos, 0, 1, 'L');
      $this->SetTextColor(0, 0, 0);
      $this->Ln(1);
      foreach($datosSede->Agentes as $datosAgente) {
        $this->SetFont('times', '', 12);
        $nombreAgente = '' . str_pad($datosAgente->Datos->personaIdentificacion, 11, "0", STR_PAD_LEFT) . ' ' . $datosAgente->Datos->personaNombres . ' ' . $datosAgente->Datos->personaApellidos . ' [' . $datosAgente->Datos->usuarioNombre . '] ';
        $this->Bookmark($nombreAgente, 0, 0, '', 'B', array(0, 64, 128));
        $this->Cell(140, 10, $nombreAgente, 0, 0, 'L');
        $this->Cell(110, 10, " ", 0, 0, 'R');
//        $this->Cell(35, 10, 'Prom. CASH: $' . round($datosAgente->vendido / $datosAgente->numContratos) . " ", 0, 0, 'C');
//        $this->Cell(35, 10, 'XPACK: $' . round($datosAgente->xpack / $datosAgente->numContratos) . " ", 0, 0, 'C');
//        $this->Cell(30, 10, 'Estado: ' . round($datosAgente->porcentaje / $datosAgente->numContratos) . "%", 'R', 0, 'C');
        $this->Cell(20, 10, "$ " . $datosAgente->vendido, 0, 0, 'R');
        $this->SetTextColor(160, 160, 160);
        $this->Cell(0, 10, "/" . $datosAgente->numContratos, 0, 1, 'L');
        $this->SetTextColor(0, 0, 0);
        $this->Ln(1);
        $this->tablaEstilo(array("No. CTO", "FECHA CTO", "AÑOS", "AÑOS PAG", " $ CTO ", " CASH ", " XPACK ", " G/L ",
         "C/I", "SALDO C/I", "$ FINAN", "%", "ESTADO", "SERVICIO"), $datosAgente->Contratos);
      }
    }
// ---------------------------------------------------------
    $nFile = str_replace(" ", "", $DatosConsulta['fecha_desde'] . '-' . $DatosConsulta['fecha_hasta']);
//Close and output PDF document
    $this->Output(PATH_ARCHIVOS . 'reportes' . DS . $nFile . '.pdf', 'F');

    return URL_ARCHIVOS . 'reportes' . WS . $nFile . '.pdf';
  }

  // Colored table
  public function tablaEstilo($header, $data) {
    // Colors, line width and bold font
    $this->SetFillColor(222, 222, 222);
    $this->SetTextColor(0);
    $this->SetDrawColor(128, 0, 0);
    $this->SetLineWidth(0.3);
    $this->SetFont('times', 'B', 8);
    // Header
    $w = array(25, 35, 15, 15, 20, 20, 20, 20, 20, 20, 20, 15, 20, 15);
    $num_headers = count($header);
    for($i = 0; $i < $num_headers; ++$i) {
      $this->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
    }
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224, 235, 255);
    $this->SetTextColor(0);
    $this->SetFont('times', '', 10);
    // Data
    $fill = 0;
    $ttlXPACK = 0;
    $ttlGL = 0;
    $ttlPCI = 0;
    $ttlCI = 0;
    $ttlSCI = 0;
    $ttlSF = 0;
    $ttlVC = 0;
    $ttlTP = 0;
    $ttlPORC = 0;
    $num = 0;
    foreach($data as $row) {
      $this->Cell($w[0], 5, $row->contratoConsecutivo, 1, 0, 'C', $fill);
      $this->Cell($w[1], 5, $row->contratoFecha, 1, 0, 'C', $fill);
      $this->Cell($w[2], 5, $row->contratoAnosPlanPagos, 1, 0, 'C', $fill);
      $this->Cell($w[3], 5, $row->contratoAnos, 1, 0, 'C', $fill);
      $this->Cell($w[4], 5, "$" . $row->contratoValorContrato, 1, 0, 'C', $fill);
      $this->Cell($w[5], 5, "$" . $row->contratoPagoInicial, 1, 0, 'C', $fill);
      $this->Cell($w[6], 5, "$" . $row->contratoXpack, 1, 0, 'C', $fill);
      $this->Cell($w[7], 5, "$" . $row->contratoGastosLegales, 1, 0, 'C', $fill);
      $this->Cell($w[8], 5, "$" . $row->contratoCuotaInicial, 1, 0, 'C', $fill);
      $this->Cell($w[9], 5, "$" . $row->contratoSaldoCuotaInicial, 1, 0, 'C', $fill);
      $this->Cell($w[10], 5, "$" . $row->contratoSaldoFinanciar, 1, 0, 'C', $fill);
      $this->Cell($w[11], 5, $row->contratoPorcentajePago . '%', 1, 0, 'C', $fill);
      $this->Cell($w[12], 5, $row->estadoPagoCodigo, 1, 0, 'C', $fill);
      $this->Cell($w[13], 5, $row->estadoContratoTitulo, 1, 0, 'C', $fill);
      $this->Ln();
      $fill = !$fill;

      $ttlXPACK += $row->contratoXpack;
      $ttlGL += $row->contratoGastosLegales;
      $ttlPCI += $row->contratoPagoInicial;
      $ttlCI += $row->contratoCuotaInicial;
      $ttlSCI += $row->contratoSaldoCuotaInicial;
      $ttlSF += $row->contratoSaldoFinanciar;
      $ttlVC += $row->contratoValorContrato;
      $ttlTP += $row->totalPagado;
      $ttlPORC += $row->contratoPorcentajePago;
      $num ++;
    }

    $this->SetFillColor(222, 222, 222);
    $this->SetTextColor(0);
    $this->SetFont('times', 'B', 14);
    $this->Cell($w[0] + $w[1] + $w[2] + $w[3], 5, "Totales", 1, 0, 'C', 1);
    $this->Cell($w[4], 5, "$" . $ttlVC, 1, 0, 'C', 1);
    $this->Cell($w[5], 5, "$" . $ttlPCI, 1, 0, 'C', 1);
    $this->Cell($w[6], 5, "$" . $ttlXPACK, 1, 0, 'C', 1);
    $this->Cell($w[7], 5, "$" . $ttlGL, 1, 0, 'C', 1);
    $this->Cell($w[8], 5, "$" . $ttlCI, 1, 0, 'C', 1);
    $this->Cell($w[9], 5, "$" . $ttlSCI, 1, 0, 'C', 1);
    $this->Cell($w[10], 5, "$" . $ttlSF, 1, 0, 'C', 1);
    $this->Cell($w[11], 5, "" . round($ttlPORC / $num) . "%", 1, 0, 'C', 1);
    $this->Cell($w[12], 5, "", 'TL', 0, 'C', 0);
    $this->Cell($w[13], 5, "", 'T', 0, 'C', 0);
    $this->Ln();

    $this->SetFont('times', 'B', 12);
  }

}