<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Modelos::cargar('Documentos' . DS . 'Documentos');
Modelos::cargar('Documentos' . DS . 'Plantillas' . DS . 'RecibosA4');

class ReciboArriendoEquipo {

  static
   function generar($DatosServicio) {

    $nombreArchivo = $DatosServicio->reciboNumero . "-" . uniqid() . ".pdf";
    $dirArchivo = PATH_ARCHIVOS . 'servicios' . DS . $DatosServicio->servicioCodigo . DS . 'recibos-equipos' . DS;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . 'servicios' . WS . $DatosServicio->servicioCodigo . WS . 'recibos-equipos' . WS;


    $documentoCodigo = uniqid();
    $documentoTipo = 1;
    $documentoTitulo = 'Recibo de Equipos #' . $DatosServicio->reciboNumero;

    $pdf = new RecibosA4();
// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Comprobante de Entrega y Recogida de Equipos.');
    $pdf->SetKeywords('Recibo, Equipos, Entrega, Recoleccion, '
     . '' . $DatosServicio->reciboNumero . ', ' . $DatosServicio->servicioCodigo . ', ' . Visitante::nombreUsuario() . '  ');

    $pdf->SetFont('dejavusans', '', 9, '', true);
    $pdf->AddPage();
    $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2,
     'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

    if(is_null($DatosServicio->reciboReferencia)) {
      $DatosServicio->nombresReferencia = "";
      $DatosServicio->apellidosReferencia = "";
      $DatosServicio->direccionReferencia = "";
      $DatosServicio->celularReferencia = "";
      $DatosServicio->correoReferencia = "";
    }

// Set some content to print
    $html = <<<EOD
<div>
   <table>  
    <tr>
      <td width="70%" >
        <span  style="font-size: 200%;"  >Recibo de Servicio #$DatosServicio->reciboNumero</span>
        <br>
        <span  style="font-size: 100%;" ><b>Orden de Servicio:</b> $DatosServicio->servicioCodigo</span>
      </td>
      <td width="30%" style="font-size: 100%;" >
        Fecha: <strong> $DatosServicio->reciboFechaServicio</strong>
        <br>
        <b>RECOGIDA:</b> <span id="proxima-recogida">$DatosServicio->reciboFechaRecogida</span>          
      </td>
    </tr>
  </table>    
     
  <table style="width: 100%; font-size: 85%;" >
    <tr>
      <td width="45%" ><span>CLIENTE</span>
          <br>codigo: <strong><span id="codigo-cliente">$DatosServicio->clienteCodigo</span></strong>
          <br><em><strong><span id="nombres-cliente">$DatosServicio->personaRazonSocial</span></strong></em>
          <br><span id="dir-cliente">$DatosServicio->personaDireccion</span>                
          <br>Teléfono: <strong><span id="tel-cliente">$DatosServicio->personaCelular</span></strong>
          <br>Correo: <strong><span id="correo-cliente">$DatosServicio->personaCorreoElectronico</span></strong>        
      </td>
      <td  width="35%" ><span>REFERENCIA</span>
          <br><strong><span id="nombre-referencia-cliente">$DatosServicio->nombresReferencia $DatosServicio->apellidosReferencia</span></strong>
          <br><span id="dir-referencia-cliente">$DatosServicio->direccionReferencia</span>                
          <br><strong><span id="tel-referencia-cliente">$DatosServicio->celularReferencia</span></strong>
          <br><strong><span id="correo-referencia-cliente">$DatosServicio->correoReferencia</span></strong>
      </td>
      <td  width="10%" style="font-size:100%" >     
        <img src="$DatosServicio->personaLogo" style="max-width: 100%;" />
      </td>
    </tr>
  </table>
    <div></div>
  <table style="width: 100%; font-size: 85%; padding: 7px; margin: 0px; margin-top:10px; background-color: #f5f5f5; border: 1px solid #E6E9ED;  " >
    <tr>
     <td width="30%" >
     <strong>Geo-referencia</strong><br>
      <b>Latitud:</b> $DatosServicio->reciboLatitud<br>
      <b>Longitud:</b> $DatosServicio->reciboLongitud<br>
     </td>
     <td  width="70%" >
     Dirección del Servicio: <strong><span id="direccion-servicio">$DatosServicio->reciboDireccion</span></strong>
     </td>
    </tr>
  </table>
     </div>
     
EOD;

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



    $tablaHtml = <<<EOD
     <table width="100%" style=" text-align: center;"  cellpadding="2" >
      <tr >
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;"  width="2%" ></th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="18%" >Tipo</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="20%" >Equipo</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="20%" >Serial #</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="20%" >Cap.</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="20%" ></th>
      </tr>
EOD;
    foreach($DatosServicio->equiposRecibo as $indice => $EquipoServicio) {

      $colorFondo = '#f7f7f7';
      if($indice % 2 != 0) {
        $colorFondo = '#ffffff';
      }

      $eqTipoTitulo = substr($EquipoServicio->tipoEquipoTitulo, 0, 10);
      $eqTitulo = substr($EquipoServicio->equipoTitulo, 0, 17);

      $filaTablaHtml = <<<EOD
      <tr style="background-color: $colorFondo;" >
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; "  >1</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; ">$eqTipoTitulo</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; ">$eqTitulo</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; "><strong>$EquipoServicio->equipoSerial</strong></td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; ">$EquipoServicio->equipoCapacidad</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; text-align: center; background-color: #EEEEEE;">$EquipoServicio->movimientoCodigo</td>        
      </tr>    
EOD;
      $tablaHtml .= $filaTablaHtml;
    }
    $tablaHtml .= <<<EOD
       </table>
EOD;
    $pdf->writeHTMLCell(0, 0, '', '', $tablaHtml, 0, 1, 0, true, '', true);

    if(!is_null($DatosServicio->depositoRecibo)) {
      $depositoValor = "$ " . number_format($DatosServicio->depositoRecibo->reciboDepositoValor,
                                            0, ',', '.');
      $depositoTipo = $DatosServicio->depositoRecibo->depositoTitulo;
      $depositoReciboTitulo = $DatosServicio->depositoRecibo->tipoDocTitulo;
      $depositoReciboNumero = $DatosServicio->depositoRecibo->documentoConsecutivo;

      $depositoHtml = <<<EOD
      <div></div>
      <table>
        <tr><td>Deposito [$depositoTipo] <strong><span style="font-size: 150%;" >$depositoValor</span></strong></td>
        <td>soporte: $depositoReciboTitulo #<strong><span style="font-size: 150%;" >$depositoReciboNumero</span></strong></td></tr>
      </table>
EOD;
      $pdf->writeHTMLCell(0, 0, '', '', $depositoHtml, 0, 1, 0, true, '', true);
    }


    $infoLegal = Params::valor('informacion_legal_servicio_equipos');
    $legalHtml = <<<EOD
     <div></div>
     <table>
       <tr>
        <td width="70%" style="margin-top: 10px; background-color: #f5f5f5; padding: 2px;">
          <div style="text-align: center;">$infoLegal</div>
        </td>
        <td width="30%" style="text-align:center;" >
          <img src="$DatosServicio->firmaEncargado" style="width: 120px; height: 90px;" /><br>
            ____________________________<br>
          $DatosServicio->nombresEncargado $DatosServicio->apellidosEncargado<br>
          C.C. $DatosServicio->idEncargado      
        </td>
     </tr>
     </table>
EOD;
    $pdf->writeHTMLCell(0, 0, '', '', $legalHtml, 0, 1, 0, true, '', true);




// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    $pdf->Output($dirArchivo . $nombreArchivo, 'F');


    return Documentos::insertar($documentoCodigo, $documentoTipo,
                                $DatosServicio->reciboNumero, $documentoTitulo,
                                $urlArchivo . $nombreArchivo
    );
  }

}
