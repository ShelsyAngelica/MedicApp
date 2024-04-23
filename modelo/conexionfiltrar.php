<?php
    class Conexion {
        public static function conectar(){
            define('SERVIDOR','localhost');
            define('NOMBRE_BD','fisiohumana');
            define('USUARIO','root');
            define('PASSWORD','');

            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            try{
                $conexion = new PDO("mysql:host=".SERVIDOR."; dbname=".NOMBRE_BD, USUARIO, PASSWORD, $opciones);
                return $conexion;
            } catch(Exception $e){
                die ("Error de conexion". $e->getMessage());
            }
        }
    }
?>