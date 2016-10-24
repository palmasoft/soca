<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Color
 *
 * @author BASE DE DATOS
 */
class Color {

    static function random_color_part() {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public static function random_color() {
        return self::random_color_part() . self::random_color_part() . self::random_color_part();
    }

}
