<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Xml
 *
 * @author BASE DE DATOS
 */
class Xml {

    //put your code here

    public static function datos_en_archivo($nombre_archivo, $ruta = "") {
        $xmlContenido = Archivos::leer_archivo($ruta . $nombre_archivo . '.xml');
        if (!empty($xmlContenido)) {
            return new SimpleXMLElement($xmlContenido);
        }
        return NULL;
    }

}
