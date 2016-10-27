<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Modelos::cargar('Documentos' . DS . 'Documentos');
Modelos::cargar('Documentos' . DS . 'Plantillas' . DS . 'RecibosA5');

class ReciboDepositoEquipo {

  static
   function generar($DatosDeposito) {
    $numeroDeposito = TiposDocumentos::usarConsecutivo('RECIBODEPOSITOS');
    $documentoCodigo = uniqid();
    $documentoTipo = 2;
    $documentoTitulo = 'Comprobante de Deposito #' . $numeroDeposito;

    $nombreEntrega = $DatosDeposito->personaRazonSocial;
    $identificacionEntrega = $DatosDeposito->tipoIdentificacionCodigo . " " . $DatosDeposito->personaIdentificacion;
    $direccionEntrega = $DatosDeposito->personaDireccion;
    $telefonoEntrega = $DatosDeposito->personaCelular;
    if(!is_null($DatosDeposito->reciboReferencia)) {
      $nombreEntrega = $DatosDeposito->nombresReferencia . " " . $DatosDeposito->apellidosReferencia;
      $identificacionEntrega = "C.C: " . $DatosDeposito->identificacionReferencia;
      $direccionEntrega = $DatosDeposito->direccionReferencia;
      $telefonoEntrega = $DatosDeposito->celularReferencia;
    }

    $valorEnLetras = Numeros::a_letras($DatosDeposito->reciboDepositoValor, 'COP');
    $DatosDeposito->reciboDepositoValor = "$ " . number_format($DatosDeposito->reciboDepositoValor, 0, ",", ".");

    $nombreArchivo = $numeroDeposito . "-" . uniqid() . ".pdf";
    $dirArchivo = PATH_ARCHIVOS . 'servicios' . DS . $DatosDeposito->servicioCodigo . DS . 'depositos-equipos' . DS;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . 'servicios' . WS . $DatosDeposito->servicioCodigo . WS . 'depositos-equipos' . WS;


    $pdf = new RecibosA5();
// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Params::valor('siglas_sistema') . "; " . Visitante::nombreCompletoUsuario());
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Comprobante de Entrega de Dinero de Deposito.');
    $pdf->SetKeywords('Recibo, Deposito, Dinero, Equipos, Entrega, Recoleccion, '
     . '' . $DatosDeposito->reciboNumero . ', ' . $DatosDeposito->servicioCodigo . ', ' . $numeroDeposito . ',' . Visitante::nombreUsuario() . '  ');

    $pdf->SetFont('dejavusans', '', 9, '', true);
    $pdf->AddPage();
    $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2,
     'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));


// Set some content to print
    $html = <<<EOD
 
    <table>  
     <tr>
       <td width="70%" >
         <span style="font-size: 150%;" >Recibo de Deposito #$numeroDeposito</span><br>
         <span  style="font-size: 90%;" ><b>Orden de Servicio:</b> $DatosDeposito->servicioCodigo</span>
       </td>
       <td width="30%" style="font-size: 100%;" >Fecha: <strong> $DatosDeposito->reciboFechaServicio</strong><br><span  style="font-size: 90%;" ><b>Recibo del Servicio </b> #$DatosDeposito->reciboNumero</span></td>
     </tr>
   </table>
    <div></div>
    <table>  
     <tr>
       <td width="60%" style="" >
        <strong>Recibimos de: </strong><br>
        <span style="font-size: 150%;">$nombreEntrega</span><br>
        <strong><span style="font-size: 120%;">$identificacionEntrega</span></strong><br>
        <span style="font-size: 100%;">$direccionEntrega $telefonoEntrega</span>
       </td>
       <td width="40%" style="font-size: 150%;" >
         Valor: <strong> $DatosDeposito->reciboDepositoValor</strong>         
       </td>
     </tr>
   </table>  
    <div></div>
     
  <table style="width: 100%; background-color: #f5f5f5; border: 1px solid #E6E9ED;  " >
    <tr>
     <td width="100%" ><div>VALOR EN LETRAS: <br><strong><span style="font-size: 120%;">$valorEnLetras</span></strong></div></td>
    </tr>
  </table>
     
  <table style="width: 100%; background-color: #f5f5f5; border: 1px solid #E6E9ED;  " >
    <tr>
     <td width="100%"  style="font-size: 90%;" ><div>POR CONCEPTO DE: <br><strong><span style="font-size: 120%;">Entrega de Dinero de Respaldo para los equipos entregados en el servicio.</span></strong></div></td>
    </tr>
  </table>    
     
EOD;
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    $infoLegal = Params::valor('informacion_legal_depositos');
    $legalHtml = <<<EOD
      <table>
       <tr>
        <td width="50%">
          <div style="background-color: #f5f5f5; padding: 2px;font-size: 80%; text-align: justify;">$infoLegal</div>
        </td>
        <td width="25%" style="text-align:center;" >
          <img src="$DatosDeposito->firmaRecibe" style="height: 90px;width:120px" /><br>
            _______________<br>
          $DatosDeposito->nombresRecibe $DatosDeposito->apellidosRecibe<br>
         C.C. $DatosDeposito->identificacionRecibe      
        </td>
        <td width="25%" style="text-align:center; vertical-align:bottom;" >
          <img src="/archivos/oximeiser/img/transparente.png" style="height: 90px;width:120px" /><br>
            _______________<br>
          $nombreEntrega<br>
          $identificacionEntrega 
        </td>
     </tr>
     </table>
EOD;
    $pdf->writeHTMLCell(0, 0, '', '', $legalHtml, 0, 1, 0, true, '', true);




// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    $pdf->Output($dirArchivo . $nombreArchivo, 'F');


    return Documentos::insertar($documentoCodigo, $documentoTipo, $numeroDeposito, $documentoTitulo,
                                $urlArchivo . $nombreArchivo
    );
  }

