<?php
	class Vectores{
        function convertirPostVector( $var_post){
            $datos = explode(';', $var_post);
            $res = array(); 
            foreach( $datos as $fila ){						
                $valores = explode(',', $fila);
                $vValores = array();
                foreach( $valores as $valor ){
                    $vValores[] = $valor;                     
                }
                $res[] = $vValores;
            }    
            return $res;        
        }

    }
?>