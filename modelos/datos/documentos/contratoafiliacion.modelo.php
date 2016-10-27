<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Modelos::cargar('Documentos' . DS . 'Documentos');
Modelos::cargar('Documentos' . DS . 'Pdfs');
Modelos::cargar('Sistema' . DS . 'Cantones');
class PDFContratoAfiliacion extends Pdfs {

  static
   function generar($DatosContratoAfiliado) {
    $documentoCodigo = uniqid();
    $documentoTitulo = 'Contrato de Afiliación ' . $DatosContratoAfiliado->contratoConsecutivo;
    $nombreArchivo = $DatosContratoAfiliado->contratoConsecutivo . "-contrato-" . $documentoCodigo . ".pdf";
    $rutaArchivo = 'afiliaciones' . DS . $DatosContratoAfiliado->sedeCodigo . DS . $DatosContratoAfiliado->contratoConsecutivo . DS;
    $dirArchivo = PATH_ARCHIVOS . $rutaArchivo;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . str_replace(DS, WS, $rutaArchivo);

    $pdf = new self();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Visitante::nombreCompletoUsuario() . ";" . Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Documento de Soporte de Afiliación y Acuerdo de Pago.');
    $pdf->SetKeywords('contrato, afiliaciones,' . $DatosContratoAfiliado->contratoConsecutivo . ', ' . Visitante::nombreUsuario() . '');
    $pdf->SetFont('helvetica', '', 11, '', true);
    $pdf->AddPage();
    $formaPago = '';

    if(empty($DatosContratoAfiliado->contratoPagoInicial) or ! isset($DatosContratoAfiliado->contratoPagoInicial)) {
      $DatosContratoAfiliado->contratoPagoInicial = 0;
    }
    switch($DatosContratoAfiliado->contratoPagoInicial) {
      case $DatosContratoAfiliado->contratoValorContrato :
        $formaPago = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "formapagoPAGOTOTALContrato.html.php");
        break;
      case 0 :
        $formaPago = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "formapagoNOPAGOContrato.html.php");
        if($DatosContratoAfiliado->contratoSaldoCuotaInicial <= 0) {
          $formaPago = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "formapagoNOPAGOSINSALDOContrato.html.php");
        } else {
          if($DatosContratoAfiliado->contratoSaldoFinanciar > 0) {
            $formaPago = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "formapagoSALDOINICIALContrato.html.php");
          }
        }
        break;
      default :
        if($DatosContratoAfiliado->contratoSaldoCuotaInicial > 0) {
          if($DatosContratoAfiliado->contratoSaldoFinanciar > 0) {
            $formaPago = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "formapagoSALDOINICIALContrato.html.php");
          } else {
            $formaPago = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "formapagoSINFINANCIADOContrato.html.php");
          }
        } else {
          $formaPago = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "formapagoContrato.html.php");
        }
        break;
    }
    $formaPago = str_replace(
     array(
     '%%FECHACONTRATO%%',
     '%%VALORCONTRATO%%',
     '%%VALORCONTRATOLETRAS%%',
     '%%VALORCUOTAINICIAL%%',
     '%%VALORCUOTAINICIALLETRAS%%',
     '%%VALORSALDOCUOTAINICIAL%%',
     '%%VALORSALDOCUOTAINICIALLETRAS%%',
     '%%NUMEROCUOTASCUOTAINICIAL%%',
     '%%VALORCUOTACUOTAINICIAL%%',
     '%%VALORCUOTACUOTAINICIALLETRAS%%',
     '%%PAGOCUOTAINICIAL%%',
     '%%PAGOCUOTAINICIALLETRAS%%',
     '%%FECHAPRIMERACUOTA%%',
     '%%VALORFINACIADO%%',
     '%%VALORFINANCIADOLETRAS%%',
     '%%FECHAINICIALPRIMERACUOTA%%',
     '%%NUMEROCUOTAS%%',
     '%%VALORCUOTA%%',
     '%%VALORCUOTALETRAS%%'
     ),
     array(
     Fechas::convertirFecha2Texto($DatosContratoAfiliado->contratoFecha, 6),
     number_format($DatosContratoAfiliado->contratoValorContrato, 2),
     Numeros::a_letras($DatosContratoAfiliado->contratoValorContrato),
     number_format($DatosContratoAfiliado->contratoCuotaInicial, 2),
     Numeros::a_letras($DatosContratoAfiliado->contratoCuotaInicial),
     number_format($DatosContratoAfiliado->contratoSaldoCuotaInicial, 2),
     Numeros::a_letras($DatosContratoAfiliado->contratoSaldoCuotaInicial),
     ($DatosContratoAfiliado->contratoNumCuotasCuotaInicial),
     number_format($DatosContratoAfiliado->contratoValorCuotaCuotaInicial, 2),
     Numeros::a_letras($DatosContratoAfiliado->contratoValorCuotaCuotaInicial),
     number_format($DatosContratoAfiliado->contratoPagoInicial, 2),
     Numeros::a_letras($DatosContratoAfiliado->contratoPagoInicial),
     Fechas::convertirFecha2Texto($DatosContratoAfiliado->PlanPagosValorContrato [0]->planpagosFechaCuota, 6),
     number_format($DatosContratoAfiliado->contratoSaldoFinanciar, 2),
     Numeros::a_letras($DatosContratoAfiliado->contratoSaldoFinanciar),
     Fechas::convertirFecha2Texto($DatosContratoAfiliado->PlanPagosCuotaInicial [0]->planpagosFechaCuota, 6),
     $DatosContratoAfiliado->contratoNumCuotasFinanciar,
     $DatosContratoAfiliado->contratoValorCuotaFinanciar,
     Numeros:: a_letras($DatosContratoAfiliado->contratoValorCuotaFinanciar),
     ), $formaPago);

    $html = Archivos :: leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "contratoafiliacion.html.php");
    $html = str_replace(
     array(
     '%%FORMADEPAGO%%',
     '%%NUMEROCONTRATO%%', '%%FECHACONTRATO%%', '%%ANOSVIGENCIA%%',
     '%%NOMBREREPRESENTANTE%%', '%%CEDULAREPRESENTANTE%%',
     '%%NOMBREGRUPOEMPRESARIAL%%', '%%NOMBREEMPRESA%%', '%%IDENTIFICACIONEMPRESA%%', '%%DIRECCIONEMPRESA%%',
     '%%NOMBRECLIENTE%%', '%%IDENTIFICACIONCLIENTE%%', '%%CIUDADCLIENTE%%', '%%DIRECCIONCLIENTE%%', '%%CIUDADSEDE%%'
     ),
     array(
     $formaPago,
     $DatosContratoAfiliado->contratoConsecutivo, Fechas::convertirFecha2Texto($DatosContratoAfiliado->contratoFecha, 6),
     $DatosContratoAfiliado->contratoAnos,
     mb_strtoupper(Params::valor('nombre_gerente'), 'utf-8'),
     mb_strtoupper(Params::valor('cedula_gerente'), 'utf-8'),
     mb_strtoupper(Params::valor('grupo_empresarial'), 'utf-8'),
     mb_strtoupper(Params::valor('nombre_organizacion'), 'utf-8'),
     mb_strtoupper(Params::valor('identificacion_organizacion'), 'utf-8'),
     mb_strtoupper(Params::valor('direccion_organizacion'), 'utf-8'),
     ( mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8')),
     mb_strtoupper($DatosContratoAfiliado->titularIdentificacion, 'utf-8'),
     mb_strtoupper(Textos::limpiar(Cantones::datos($DatosContratoAfiliado->titularCanton)->cantonNombre), 'utf-8'),
     mb_strtoupper($DatosContratoAfiliado->titularDireccion, 'utf-8'),
     mb_strtoupper($DatosContratoAfiliado->contratoFirmadoen, 'utf-8'),
     ), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $firmas = self::firmas($DatosContratoAfiliado, TRUE);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);


    $pdf->AddPage();
    $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "anexo1Contrato.html.php");
    $html = str_replace(
     array(
     '',
     ), array(
     null,
     ), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);

    $htmlPortafolio = "";
    foreach($DatosContratoAfiliado->Beneficios as $objBeneficio) {
      $htmlPortafolio .= '<p align="center"> <strong>' . $objBeneficio->beneficioTitulo . (!empty($objBeneficio->beneficioPorcentaje) ? " hasta " . $objBeneficio->beneficioPorcentaje . "" : "" ) . '</strong> </p>';
    }

    $pdf->AddPage();
    $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "anexo2Contrato.html.php");
    $html = str_replace(
     array(
     '%%PORTAFOLIOSERVICIOS%%',
     '%%NUMEROCONTRATO%%',
     '%%NOMBRECLIENTE%%',
     '%%NUMEROBENEFICIARIO%%',
     '%%ANOSVIGENCIA%%',
     ),
     array(
     $htmlPortafolio,
     $DatosContratoAfiliado->contratoConsecutivo,
     ( mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8')),
     $DatosContratoAfiliado->contratoBeneficiarios,
     $DatosContratoAfiliado->contratoAnos,
     ), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);

    $pdf->AddPage();
    $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "anexo3Contrato.html.php");
    $html = str_replace(
     array(
     '',
     ), array(
     null,
     ), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);


    $pdf->Output($dirArchivo . $nombreArchivo, 'F');
    return Documentos::insertar(
      $documentoCodigo, $DatosContratoAfiliado->tipoDocId, $DatosContratoAfiliado->contratoConsecutivo,
      $documentoTitulo, $urlArchivo . $nombreArchivo
    );
  }

  static
   function pagare($DatosContratoAfiliado, $DatosPagareContrato) {
    $documentoCodigo = uniqid();
    $documentoTitulo = 'Pagaré ' . $DatosPagareContrato->pagareConsecutivo . ' del  Contrato de Afiliación ' . $DatosContratoAfiliado->contratoConsecutivo;
    $nombreArchivo = "PAGARE-" . $DatosPagareContrato->pagareConsecutivo . "-" . $documentoCodigo . ".pdf";
    $rutaArchivo = 'afiliaciones' . DS . $DatosContratoAfiliado->sedeCodigo . DS . $DatosContratoAfiliado->contratoConsecutivo . DS;
    $dirArchivo = PATH_ARCHIVOS . $rutaArchivo;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . str_replace(DS, WS, $rutaArchivo);

    $pdf = new self();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Visitante::nombreCompletoUsuario() . ";" . Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Pagaré de la Afiliación y Acuerdo de Pago.');
    $pdf->SetKeywords('pagaré, contrato, afiliaciones,' . $DatosContratoAfiliado->contratoConsecutivo . ', ' . Visitante::nombreUsuario() . '');
    $pdf->SetFont('helvetica', '', 11, '', true);
    $pdf->AddPage();

    if(!is_null($DatosContratoAfiliado->cotitularIdentificacion) and ! empty($DatosContratoAfiliado->cotitularIdentificacion)) {
      $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "pagarecotitularcontratoafiliacion.html.php");
    } else {
      $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "pagaretitularcontratoafiliacion.html.php");
    }


    $html = str_replace(
     array('%%NUMEROPAGARE%%',
     '%%NOMBRECOMPLETOTITULAR%%', '%%IDENTIFICACIONTITULAR%%', '%%NOMBRECOMPLETOCOTITULAR%%', '%%IDENTIFICACIONCOTITULAR%%',
     '%%SALDOAFINANCIARLETRAS%%', '%%SALDOAFINANCIAR%%', '%%VALORCUOTASALDO%%', '%%NUMEROCUOTAS%%', '%%FECHAPRIMERPAGOSALDO%%',
     '%%FECHAHOY%%'),
     array($DatosContratoAfiliado->contratoConsecutivo,
     mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8'),
     "C.I. N.o." . $DatosContratoAfiliado->titularIdentificacion,
     mb_strtoupper($DatosContratoAfiliado->cotitularNombres . " " . $DatosContratoAfiliado->cotitularApellidos, 'utf-8'),
     "C.I. N.o." . $DatosContratoAfiliado->cotitularIdentificacion,
     Numeros::a_letras($DatosContratoAfiliado->contratoSaldoFinanciar),
     number_format($DatosContratoAfiliado->contratoSaldoFinanciar),
     $DatosContratoAfiliado->contratoValorCuotaFinanciar, $DatosContratoAfiliado->contratoNumCuotasFinanciar,
     Fechas::convertirFecha2Texto($DatosContratoAfiliado->PlanPagosValorContrato [0]->planpagosFechaCuota, 6),
     Fechas::convertirFecha2Texto(date('Y-m-d'), 6)
     ), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);

    $pdf->Output($dirArchivo . $nombreArchivo, 'F');
    return Documentos::insertar(
      $documentoCodigo, $DatosPagareContrato->tipoDocId, $DatosPagareContrato->pagareConsecutivo, $documentoTitulo,
      $urlArchivo . $nombreArchivo
    );
  }

  static
   function pagare2($DatosContratoAfiliado, $DatosPagareContrato) {
    $documentoCodigo = uniqid();
    $documentoTitulo = 'Pagaré del Saldo de la Cuota Inicial ' . $DatosPagareContrato->pagare2Consecutivo . ' del  Contrato de Afiliación ' . $DatosContratoAfiliado->contratoConsecutivo;
    $nombreArchivo = "PAGASCI-" . $DatosPagareContrato->pagare2Consecutivo . "-" . $documentoCodigo . ".pdf";
    $rutaArchivo = 'afiliaciones' . DS . $DatosContratoAfiliado->sedeCodigo . DS . $DatosContratoAfiliado->contratoConsecutivo . DS;
    $dirArchivo = PATH_ARCHIVOS . $rutaArchivo;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . str_replace(DS, WS, $rutaArchivo);

    $pdf = new self();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Visitante::nombreCompletoUsuario() . ";" . Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Pagaré del Saldo de la Cuota Inicial de la Afiliación y Acuerdo de Pago.');
    $pdf->SetKeywords('pagaré, Saldo, Cuota Inicial contrato, afiliaciones,' . $DatosContratoAfiliado->contratoConsecutivo . ', ' . Visitante::nombreUsuario() . '');
    $pdf->SetFont('helvetica', '', 11, '', true);
    $pdf->AddPage();

    if(!is_null($DatosContratoAfiliado->cotitularIdentificacion) and ! empty($DatosContratoAfiliado->cotitularIdentificacion)) {
      $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "pagare2cotitularcontratoafiliacion.html.php");
    } else {
      $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "pagare2titularcontratoafiliacion.html.php");
    }


    $html = str_replace(
     array('%%NUMEROPAGARE%%',
     '%%NOMBRECOMPLETOTITULAR%%', '%%IDENTIFICACIONTITULAR%%', '%%NOMBRECOMPLETOCOTITULAR%%', '%%IDENTIFICACIONCOTITULAR%%',
     '%%SALDOAFINANCIARLETRAS%%', '%%SALDOAFINANCIAR%%', '%%VALORCUOTASALDO%%', '%%NUMEROCUOTAS%%', '%%FECHAPRIMERPAGOSALDO%%',
     '%%FECHAHOY%%'),
     array($DatosContratoAfiliado->contratoConsecutivo,
     mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8'),
     "C.I. N.o." . $DatosContratoAfiliado->titularIdentificacion,
     mb_strtoupper($DatosContratoAfiliado->cotitularNombres . " " . $DatosContratoAfiliado->cotitularApellidos, 'utf-8'),
     "C.I. N.o." . $DatosContratoAfiliado->cotitularIdentificacion,
     Numeros::a_letras($DatosContratoAfiliado->contratoSaldoCuotaInicial),
     number_format($DatosContratoAfiliado->contratoSaldoCuotaInicial),
     $DatosContratoAfiliado->contratoValorCuotaCuotaInicial, $DatosContratoAfiliado->contratoNumCuotasCuotaInicial,
     Fechas::convertirFecha2Texto($DatosContratoAfiliado->PlanPagosCuotaInicial [0]->planpagosFechaCuota, 6),
     Fechas::convertirFecha2Texto(date('Y-m-d'), 6)
     ), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);

    $pdf->Output($dirArchivo . $nombreArchivo, 'F');
    return Documentos::insertar(
      $documentoCodigo, $DatosPagareContrato->tipoDocId, $DatosPagareContrato->pagare2Consecutivo, $documentoTitulo,
      $urlArchivo . $nombreArchivo
    );
  }

  static
   function otroSiUso($DatosContratoAfiliado, $DatosOtroSiUsoContrato) {
    $documentoCodigo = uniqid();
    $documentoTitulo = 'OtroSí de USO ' . $DatosOtroSiUsoContrato->otroSiUsoConsecutivo . ' del Contrato de Afiliación ' . $DatosContratoAfiliado->contratoConsecutivo;
    $nombreArchivo = "OTROSI-" . $DatosOtroSiUsoContrato->otroSiUsoConsecutivo . "-" . $documentoCodigo . ".pdf";
    $rutaArchivo = 'afiliaciones' . DS . $DatosContratoAfiliado->sedeCodigo . DS . $DatosContratoAfiliado->contratoConsecutivo . DS;
    $dirArchivo = PATH_ARCHIVOS . $rutaArchivo;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . str_replace(DS, WS, $rutaArchivo);

    $pdf = new self();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Visitante::nombreCompletoUsuario() . ";" . Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Otro Sí de USO para el Contrato de Afiliación.');
    $pdf->SetKeywords('otro si, uso, contrato, afiliaciones,' . $DatosContratoAfiliado->contratoConsecutivo . ', ' . Visitante::nombreUsuario() . '');
    $pdf->SetFont('helvetica', '', 11, '', true);
    $pdf->AddPage();



    $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "otrosiusocontratoafiliacion.html.php");
    $html = str_replace(array('%%NUMEROCONTRATO%%', '%%NOMBRECOMPLETOTITULAR%%', '%%IDENTIFICACIONTITULAR%%'),
     array(
     $DatosContratoAfiliado->documentoConsecutivo,
     mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8'),
     "C.I. N.o." . $DatosContratoAfiliado->titularIdentificacion), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);

    $pdf->Output($dirArchivo . $nombreArchivo, 'F');
    return Documentos::insertar(
      $documentoCodigo, $DatosOtroSiUsoContrato->tipoDocId, $DatosOtroSiUsoContrato->otroSiUsoConsecutivo,
      $documentoTitulo, $urlArchivo . $nombreArchivo
    );
  }

  static
   function otroSiVigencia($DatosContratoAfiliado, $DatosOtroSiVigenciaContrato) {
    $documentoCodigo = uniqid();
    $documentoTitulo = 'OtroSí Vigencia ' . $DatosOtroSiVigenciaContrato->otroSiVigenciaConsecutivo . ' del Contrato de Afiliación ' . $DatosContratoAfiliado->contratoConsecutivo;
    $nombreArchivo = "OTROSIUSO-" . $DatosOtroSiVigenciaContrato->otroSiVigenciaConsecutivo . "-" . $documentoCodigo . ".pdf";
    $rutaArchivo = 'afiliaciones' . DS . $DatosContratoAfiliado->sedeCodigo . DS . $DatosContratoAfiliado->contratoConsecutivo . DS;
    $dirArchivo = PATH_ARCHIVOS . $rutaArchivo;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . str_replace(DS, WS, $rutaArchivo);

    $pdf = new self();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Visitante::nombreCompletoUsuario() . ";" . Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Otro Sí de Vigencia para el Contrato de Afiliación.');
    $pdf->SetKeywords('otrosi, vigencia, contrato, afiliaciones,' . $DatosContratoAfiliado->contratoConsecutivo . ', ' . Visitante::nombreUsuario() . '');
    $pdf->SetFont('helvetica', '', 11, '', true);
    $pdf->AddPage();

    $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "otrosivigenciacontratoafiliacion.html.php");
    $html = str_replace(array('%%NUMEROCONTRATO%%', '%%NOMBRECOMPLETOTITULAR%%', '%%IDENTIFICACIONTITULAR%%'),
     array(
     $DatosContratoAfiliado->documentoConsecutivo,
     mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8'),
     "C.I. N.o." . $DatosContratoAfiliado->titularIdentificacion), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);



    $pdf->
     Output($dirArchivo . $nombreArchivo, 'F');
    return Documentos::insertar(
      $documentoCodigo, $DatosOtroSiVigenciaContrato->tipoDocId,
      $DatosOtroSiVigenciaContrato->otroSiVigenciaConsecutivo, $documentoTitulo, $urlArchivo . $nombreArchivo
    );
  }

  static
   function cartaActivacion($DatosContratoAfiliado, $DatosCartaActivacionContrato) {
    $documentoCodigo = uniqid();
    $documentoTitulo = 'Carta de Activación ' . $DatosCartaActivacionContrato->activacionConsecutivo . ' del Contrato de Afiliación ' . $DatosContratoAfiliado->contratoConsecutivo;
    $nombreArchivo = "ACTIVACION-" . $DatosCartaActivacionContrato->activacionConsecutivo . "-" . $documentoCodigo . ".pdf";
    $rutaArchivo = 'afiliaciones' . DS . $DatosContratoAfiliado->sedeCodigo . DS . $DatosContratoAfiliado->contratoConsecutivo . DS;
    $dirArchivo = PATH_ARCHIVOS . $rutaArchivo;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . str_replace(DS, WS, $rutaArchivo);

    $pdf = new self();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Visitante::nombreCompletoUsuario() . ";" . Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('Carta de Activacion.');
    $pdf->SetKeywords('carta, activacion, contrato, afiliaciones,' . $DatosContratoAfiliado->contratoConsecutivo . ', ' . Visitante::nombreUsuario() . '');
    $pdf->SetFont('helvetica', '', 11, '', true);
    $pdf->AddPage();
    $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "cartaactivacionafiliacion.html.php");
    $html = str_replace(array('%%NOMBRECOMPLETOTITULAR%%', '%%IDENTIFICACIONTITULAR%%'),
     array(
     mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8'),
     "C.C. " . $DatosContratoAfiliado->titularIdentificacion), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);


    $pdf->Output(
     $dirArchivo . $nombreArchivo, 'F');
    return Documentos::insertar(
      $documentoCodigo, $DatosCartaActivacionContrato->tipoDocId, $DatosCartaActivacionContrato->activacionConsecutivo,
      $documentoTitulo, $urlArchivo . $nombreArchivo
    );
  }

  static
   function beneficiosOCGI($DatosContratoAfiliado, $DatosBeneficiosOCGI) {
    $documentoCodigo = uniqid();
    $documentoTitulo = 'Servicios O.C.G.I. ' . $DatosBeneficiosOCGI->activacionConsecutivo . ' del Contrato de Afiliación ' . $DatosContratoAfiliado->contratoConsecutivo;
    $nombreArchivo = "SERVICIOSOCGI-" . $DatosBeneficiosOCGI->activacionConsecutivo . "-" . $documentoCodigo . ".pdf";
    $rutaArchivo = 'afiliaciones' . DS . $DatosContratoAfiliado->sedeCodigo . DS . $DatosContratoAfiliado->contratoConsecutivo . DS;
    $dirArchivo = PATH_ARCHIVOS . $rutaArchivo;
    Archivos::probar_crear_directorio($dirArchivo);
    $urlArchivo = URL_ARCHIVOS . str_replace(DS, WS, $rutaArchivo);

    $pdf = new self();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(Visitante::nombreCompletoUsuario() . ";" . Params::valor('siglas_sistema'));
    $pdf->SetTitle($documentoTitulo);
    $pdf->SetSubject('SERVICIOS ONE CLASS GROUP INTERNACIONAL.');
    $pdf->SetKeywords('carta, activacion, contrato, afiliaciones,' . $DatosContratoAfiliado->contratoConsecutivo . ', ' . Visitante::nombreUsuario() . '');
    $pdf->SetFont('helvetica', '', 11, '', true);

    //
    //
    //
    //
    //    


    $htmlPortafolio = '<p style="text-align: center;"><strong>Resort Hasta 25%</strong></p>'
     . '<p style="text-align: center;"><strong>Renta de autos Hasta 10%</strong></p>'
     . '<p style="text-align: center;"><strong>Tiquetes a&eacute;reos Hasta 15%</strong></p>'
     . '<p style="text-align: center;"><strong>Cruceros Hasta 25%</strong></p>'
     . '<p style="text-align: center;"><strong>Hoteles Hasta 25%</strong></p>'
     . '<p style="text-align: center;"><strong>Paquetes todo incluido Hasta 25%</strong></p>'
     . '<p style="text-align: center;"><strong>Vacaciones y eventos en grupo Hasta 25%</strong></p>'
     . '<p style="text-align: center;"><strong>Deportes extremos y parques de diversi&oacute;n Hasta 10%</strong></p>';


    //
    //
    //
    
    $pdf->AddPage();
    $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "beneficiosOCGI.html.php");
    $html = str_replace(
     array(
     '%%PORTAFOLIOSERVICIOS%%',
     '%%NUMEROCONTRATO%%',
     '%%NOMBRECLIENTE%%',
     '%%NUMEROBENEFICIARIO%%',
     '%%ANOSVIGENCIA%%',
     ),
     array(
     $htmlPortafolio,
     $DatosContratoAfiliado->contratoConsecutivo,
     ( mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8')),
     $DatosContratoAfiliado->contratoBeneficiarios,
     $DatosContratoAfiliado->contratoAnos,
     ), $html);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $firmas = self::firmas($DatosContratoAfiliado);
    $pdf->writeHTMLCell(0, 0, '', '', $firmas, 0, 1, 0, true, '', true);

    //
    //
    //
    //
    //
    
    
    $pdf->Output(
     $dirArchivo . $nombreArchivo, 'F');
    return Documentos::insertar(
      $documentoCodigo, $DatosBeneficiosOCGI->tipoDocId, $DatosBeneficiosOCGI->activacionConsecutivo, $documentoTitulo,
      $urlArchivo . $nombreArchivo
    );
  }

  public static
   function firmas($DatosContratoAfiliado, $conAgencia = FALSE) {
    $html = "";
    $agencia = "";
    if($conAgencia) {
      $agencia = "agencia";
    }

    if(!is_null($DatosContratoAfiliado->cotitularIdentificacion) and ! empty($DatosContratoAfiliado->cotitularIdentificacion)) {
      $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "firmas" . $agencia . "concotitular.html.php");
      $html = str_replace(array('%%NOMBRECOMPLETOTITULAR%%'
       , '%%IDENTIFICACIONTITULAR%%', '%%NOMBRECOMPLETOCOTITULAR%%',
       '%%IDENTIFICACIONCOTITULAR%%', '%%NOMBREEMPRESA%%',
       '%%IDENTIFICACIONEMPRESA%%',),
       array(
       mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8'),
       "C.I. N.o." . $DatosContratoAfiliado->titularIdentificacion,
       mb_strtoupper($DatosContratoAfiliado->cotitularNombres . " " . $DatosContratoAfiliado->cotitularApellidos,
        'utf-8'),
       "C.I. N.o." . $DatosContratoAfiliado->cotitularIdentificacion,
       Params::valor('nombre_organizacion'),
       Params::valor('identificacion_organizacion')), $html);
    } else {
      $html = Archivos::leer_archivo(PATH_MODELOS . "documentos" . DS . "plantillas" . DS . "firmas" . $agencia . "solotitular.html.php");
      $html = str_replace(array('%%NOMBRECOMPLETOTITULAR%%', '%%IDENTIFICACIONTITULAR%%', '%%NOMBREEMPRESA%%',
       '%%IDENTIFICACIONEMPRESA%%',)
       ,
       array(
       mb_strtoupper($DatosContratoAfiliado->titularNombres . " " . $DatosContratoAfiliado->titularApellidos, 'utf-8'),
       "C.I. N.o." . $DatosContratoAfiliado->titularIdentificacion,
       Params::valor('nombre_organizacion'),
       Params::valor('identificacion_organizacion')), $html);
    } return $html;
  }

  public
   function __construct($orientation = 'P', $unit = 'mm', $unicode = true, $encoding = 'UTF-8', $diskcache = false,
   $pdfa = false) {
    parent::__construct($orientation, $unit, 'A4', $unicode, $encoding, $diskcache, true);
    // set margins
    $this->SetMargins(10, 25, 10);
    $this->SetHeaderMargin(5);
    $this->SetFooterMargin(5);
// set auto page breaks
    $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    $l = Array();
    $l['a_meta_charset'
     ] = 'UTF-8';
    $l['a_meta_dir'] = 'ltr';
    $l['a_meta_language'] = 'es';

    $l['w_page'] = 'página';
    $this->setLanguageArray($l);
  }

}