  static
   function generarEgreso($DatosDeposito) {
    $numeroDevolucion = TiposDocumentos::usarConsecutivo('DEVOLUCIONDEPOSITO');
    $documentoCodigo = uniqid();
    $documentoTipo = 3;
    $documentoTitulo = 'Comprobante de Devolución #' . $numeroDevolucion;

    $nombreEntrega = $DatosDeposito->nombresDevueltoA . " " . $DatosDeposito->apellidosDevueltoA;
    $identificacionEntrega = "C.C: " . $DatosDeposito->identificacionDevueltoA;
    $direccionEntrega = $DatosDeposito->direccionDevueltoA;
    $telefonoEntrega = $DatosDeposito->celularDevueltoA;
    $correoEntrega = $DatosDeposito->correoDevueltoA;

    $valorEnLetras = Numeros::a_letras($DatosDeposito->reciboDepositoValor, 'COP');
    $DatosDeposito->reciboDepositoValor = "$ " . number_format($DatosDeposito->reciboDepositoValor, 0, ",", ".");

    $nombreArchivo = $numeroDevolucion . "-" . uniqid() . ".pdf";
    $dirArchivo = PATH_ARCHIVOS . 'servicios' . DS . $DatosDeposito->servicioCodigo . DS . 'depositos-equipos' . DS;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . 'servicios' . WS . $DatosDeposito->servicioCodigo . WS . 'depositos-equipos' . WS;


    $pdf = new RecibosA5();
// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Params::valor('siglas_sistema') . "; " . Visitante::nombreCompletoUsuario());
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Comprobante de Devolución de Dinero de Deposito.');
    $pdf->SetKeywords('Recibo, Deposito, Dinero, Equipos, Devolucion, '
     . '' . $DatosDeposito->reciboNumero . ', ' . $DatosDeposito->servicioCodigo . ', ' . $numeroDevolucion . ',' . Visitante::nombreUsuario() . '  ');

    $pdf->SetFont('dejavusans', '', 9, '', true);
    $pdf->AddPage();
    $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2,
     'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));


// Set some content to print
    $html = <<<EOD
 
    <table>  
     <tr>
       <td width="70%" >
         <span style="font-size: 150%;" >Recibo de Devolución #$numeroDevolucion</span><br>
         <span  style="font-size: 90%;" ><b>Orden de Servicio:</b> $DatosDeposito->servicioCodigo</span>
       </td>
       <td width="30%" style="font-size: 100%;" >
         Fecha: <strong> $DatosDeposito->reciboDepositoDevuelto</strong><br>
         <span  style="font-size: 90%;" ><b>Recibo del Servicio </b> #$DatosDeposito->reciboNumero</span>
       </td>
     </tr>
   </table>
    <div></div>
    <table>  
     <tr>
       <td width="60%" style="" >
        <strong>Entregamos a: </strong><br>
        <span style="font-size: 150%;">$nombreEntrega</span><br>
        <strong><span style="font-size: 120%;">$identificacionEntrega</span></strong><br>
        <span style="font-size: 100%;">$direccionEntrega $telefonoEntrega</span><br>
        <span style="font-size: 100%;">$correoEntrega</span>
       </td>
       <td width="40%" style="font-size: 150%;" >
         Valor: <strong> $DatosDeposito->reciboDepositoValor</strong>         
       </td>
     </tr>
   </table>  
    <div></div>
     
  <table style="width: 100%; background-color: #f5f5f5; border: 1px solid #E6E9ED;  " >
    <tr>
     <td width="100%" ><div>VALOR EN LETRAS: <br><strong><span style="font-size: 120%;">$valorEnLetras</span></strong></div></td>
    </tr>
  </table>
     
  <table style="width: 100%; background-color: #f5f5f5; border: 1px solid #E6E9ED;  " >
    <tr>
     <td width="100%"  style="font-size: 90%;" ><div>POR CONCEPTO DE: <br><strong><span style="font-size: 120%;">Devolución de Dinero de Respaldo para los equipos entregados en el servicio.</span></strong></div></td>
    </tr>
  </table>    
     
EOD;
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    $infoLegal = Params::valor('informacion_legal_depositos');
    $legalHtml = <<<EOD
      <table>
       <tr>
        <td width="50%">
          <div style="background-color: #f5f5f5; padding: 2px;font-size: 80%; text-align: justify;">$infoLegal</div>
        </td>
        <td width="25%" style="text-align:center;" >
          <img src="$DatosDeposito->firmaDevuelve" style="height: 90px;width:120px" /><br>
            _______________<br>
          $DatosDeposito->nombresDevuelve $DatosDeposito->apellidosDevuelve<br>
         C.C. $DatosDeposito->identificacionDevuelve      
        </td>
        <td width="25%" style="text-align:center; vertical-align:bottom;" >
          <img src="/archivos/oximeiser/img/transparente.png" style="height: 90px;width:120px" /><br>
            _______________<br>
          $nombreEntrega<br>
          $identificacionEntrega 
        </td>
     </tr>
     </table>
EOD;
    $pdf->writeHTMLCell(0, 0, '', '', $legalHtml, 0, 1, 0, true, '', true);




// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    $pdf->Output($dirArchivo . $nombreArchivo, 'F');


    return Documentos::insertar($documentoCodigo, $documentoTipo, $numeroDevolucion, $documentoTitulo,
                                $urlArchivo . $nombreArchivo
    );
  }

}
