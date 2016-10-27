<?php

require_once('libs/correos/Correos.php');

class CorreosServiciosEquipos {

  static
   function enviarNuevoServicioEquipos($DatosServicio) {

    $htmlContenido = Archivos::leer_archivo(PATH_MODELOS . "correos" . DS . "nuevoservicioequipos.html.php");



    $identificacionCliente = $DatosServicio->tipoIdentificacionCodigo . "" . $DatosServicio->personaIdentificacion;
    $nombreCliente = Textos::paraCorreos($DatosServicio->personaRazonSocial);
    $telefonoCliente = $DatosServicio->personaCelular . " " . $DatosServicio->personaTelefono;
    $correoCliente = $DatosServicio->personaCorreoElectronico;
    $esReferencia = '';
    if(!is_null($DatosServicio->reciboReferencia)) {
      $esReferencia = Textos::paraCorreos('Usted está recibiendo este servicio como referencia del cliente ' . $nombreCliente . " identificado por " . $identificacionCliente);
      $identificacionCliente = "CC" . $DatosServicio->idReferencia;
      $nombreCliente = Textos::paraCorreos($DatosServicio->nombresReferencia . " " . $DatosServicio->apellidosReferencia);
      $telefonoCliente = $DatosServicio->personaCelular . " " . $DatosServicio->personaTelefono;
      $correoCliente = $DatosServicio->personaCorreoElectronico;
    }


    $tablaHtml = <<<EOD
     <table width="100%" style=" text-align: center; font-size: 100%"  cellpadding="0" >
      <tr >        
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="30%" >Tipo</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="30%" >Serial #</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="10%" >Cap.</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="30%" ></th>
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
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; ">$eqTipoTitulo</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; "><strong>$EquipoServicio->equipoSerial</strong></td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; ">$EquipoServicio->equipoCapacidad</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; text-align: center; background-color: #EEEEEE;">$EquipoServicio->movimientoTitulo2</td>        
      </tr>    
EOD;
      $tablaHtml .= $filaTablaHtml;
    }
    $tablaHtml .= <<<EOD
    </table >
EOD;


    $infoDeposito = "";
    if(!is_null($DatosServicio->depositoRecibo)) {
      $infoDeposito = 'Tambi&#233;n recibe una copia del <strong style="font-weight: bold;">Recibo de Deposito ' . $DatosServicio->depositoRecibo->documentoConsecutivo . ' </strong> por valor de $' . number_format($DatosServicio->depositoRecibo->reciboDepositoValor,
                                                                                                                                                                                                                      0,
                                                                                                                                                                                                                      ',',
                                                                                                                                                                                                                      '.') . ' que entreg&#243; por el servicio.';
    }



    $htmlContenido = str_replace(
     array(
     '%%LOGO_OXIMED%%', '%%FECHADELSERVICIO%%', '%%NOMBREEMPLEADO%%', '%%NUMRECIBO%%', '%%INFODEPOSITO%%',
     '%%DIRECCIONSERVICIO%%', '%%ORDENSERVICIO%%', '%%INFORECOGIDA%%',
     '%%CODIGOCLIENTE%%', '%%NOMBRECLIENTE%%', '%%IDENTIFICACIONCIENTE%%', '%%TELEFONOCLIENTE%%', '%%CORREOCLIENTE%%', '%%ESREFERENCIA%%',
     '%%INFOLEGAL%%', '%%TABLAEQUIPOS%%',
     ),
     array(
     URL_ARCHIVOS . Params::valor('logo_organizacion'),
     $DatosServicio->reciboFechaServicio,
     Textos::paraCorreos($DatosServicio->nombresEncargado . " " . $DatosServicio->apellidosEncargado),
     $DatosServicio->reciboNumero,
     $infoDeposito,
     Textos::paraCorreos($DatosServicio->reciboDireccion),
     $DatosServicio->servicioCodigo,
     Textos::paraCorreos("Si recibió equipos en este servicio, la fecha maxima en que deben ser devueltos los equipos es " . $DatosServicio->reciboFechaRecogida),
     $DatosServicio->clienteCodigo, $nombreCliente, $identificacionCliente, $telefonoCliente, $correoCliente, $esReferencia,
     Textos::paraCorreos(Params::valor('informacion_legal_servicio_equipos')), $tablaHtml,
     ), $htmlContenido
    );

