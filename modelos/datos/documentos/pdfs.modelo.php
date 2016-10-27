<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of pdfs
 *
 * @author Toshiba
 */
class Pdfs extends TCPDF {

  //put your code here

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

  public
   function Header() {
    // Logo
    $this->SetTextColor(99, 99, 99);
    $image_file = $PDF_HEADER_LOGO = PATH_ARCHIVOS . Params ::valor('logo_organizacion_opaco');
    $PDF_HEADER_LOGO_WIDTH = 100;
    $this->Image($image_file, 10, 5, 10, '', pathinfo($PDF_HEADER_LOGO, PATHINFO_EXTENSION), '', 'T', false, 300, '',
     false, false, 0, false, false, false);
    $this->SetFont('dejavusans', 'B', 9);
    $headHtml = ' 
     <table>
       <tr><td style="text-align:center;" >' . Params::valor('nombre_organizacion') . '</td></tr>
       <tr><td style="text-align:center;" >' . Params::valor('identificacion_organizacion') . '</td></tr>
       <tr><td style="text-align:center;" >Lineas de Atención</td></tr>
       <tr><td style="text-align:center;" >' . Params:: valor('telefono_organizacion') . '</td></tr>
       <tr><td style="text-align:center;" >www.oneclassecuador.com.ec</td></tr>
     </table>
';
    $this->writeHTMLCell(0, 0, '', '', $headHtml, 0, 1, 0, true, '', true);
    $this->SetTextColor(0, 0, 0)
    ;
  }

  public
   function Footer() {
    $this->SetTextColor(80, 80, 80);
    $this->SetY(-15);
    $this->SetFont('helvetica', 'I', 8);
    $this->Cell(0, 10, 'Pagina ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0,
     false, 'T', 'M');
    $this->SetTextColor(0, 0, 0);
  }

  // Load table data from file
  public function leerDatosDesdeArchivo($file) {
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line) {
      $data[] = explode(';', chop($line));
    }
    return $data;
  }


}