<?php

/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:28:06 a. m.
 */
class IndicadoresMetas extends Modelos {

    private static $nTabla = "indicadoresmetas";
    private static $sqlBase = "SELECT indicadoresmetas.* FROM indicadoresmetas ";
    private static $sqlCompleta = <<<EOD
    SELECT indicadoresmetas.*, indicadores.*
    FROM indicadoresmetas 
    LEFT JOIN indicadores ON indicadoresmetas.indicador_metaindicador = indicadores.id_indicador    
EOD;

    private static $sqlJoin = "";

    /**
     * 
     * @param ninguno
     * @name todos los municipio o ciudades registrados en el sistema
     * @abstract permite consultar todos los municios registrados en la base de datos.
     * 
     */
    static public function todos() {
        $query = self::$sqlBase . " ORDER BY " . self::$nTabla . ".ano_metaindicador ASC,  " . self::$nTabla . ".mes_metaindicador ASC ";
        $resultado = self::consulta($query);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return NULL;
    }

    /**
     * 
     * @param $id_metasoporte ; identificacion del estado de la matricula dentro del sistema
     * @name datos basicos asociados al estado.
     * @abstract obtiene todos los datos basicos asociados al estado de la matricula mercantil.
     * 
     */
    static public function datos($id_metaindicador) {
        self::$campos = array();
        $query = self::$sqlBase . " WHERE " . self::$nTabla . ".id_metaindicador = ? ";
        array_push(self::$campos, $id_metaindicador);
        $resultado = self::consulta($query, self::$campos);
        if (count($resultado) > 0) {
            return $resultado[0];
        }
        return NULL;
    }

    /**
     * 
     * @param $codigo_tipocaso : NOMBRE de la ciudad dentro del sistema
     * @name datos basicos asociados al municipio.
     * @abstract obtiene todos los datos basicos asociados al municipio..
     * 
     */
    static public function por_indicador($indicador_metasoporte) {
        self::$campos = array();
        $query = self::$sqlBase . " WHERE " . self::$nTabla . ".indicador_metaindicador = ? ";
        array_push(self::$campos, ($indicador_metasoporte));
        $resultado = self::consulta($query, self::$campos);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return NULL;
    }
    static public function por_ano($ano) {
        self::$campos = array();
        $query = self::$sqlBase . " WHERE " . self::$nTabla . ".ano_metaindicador = ? ";
        array_push(self::$campos, ($ano));
        $resultado = self::consulta($query, self::$campos);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return NULL;
    }
    static public function por_ano_y_mes($ano_metasoporte, $mes_metasoporte) {
        self::$campos = array();
        $query = self::$sqlBase . " WHERE " . self::$nTabla . ".ano_metaindicador = ? AND  " . self::$nTabla . ".mes_metaindicador = ?   ";
        array_push(self::$campos, ($ano_metasoporte));
        array_push(self::$campos, ($mes_metasoporte));
        $resultado = self::consulta($query, self::$campos);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return NULL;
    }
    static public function por_indicador_ano_y_mes($indicador_metasoporte, $ano_metasoporte, $mes_metasoporte) {
        self::$campos = array();
        $query = self::$sqlBase . " WHERE " . self::$nTabla . ".indicador_metaindicador = ? AND " . self::$nTabla . ".ano_metaindicador = ? AND  " . self::$nTabla . ".mes_metaindicador = ?   ";
        array_push(self::$campos, ($indicador_metasoporte));
        array_push(self::$campos, ($ano_metasoporte));
        array_push(self::$campos, ($mes_metasoporte));
        $resultado = self::consulta($query, self::$campos);
        if (count($resultado) > 0) {
            return $resultado[0];
        }
        return NULL;
    }



    //
    //
    //
    //
    //
    static public function por_componente($componente_indicador)  {
        self::$campos = array();
        $query = self::$sqlCompleta . " WHERE indicadores.componente_indicador = ? ";
        array_push(self::$campos, ($componente_indicador));
        $resultado = self::consulta($query, self::$campos);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return NULL;
    }
    static public function por_componente_por_ano($componente_indicador,$ano_metasoporte)    {
        self::$campos = array();
        $query = self::$sqlCompleta . " WHERE indicadores.componente_indicador = ? AND  " . self::$nTabla . ".ano_metaindicador = ? ";
        array_push(self::$campos, ($componente_indicador));
        array_push(self::$campos, ($ano_metasoporte));
        $resultado = self::consulta($query, self::$campos);
        if (count($resultado) > 0) {
            return $resultado;
        }
        return NULL;
    }

}