    $mail = new Correos();
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'localhost';                            // Specify main and backup SMTP servers
    $mail->SMTPAuth = false;                              // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(Params::valor('correo_organizacion'), Textos::paraCorreos(Params::valor('nombre_organizacion')));
    $mail->addAddress('dvidal@oximeiser.com', Textos::paraCorreos('Dayana'));     // Add a recipient   
    $mail->addReplyTo(Params::valor('correo_organizacion'), Textos::paraCorreos(Params::valor('nombre_organizacion')));
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');
    $mail->addAttachment(PATH_ARCHIVOS . str_replace(array(URL_ARCHIVOS, WS), array('', DS),
                                                     $DatosServicio->documentoRecibo->documentoUrl));         // Add attachments
    if(!is_null($DatosServicio->depositoRecibo)) {
      $mail->addAttachment(PATH_ARCHIVOS . str_replace(array(URL_ARCHIVOS, WS), array('', DS),
                                                       $DatosServicio->depositoRecibo->documentoUrl));         // Add attachments
    }
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = Textos::paraCorreos('NOTIFICACIÓN DE NUEVO SERVICIO ' . strtoupper(Params::valor('nombre_organizacion')));
    $mail->Body = $htmlContenido;
    $mail->AltBody = strip_tags($mail->Body);

    if(!$mail->send()) {
      return $mail->ErrorInfo;
    } else {
      return TRUE;
    }
  }

  static
   function enviarAnuladoServicioEquipos($DatosServicio, $DatosRazon, $descripcion) {

    $htmlContenido = Archivos::leer_archivo(PATH_MODELOS . "correos" . DS . "anuladoservicioequipos.html.php");

    $motivoAnulacion = "<em><strong>".$DatosRazon->tipoMotivoTitulo . "</strong> " . $descripcion . "</em>";

    $identificacionCliente = $DatosServicio->tipoIdentificacionCodigo . "" . $DatosServicio->personaIdentificacion;
    $nombreCliente = Textos::paraCorreos($DatosServicio->personaRazonSocial);
    $telefonoCliente = $DatosServicio->personaCelular . " " . $DatosServicio->personaTelefono;
    $correoCliente = $DatosServicio->personaCorreoElectronico;
    $esReferencia = '';
    if(!is_null($DatosServicio->reciboReferencia)) {
      $esReferencia = Textos::paraCorreos('Usted está recibiendo este servicio como referencia del cliente ' . $nombreCliente . " identificado por " . $identificacionCliente);
      $identificacionCliente = "CC" . $DatosServicio->idReferencia;
      $nombreCliente = Textos::paraCorreos($DatosServicio->nombresReferencia . " " . $DatosServicio->apellidosReferencia);
      $telefonoCliente = $DatosServicio->personaCelular . " " . $DatosServicio->personaTelefono;
      $correoCliente = $DatosServicio->personaCorreoElectronico;
    }


    $tablaHtml = <<<EOD
     <table width="100%" style=" text-align: center; font-size: 100%"  cellpadding="0" >
      <tr >        
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="30%" >Tipo</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="30%" >Serial #</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="10%" >Cap.</th>
        <th style="vertical-align: bottom; border-bottom: 2px solid #ddd; font-weight: bold;" width="30%" ></th>
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
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; ">$eqTipoTitulo</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; "><strong>$EquipoServicio->equipoSerial</strong></td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; ">$EquipoServicio->equipoCapacidad</td>
        <td style="vertical-align: middle;  border-bottom: 1px solid #ccc; text-align: center; background-color: #EEEEEE;">$EquipoServicio->movimientoTitulo2</td>        
      </tr>    
EOD;
      $tablaHtml .= $filaTablaHtml;
    }
    $tablaHtml .= <<<EOD
    </table >
