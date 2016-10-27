<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'libs/docs/pdf/tcpdf/tcpdf.php';

class RecibosA5 extends TCPDF {

  public
   function __construct($orientation = 'P', $unit = 'mm', $unicode = true,
                        $encoding = 'UTF-8', $diskcache = false, $pdfa = false) {
    parent::__construct('L', $unit, 'A5', $unicode, $encoding,
                        $diskcache, $pdfa);
    // set margins
    $this->SetMargins(10, 25, 10);
    $this->SetHeaderMargin(10);
    $this->SetFooterMargin(5);
// set auto page breaks
    $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    $l = Array();
    $l['a_meta_charset'] = 'UTF-8';
    $l['a_meta_dir'] = 'ltr';
    $l['a_meta_language'] = 'es';

    $l['w_page'] = 'página';
    $this->setLanguageArray($l);
  }

  //Page header
  public
   function Header() {
    // Logo
    $image_file = $PDF_HEADER_LOGO = PATH_ARCHIVOS . Params::valor('logo_organizacion');
    $PDF_HEADER_LOGO_WIDTH = 120;
    $PDF_HEADER_TITLE = "Servicio de Arrendamiento de Equipos";
    $PDF_HEADER_STRING = "Recibo de Servicio.";

    $this->Image($image_file, 10, 5, 40, '',
                 pathinfo($PDF_HEADER_LOGO, PATHINFO_EXTENSION), '', 'T', false,
                          300, '', false, false, 0, false, false, false);
    $this->SetFont('dejavusans', 'B', 8);




    $headHtml = ' 
     <table>
       <tr><td style="text-align:center;" >' . Params::valor('nombre_organizacion') . '</td></tr>
       <tr><td style="text-align:center;" >N.I.T. ' . Params::valor('identificacion_organizacion') . '</td></tr>
       <tr><td style="text-align:center;" >' . Params::valor('direccion_organizacion') . '</td></tr>
       <tr><td style="text-align:center;" >' . Params::valor('telefono_organizacion') . ' - ' . Params::valor('celular_organizacion') . '</td></tr>
       <tr><td style="text-align:center;" >' . Params::valor('correo_organizacion') . '</td></tr>
     </table>
';
    $this->writeHTMLCell(0, 0, '', '', $headHtml, 0, 1, 0, true, '', true);
  }

  // Page footer
  public
   function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Page number
    $this->Cell(0, 10,
                'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(),
                0, false, 'C', 0, '', 0, false, 'T', 'M');
  }

}
