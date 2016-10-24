<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'libs/docs/excel/PHPExcel.php';
require_once 'libs/docs/excel/PHPExcel/IOFactory.php';

class Excel extends PHPExcel {

  public
   $letrasCols = array();

  function __construct() {
    parent::__construct();
    $this->letrasCols = range('a', 'z');
    foreach(range('a', 'z') AS $letra1) {
      foreach(range('a', 'z') AS $letra2) {
        array_push($this->letrasCols, $letra1 . $letra2);
      }
    }
  }

  function agregar_fila_sinindices($objPHPExcel, $arrayValores, $fila = 1, $hoja = 0) {
    $TMPobjPHPExcel = $objPHPExcel->setActiveSheetIndex($hoja);
    foreach($arrayValores as $indice => $valor) {
      $TMPobjPHPExcel = $TMPobjPHPExcel->setCellValue($this->letrasCols[$indice] . $fila, $valor);
    }
    return $objPHPExcel;
  }

  function agregar_fila($objPHPExcel, $arrayValores, $hoja = 0) {
    $TMPobjPHPExcel = $objPHPExcel->setActiveSheetIndex($hoja);
    foreach($arrayValores as $indice => $valor) {
      $TMPobjPHPExcel = $TMPobjPHPExcel->setCellValue($indice, $valor);
    }
    return $objPHPExcel;
  }

  function agregar_encabezados_sinindices($objPHPExcel, $arrayValores, $hoja = 0) {
    $hoja = $objPHPExcel->setActiveSheetIndex($hoja);
    foreach($arrayValores as $indice => $valor) {
      $hoja->setCellValue(
       $this->letrasCols[$indice] . 1, $valor
      );
    }
    return $objPHPExcel;
  }

  function agregar_encabezados($objPHPExcel, $arrayValores, $hoja = 0) {
    $TMPobjPHPExcel = $objPHPExcel->setActiveSheetIndex($hoja);
    foreach($arrayValores as $indice => $valor) {
      $TMPobjPHPExcel = $TMPobjPHPExcel->setCellValue($indice, $valor);
    }
    return $objPHPExcel;
  }

}