EOD;


    $infoDeposito = "";
    if(!is_null($DatosServicio->depositoRecibo)) {
      $infoDeposito = 'Tambi&#233;n debemos anular el documento soporte del '
       . '<strong style="font-weight: bold;">Recibo de Deposito ' . $DatosServicio->depositoRecibo->documentoConsecutivo . ' </strong> '
       . 'por valor de $' . number_format($DatosServicio->depositoRecibo->reciboDepositoValor, 0, ',', '.') . ' que entreg&#243; por el servicio. '
       . 'Espere un nuevo correo con la informaci&#243;n del nuevo documento de soporte para el Deposito entregado.';
    }



    $htmlContenido = str_replace(
     array(
     '%%LOGO_OXIMED%%', '%%FECHADELSERVICIO%%', '%%NOMBREEMPLEADO%%', '%%NUMRECIBO%%', '%%INFODEPOSITO%%',
     '%%DIRECCIONSERVICIO%%', '%%ORDENSERVICIO%%', '%%INFORECOGIDA%%',
     '%%CODIGOCLIENTE%%', '%%NOMBRECLIENTE%%', '%%IDENTIFICACIONCIENTE%%', '%%TELEFONOCLIENTE%%', '%%CORREOCLIENTE%%', '%%ESREFERENCIA%%',
     '%%INFOLEGAL%%', '%%TABLAEQUIPOS%%', '%%MOTIVOANULACION%%',
     ),
     array(
     URL_ARCHIVOS . Params::valor('logo_organizacion'),
     $DatosServicio->reciboFechaServicio,
     Textos::paraCorreos($DatosServicio->nombresEncargado . " " . $DatosServicio->apellidosEncargado),
     $DatosServicio->reciboNumero,
     $infoDeposito,
     Textos::paraCorreos($DatosServicio->reciboDireccion),
     $DatosServicio->servicioCodigo,
     "",
     $DatosServicio->clienteCodigo, $nombreCliente, $identificacionCliente, $telefonoCliente, $correoCliente, $esReferencia,
     Textos::paraCorreos(Params::valor('informacion_legal_servicio_equipos')), $tablaHtml,
     ), $htmlContenido, $motivoAnulacion
    );

    $mail = new Correos();
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'localhost';                            // Specify main and backup SMTP servers
    $mail->SMTPAuth = false;                              // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom(Params::valor('correo_organizacion'), Textos::paraCorreos(Params::valor('nombre_organizacion')));
    $mail->addAddress('dvidal@oximeiser.com', Textos::paraCorreos('Dayana'));     // Add a recipient   
    $mail->addReplyTo(Params::valor('correo_organizacion'), Textos::paraCorreos(Params::valor('nombre_organizacion')));
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');
    $mail->addAttachment(PATH_ARCHIVOS . str_replace(array(URL_ARCHIVOS, WS), array('', DS),
                                                     $DatosServicio->documentoRecibo->documentoUrl));         // Add attachments
    if(!is_null($DatosServicio->depositoRecibo)) {
      $mail->addAttachment(PATH_ARCHIVOS . str_replace(array(URL_ARCHIVOS, WS), array('', DS),
                                                       $DatosServicio->depositoRecibo->documentoUrl));         // Add attachments
    }
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = Textos::paraCorreos('NOTIFICACIÓN DE SERVICIO ANULADO EN ' . strtoupper(Params::valor('nombre_organizacion')));
    $mail->Body = $htmlContenido;
    $mail->AltBody = strip_tags($mail->Body);

    if(!$mail->send()) {
      return $mail->ErrorInfo;
    } else {
      return TRUE;
    }
  }

}
