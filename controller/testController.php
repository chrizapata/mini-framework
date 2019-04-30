<?php
/*
##########################################
##########################################
  				OBJETOS
##########################################
##########################################
*/
/*

INSTANCIA DE OBJETOS: Para instanciar objeto, el objeto debe contener el mismo nombre de la tabla en la Base de Datos y
nombre del archvo de los Modelos:
NOMBRE_TABLA (STRING): Nombre de la tabla, la cual debe ser igual que el archivo Model y nombre de tabla
TABLAS_FORANEAS (ARRAY): Contiene el nombre de las tablas que son foraneas de una tabla
RELACINOES_TABLAS (STRING): Se puede añadir manualmente las relaciones de las tablas hijas para las FK

//Arreglo con el nombre de las tablas foraneas
$tablas_foraneas=array('tabla_1',tabla_2,...);
//Instancia de objeto con tabla con tablas foraneas
$objeto_usuario=new usuario('nombre_tabla',$tablas_foraneas);

//Instancia de objeto con tabla sin relaciones con otras tablas
$objeto_usuario=new usuario('nombre_tabla');

*/

//Nombre de la vista
$nombre_modulo = 'test';
//Contiene el nombre de la vista del Módulo
$nombre_vista = 'view/test/'.$nombre_modulo.'.php';
//Tablas Foreaneas de la tabla del usuario
$tablas_foraneas=array('usuario');
//Objeto NOTAS
$obj_nota = new nota('nota',$tablas_foraneas);
//Objeto USUARIO
$obj_usuario = new usuario('usuario');
//Objeto LOG
$obj_log = new log('log');
//Objeto Validador
$obj_validador = new validador();

//Arreglo para obtener las columnas que se requieren de la consulta para mostrar las notas
$columnas_notas[0]='id_nota';$columnas_notas[1]='descripcion_nota';$columnas_notas[2]='tipo_nota';$columnas_notas[3]='descripcion_nota';$columnas_notas[4]='fecha_hora_nota';$columnas_notas[5]='nombre_usuario';
//Arreglo de condiciones para obtener las notas activas
$condiciones_notas[5]=1;
//Instancia para obtener todas las notas
$notas=$obj_nota->consultaAvanzada($columnas_notas,$condiciones_notas,'','','D');

