<?php
//phpinfo();
/*
##########################################
##########################################
######## Versión 5.1          ############
##########################################
##########################################
*/
//Zona de horario de México
date_default_timezone_set('America/Mexico_City');
//Contiene la fecha y Hora de Server
setlocale(LC_ALL, 'es_MX');
//Hora del Día
$hora_actual_dia = utf8_encode(ucwords (strftime("%H")));
//Fecha para documentar en el sistema
$fecha_hora = utf8_encode(ucwords (strftime("%A %d de %B del %Y %H:%M:%S")));
//Fecha para añadir a la documentación
$fecha_documentacion = utf8_encode(ucwords (strftime("%A %d de %B del %Y")));
//Archivo para que se hagan llamado de las Clases instanciadas
include('model/includes.php');

/*
##########################################
##########################################
  DATOS PARA CONECTAR A LA BASE DE DATOS
##########################################
##########################################
*/
//Nombre del Servidor
define('SERVIDOR','localhost');
//Usuario de la Base de Datos
define('USUARIO_DB','root');
//Contraseña de la Base de Datos
define('CONTRASENA_DB','');
//Nombre de la Base de Datos
define('NOMBRE_DB','test');


/*
##########################################
##########################################
  PARÁMETROS DE CONFIGURACIÓN DE PROYECTO
##########################################
##########################################
*/
//URL de Formulario para comprobar que la información provenga desde el Sistema
$url_formulario = '127.0.0.1/cv/';
//URL de Formulario para comprobar que la información provenga desde el Sistema
$url_formulario_www = '127.0.0.1/cv/';
//Correo para enviar notificaciones de Warnings o Errores dentro del Sistema
$correo_soporte = '';
//URL de los controladores del sistema
$nombre_carpeta_controller = 'controller/';
//Contiene nombre de los controladores del sistema
$nombre_controller = 'Controller.php';
//Permite redireccionar los archivos según Locales (L) o Producción (P)
$parametro_formulario = 'L';

//Validación para mostrar archivos comprimidos
if($parametro_formulario != 'L'){

	//Ruta de CSS para producción, ya comprimidos
	$ruta_css = 'css/';

}
else{

	//Ruta de CSS para producción, sin comprimir
	$ruta_css = 'css-local/';	

}


//Validación para saber que modulo se encuentra el usuario
if(!empty($_GET['modulo'])){

	//Se toma el nombre del módulo pasado por el GET
	$modulo = $_GET['modulo'];

}
else{

	$modulo = 'test';

}

/*
##########################################
##########################################
 PARÁMETROS DE LLAMADO DE VISTAS Y MODELOS
##########################################
##########################################
*/
if($_GET){

	//Validación para mostrar a la Vista el Modulo visitado por el Usuario
	if(is_file($nombre_carpeta_controller.$modulo.$nombre_controller)){

		//Se hace llamado del archivo controlador solicitado
		require_once($nombre_carpeta_controller.$modulo.$nombre_controller);

	}
	else if(is_file($nombre_carpeta_controller.$modulo.$nombre_controller) AND !$_GET['modulo']){

		header("Location: ?modulo=".$modulo);

	}
	else{

		//Se hace llamado del archivo controlador del INDEX
		require_once($nombre_carpeta_controller.$modulo.$nombre_controller);

	}

}
else{

	header("Location: ?modulo=".$modulo);

}
?>