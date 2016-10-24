<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consola
 *
 * @author BASE DE DATOS
 */
class Consola {

    static $activada = false;

    static function imprimir($texto) {
        if (self::$activada) {
            echo ($texto);
        }else{            
            //echo ($texto."<br/>");
            //Archivos::escribir_log("mensajes.html", $texto);
        }
    }

}
