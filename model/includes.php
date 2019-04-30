<?php
ini_set("session.cookie_lifetime", 10800);
ini_set("session.gc_maxlifetime", 10800);
//Se inicia la Sesión de usuario
session_start();

//Extrae el nombre de un Archivo con su extensión
$c_info = pathinfo(__FILE__);
$c_directorio = $c_info['dirname'];

//Llamado del archivo de las funciones
require_once($c_directorio . "/functions.php");

//Llamado del archivo de la conexión de la Base de Datos
include ($c_directorio ."/conexion.php");

?>