//Validación para comprobar que se haya enviado información
if($_POST){

	//VARIABLES DEL CONTROLLER
	//Contiene el nombre del formulario de nuestra aplicación sin WWW
	$url_formulario_envio = $url_formulario.'?modulo='.$nombre_modulo;
	//Contiene el nombre del formulario de nuestra aplicación conn WWW
	$url_formulario_envio_www = $url_formulario_www.'?modulo='.$nombre_modulo;
	//Contiene el error del servidor
	$error_server = false;

	//Validación para corroborar que la información sea envíada desde nuestra aplicación
	if($obj_validador->validarFormularioEnvio($parametro_formulario,$url_formulario_envio,$url_formulario_envio_www)){
		
		//Contiene la acción que realizo el Usuario
		$accion_log = 'ALERTA: Un usuario intento añadir información desde un sitio externo.';
		//Contiene los valores para almacenar en la tabla LOG
		$valores_log = array('',$accion_log,$fecha_hora);
		//Instancia para guardar un LOG
		$obj_log->guardar($valores_log);
		//Eliminación de arreglos
		unset($valores_log);
		//Envío de notificación
		echo 'FO';

	}
	else{

		//Permite extraer la información envíada
		foreach($_POST as $clave => $valor) $$clave=addslashes(trim($valor));
		sleep(1);

		//Validación para saber que acción se llevará a cabo
		if($tipo_informacion=='nota'){

			if(!$obj_validador->campoObligatorio('texto',$nota,4,700)){
	
				//Contiene la acción que realizo el Usuario
				$accion_log = 'Un usuario intento añadir una nota con parametros invalidos.';
				//Contiene los valores para almacenar en la tabla LOG
				$valores_log = array('',$accion_log,$fecha_hora);
				//Instancia para guardar un LOG
				$obj_log->guardar($valores_log);
				//Eliminación de arreglos
				unset($valores_log);
				//Variable de error
				$error_server = true;
				//Envío de notificación
				echo 'NO';

			}
			if($error_server){

				return;				

			}
			else{

				//Para guardar con los saltos de líneas
				$nota=str_replace("\n","<br>",$nota);
				//Arreglo para guardar la nota al ticket
				$columna_nota=array('',$nota,$tipo_nota,$fecha_hora,1,1);
				//Validación e instancia para añadir notas
				if(!$obj_nota->guardar($columna_nota)){

					//Contiene la acción que realizo el Usuario
					$accion_log = 'ERROR DE SISTEMA (Línea 114): El sistema tuvo un error cuando un usuario intento añadir una nueva nota, sin almacenarse correctamente.';
					//Contiene los valores para almacenar en la tabla LOG
					$valores_log = array('',$accion_log,$fecha_hora);
					//Instancia para guardar un LOG
					$obj_log->guardar($valores_log);
					//Eliminación de Arreglos
					unset($columna_nota,$valores_log);
					//Envío de notificación
					echo 'EE';

				}
				else{

					//Eliminación de Arreglos
					unset($arreglo_columna_nota);

					//Contiene la acción que realizo el Usuario
					$accion_log ='Un usuario añadió una nueva nota.';
					//Contiene los valores para almacenar en la tabla LOG
					$valores_log = array('',$accion_log,$fecha_hora);
					//Instancia para guardar un LOG
					$obj_log->guardar($valores_log);
					//Eliminacion de arreglos
					unset($columna_nota,$valores_log);
					//Envío de notificación
					echo 'OK';

				}

			}	

		}
		else if($tipo_informacion=='eliminar_nota'){

			//Columnas para consultar las Notas 
			$arreglo_columna_nota[0]='descripcion_nota';$arreglo_columna_nota[1]='tipo_nota';$arreglo_columna_nota[2]='fecha_hora_nota';$arreglo_columna_nota[3]='nombre_usuario';
			//Arreglo de Oncidciones para las Ntas 
			$arreglo_condiciones_nota[0]=$id_nota;$arreglo_condiciones_nota[5]=1;
			//Instancia para obtener las NOTAS 
			if(!$informacion_nota_eliminada=$obj_nota->consultaAvanzada($arreglo_columna_nota,$arreglo_condiciones_nota)){

				//Contiene la acción que realizo el Usuario
				$accion_log ='Un usuario intento eliminar una nota, la cual no existe o está ya eliminada.';
				//Contiene los valores para almacenar en la tabla LOG
				$valores_log = array('',$accion_log,$fecha_hora);
				//Instancia para guardar un LOG
				$obj_log->guardar($valores_log);
				//Eliminación de Arreglos
				unset($arreglo_columna_nota,$valores_log,$arreglo_condiciones_nota);

			}
			else{

				//Eliminación de Arreglos
				unset($arreglo_columna_nota,$arreglo_condiciones_nota);

				//Arreglo de columnas para Eliminar una nota
				$arreglo_columna_nota[5]=0;
				//Arreglo de Condiciones para eliminar una nota
				$arreglo_condiciones_nota[0]=$id_nota;
				//Instancia y validación para eliminar la nota
				if(!$obj_nota->actualizar($arreglo_columna_nota,$arreglo_condiciones_nota)){

					//Contiene la acción que realizo el Usuario
					$accion_log = 'ERROR DE SISTEMA (Línea 179): Un usuario intento eliminar una nota sin poder eliminarla.';
					//Contiene los valores para almacenar en la tabla LOG
					$valores_log = array('',$accion_log,$fecha_hora);
					//Instancia para guardar un LOG
					$obj_log->guardar($valores_log);
					//Eliminación de Arreglos
					unset($arreglo_columna_nota,$arreglo_condiciones_nota,$valores_log);
					//Envío de notificación
					echo 'EE';

				}
				else{

					//Contiene la acción que realizo el Usuario
					$accion_log = 'Un usuario elimino una nota.';
					//Contiene los valores para almacenar en la tabla LOG
					$valores_log = array('',$accion_log,$fecha_hora);
					//Instancia para guardar un LOG
					$obj_log->guardar($valores_log);
					//Eliminación de Arreglos
					unset($arreglo_columna_nota,$arreglo_condiciones_nota,$valores_log);
					//Envío de notificación
					echo 'OK';

				}

			}

		}
		else if($tipo_informacion=='ver_seguimiento'){

			//Columnas para consultar las Notas 
			$arreglo_columna_nota[0]='descripcion_nota';$arreglo_columna_nota[1]='tipo_nota';$arreglo_columna_nota[2]='fecha_hora_nota';$arreglo_columna_nota[3]='nombre_usuario';$arreglo_columna_nota[4]='id_nota';
			//Arreglo de Oncidciones para las 
			$arreglo_condiciones_nota[5]=1;
			//Instancia para obtener las NOTAS 
			$seguimiento_reciente=$obj_nota->consultaAvanzada($arreglo_columna_nota,$arreglo_condiciones_nota,'','','D',0,1);
			//Eliminación de Arreglos
			unset($arreglo_columna_nota,$arreglo_condiciones_nota);
			//
			$resultado['id_nota']=$seguimiento_reciente[0]['id_nota'];$resultado['descripcion_nota']=$seguimiento_reciente[0]['descripcion_nota'];$resultado['tipo_nota']=$seguimiento_reciente[0]['tipo_nota'];$resultado['fecha_hora_nota']=$seguimiento_reciente[0]['fecha_hora_nota'];$resultado['nombre_usuario']=$seguimiento_reciente[0]['nombre_usuario'];
			//Se envía la información
			echo json_encode($resultado);
			return;

		}

	}

}
	
//Contiene la ruta para mostrar la vista del Módulo
include($nombre_vista);
?>