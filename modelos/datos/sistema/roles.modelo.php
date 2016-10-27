<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
class Roles extends Modelos {

    private static $id_cargo;
    private $codigo_cargo;
    private $nombre_cargo;
    private $permisos_cargo = '{}';
    private static $nTabla = "roles";
    private static $sqlBase = "SELECT roles.* FROM roles ";
    private static $sqlCompleta = " ";

    public static function todos() {
        $query = self::$sqlBase;
        $consulta = self::consulta($query);
        if (count($consulta) > 0) {
            return $consulta;
        }
        return 0;
    }

}
