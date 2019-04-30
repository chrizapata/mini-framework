<?php
//Versión 0.7.5
//LOG
class log extends conexion{

	//ATRIBUTOS
	//Nombre de la tabla Clase
	private $tabla_clase = null;
	//Nombre de las tablas Foraneas
	private $tablas_foraneas = null;
	//Nombre de las columnas del Query del usuario
	private $nombre_columnas = ' * ';
	//Relaciones entre tablas foraneas
	private $relaciones_tablas = null;
	//Inicial de las columnas ID de tablas foraneas
	private $id_foraneas = 'id_';
	//Inicial de las columnas FK de la tabla Clase
	private $fk_clase = 'fk_';


	//MÉTODOS
	//Constructor
	public function __construct($tabla_clase,$tablas_foraneas=null,$relaciones_tablas=null){
		
		//Nombre de la tabla Clase
		$this->tabla_clase = $tabla_clase;

		//Validación en caso de que el usuario no haya pasado tablas foraneas
		if($tablas_foraneas){
		
			//Nombre de las tablas Foraneas
			$this->tablas_foraneas = ','.implode(',',$tablas_foraneas);
			//Relaciones entre las tablas
			$this->relaciones_tablas = $relaciones_tablas;

		}

	}


	//Método del Destructor
	public function __destruct(){
		
		//Desctrucción de métodos y atributos de Objeto
		unset($this->tabla_clase,$this->tablas_foraneas,$this->nombre_columnas,$this->relaciones_tablas,$this->id_foraneas,$this->fk_clase);

	}


	//Método para realizar consulta
	public function consulta($columnas_consulta=null,$condiciones_consulta=null,$operadores_consulta=null,$columna_orden=null,$orden_consulta='A',$numero_pagina=null,$numero_resultados=null){
		
		//COLUMNAS DE CONSULTA
		//Instancia para validar que sea Array las columnas
		if(is_array($columnas_consulta) OR is_object($columnas_consulta)){
			
			//Instancia de método para obtener el nombre de las columnas a consultar
			if(!$this->nombre_columnas = $this->nombreColumnasConsulta($columnas_consulta,'Avanzada')){
			
				return false;	

			}

		}

		//Validación para construir las relaciones entre tablas en caso de que haya tablas foraneas
		if($this->tablas_foraneas && !$this->relaciones_tablas){
			
			//Las tablas foraneas se convierten en Array nuevamente
			$tablas = explode(',',$this->tablas_foraneas);
			//Instancia de Método para crear las relaciones entre tablas
			if(!$this->relaciones_tablas = $this->creacionRelacionesTablas($tablas)){
			
				return false;

			}

		}

		//CONDICIONES WHERE
		//Validación condiciones de una consulta
		if(is_array($condiciones_consulta) OR is_object($condiciones_consulta)){

			//Intancia de Método para crear las condiciones de una consulta
			if(!$where = $this->creacionCondicionesConsulta($condiciones_consulta,$operadores_consulta)){

				return false;

			}
			else{

				//Validación para agregar el AND
				if($this->relaciones_tablas){

					//Se añade el signo AND para construri correctamente la consulta
					$where = ' AND '.$where;

				}

			}

		}
		else{

			//Se pasa en blanco las condiciones de una consulta
			$where = null;

		}

		//COLUMNA DE ORDEN
		//Validación para cambiar el nombre de la columna en el orden que se mostrará la información
		if(!$columna_orden OR !is_array($columna_orden) OR !is_object($columna_orden)){

			//Se crea la columna ID de la clase para ordenar por ID
			$nombre_columna_orden = $this->id_foraneas.$this->tabla_clase;

		}
		else{

			//Instancia y validación para obtener el nombre de la columna en que se ordenará la consulta
			if(!$nombre_columna_orden = $this->nombreColumnaOrden($columna_orden)){

				return false;

			}

		}

		//ORDEN DE CONSULTA
		//Validación para el tipo de Orden ASC o DESC
		if($orden_consulta == 'A'){

			//Tener el orden Ascedente
			$tipo_orden = 'ASC';

		}
		else{

			//Tener la consulta en Descendente
			$tipo_orden = 'DESC';			

		}

		//LIMIT
		//Validación para agregar LIMIT en la Consulta para paginar
		if($numero_pagina && $numero_resultados){

			//COnstrucción del LIMIT
			$limite_resultados = ' LIMIT '.$numero_pagina.','.$numero_resultados;

		}
		else{

			//Se deja en blanco el LIMIT
			$limite_resultados = null;			

		}

		//Construcción de la sentencia SQL para consultar información
		$consulta_sql = "SELECT $this->nombre_columnas FROM $this->tabla_clase$this->tablas_foraneas WHERE $this->relaciones_tablas $where ORDER BY $nombre_columna_orden $tipo_orden $limite_resultados;";	
		//Validación e instancia para realizar la consulta
		if(!$informacion = $this->consultaMultiple($consulta_sql)){

			return false;

		}
		else{

			return $informacion;

		}
		
	}

	
	//Método para realizar consulta con tablas foraneas
	public function consultaAvanzada($columnas_consulta=null,$condiciones_consulta=null,$operadores_consulta=null,$columna_orden=null,$orden_consulta='A',$numero_pagina=null,$numero_resultados=null){

		//COLUMNAS DE CONSULTA
		//Declaración de Array en blanco para los nombres de las columnas
		$this->nombre_columnas = array();
		//Instancia para validar que sea Array las columnas
		if(is_array($columnas_consulta) OR is_object($columnas_consulta)){
			
			//Instancia de método para obtener el nombre de las columnas a consultar
			if(!$this->nombre_columnas = $this->nombreColumnasConsulta($columnas_consulta,'Avanzada')){
			
				//Regreso de Falso por error al obtener el nombre de las columnas a consultar
				return false;	

			}

		}
		else{

			//Para consultar todas las columnas de una tabla
			$this->nombre_columnas = '*';

		}

		//Validación para construir las relaciones entre tablas en caso de que haya tablas foraneas
		if($this->tablas_foraneas && !$this->relaciones_tablas){
			
			//Las tablas foraneas se convierten en Array nuevamente
			$tablas = explode(',',$this->tablas_foraneas);
			//Instancia de Método para crear las relaciones entre tablas
			if(!$this->relaciones_tablas = $this->creacionRelacionesTablas($tablas)){
			
				return false;

			}

		}

		//CONDICIONES WHERE
		//Validación condiciones de una consulta
		if(is_array($condiciones_consulta) OR is_object($condiciones_consulta)){

			//Intancia de Método para crear las condiciones de una consulta
			if(!$where = $this->creacionCondicionesConsulta($condiciones_consulta,$operadores_consulta)){

				return false;

			}
			else{

				//Validación para agregar el AND
				if($this->relaciones_tablas){

					//Se añade el signo AND para construri correctamente la consulta
					$where = ' AND '.$where;

				}

			}

		}
		else{

			//Se pasa en blanco las condiciones de una consulta
			$where = null;

		}

		//COLUMNA DE ORDEN
		//Validación para cambiar el nombre de la columna en el orden que se mostrará la información
		if(!$columna_orden OR !is_array($columna_orden) OR !is_object($columna_orden)){

			//Se crea la columna ID de la clase para ordenar por ID
			$nombre_columna_orden = $this->id_foraneas.$this->tabla_clase;

		}
		else{

			//Instancia y validación para obtener el nombre de la columna en que se ordenará la consulta
			if(!$nombre_columna_orden = $this->nombreColumnaOrden($columna_orden)){

				return false;

			}

		}

		//ORDEN DE CONSULTA
		//Validación para el tipo de Orden ASC o DESC
		if($orden_consulta == 'A'){

			//Tener el orden Ascedente
			$tipo_orden = 'ASC';

		}
		else{

			//Tener la consulta en Descendente
			$tipo_orden = 'DESC';			

		}

		//LIMIT
		//Validación para agregar LIMIT en la Consulta para paginar
		if($numero_resultados){

			//COnstrucción del LIMIT
			$limite_resultados = ' LIMIT '.$numero_pagina.','.$numero_resultados;

		}
		else{

			//Se deja en blanco el LIMIT
			$limite_resultados = null;			

		}

		//Construcción de la sentencia SQL para consultar información
		$consulta_sql = "SELECT $this->nombre_columnas FROM $this->tabla_clase$this->tablas_foraneas WHERE $this->relaciones_tablas $where ORDER BY $nombre_columna_orden $tipo_orden $limite_resultados;";	
		//Validación e instancia para realizar la consulta
		if(!$informacion = $this->consultaMultiple($consulta_sql)){

			return false;

		}
		else{

			return $informacion;

		}
		
	}


	//Método para realizar consulta con de la Tabla de la clase
	public function consultaBasica($columnas_consulta=null,$condiciones_consulta=null,$operadores_consulta=null,$columna_orden=null,$orden_consulta='A',$numero_pagina=null,$numero_resultados=null){

		//COLUMNAS DE CONSULTA
		//Declaración de Array en blanco para los nombres de las columnas
		$this->nombre_columnas = array();
		//Instancia para validar que sea Array las columnas
		if(is_array($columnas_consulta) OR is_object($columnas_consulta)){
			
			//Instancia de método para obtener el nombre de las columnas a consultar
			if(!$this->nombre_columnas = $this->nombreColumnasConsulta($columnas_consulta,'Basica')){
			
				//Eliminación de Array de las columnas
				unset($columnas_consulta);
				//Regreso de Falso por error al obtener el nombre de las columnas a consultar
				return false;	

			}

		}
		else{

			//Para consultar todas las columnas de una tabla
			$this->nombre_columnas = '*';

		}

		//CONDICIONES WHERE
		//Validación condiciones de una consulta
		if(is_array($condiciones_consulta) OR is_object($condiciones_consulta)){

			//Intancia de Método para crear las condiciones de una consulta
			if(!$where = $this->creacionCondicionesConsulta($condiciones_consulta,$operadores_consulta)){

				return false;

			}
			else{

				//Construcción del Where para consulta Básica
				$where = ' WHERE '.$where;

			}

		}
		else{

			//Se pasa en blanco las condiciones de una consulta
			$where = null;

		}

		//COLUMNA DE ORDEN
		//Validación para cambiar el nombre de la columna en el orden que se mostrará la información
		if(!$columna_orden OR !is_array($columna_orden) OR !is_object($columna_orden)){

			//Se crea la columna ID de la clase para ordenar por ID
			$nombre_columna_orden = $this->id_foraneas.$this->tabla_clase;

		}
		else{

			//Instancia y validación para obtener el nombre de la columna en que se ordenará la consulta
			if(!$nombre_columna_orden = $this->nombreColumnaOrden($columna_orden)){

				return false;

			}

		}

		//ORDEN DE CONSULTA
		//Validación para el tipo de Orden ASC o DESC
		if($orden_consulta == 'A'){

			//Tener el orden Ascedente
			$tipo_orden = 'ASC';

		}
		else{

			//Tener la consulta en Descendente
			$tipo_orden = 'DESC';			

		}

		//LIMIT
		//Validación para agregar LIMIT en la Consulta para paginar
		if($numero_pagina && $numero_resultados){

			//COnstrucción del LIMIT
			$limite_resultados = ' LIMIT '.$numero_pagina.','.$numero_resultados;

		}
		else{

			//Se deja en blanco el LIMIT
			$limite_resultados = null;			

		}

		//Construcción de la sentencia SQL para consultar información
		$consulta_sql = "SELECT $this->nombre_columnas FROM $this->tabla_clase $where ORDER BY $nombre_columna_orden $tipo_orden $limite_resultados;";	
		//Validación e instancia para realizar la consulta
		if(!$informacion = $this->consultaMultiple($consulta_sql)){

			return false;

		}
		else{

			return $informacion;

		}
		
	}


	//Método para guardar información de la tabla clase
	public function guardar($informacion){

		//Validación para confirmar que haya pasado un Arreglo con la información que se guardara
		if(is_array($informacion) OR is_object($informacion)){

			//Instancia para obtener el nombre de las columnas de la tabla de la Clase
			$nombre_columnas_tabla = $this->nombresColumnasTablaClase($this->tabla_clase);
			//Indice para el nuevo arreglo
			$z = 0;
			//Validación para sólo consultar en la tabla de la clase las columnas
			if(count($nombre_columnas_tabla) >= count($informacion)){

				//Bucle para construir la información a guardar
				for($i = 0; $i < sizeof($informacion); $i++){

					//Almacenaje de las columnas y la información a guardar
					$columnas_guardar[$z] = "'".$informacion[$i]."'";
					//Incremento del indice del arreglo final
					$z++;

				}

				//Conversión de Array a String para guardar la información
				$datos_guardar = implode(',',$columnas_guardar);
				//Creación del script de SQL para guardar
				$consulta_sql = "INSERT INTO $this->tabla_clase() VALUES ($datos_guardar)";
				//Validación e instancia para realizar la consulta
				if(!$this->consultaSimple($consulta_sql)){

					return false;

				}
				else{

					return true;

				}

			}
			else{

				return false;				

			}

		}
		else{

			return false;

		}

	}


	//Método para actualizar información de la tabla clase
	public function actualizar($columnas_actualizar,$columnas_condiciones,$operadores_edicion=null){

		//Validación de que sea un Array las columnas a actualizar
		if(is_array($columnas_actualizar) OR is_object($columnas_actualizar)){

			//Instancia para obtener el nombre de las columnas de la tabla de la Clase
			$nombre_columnas_tabla = $this->nombresColumnasTablaClase($this->tabla_clase);
			//Indice para el nuevo arreglo
			$z = 0;
			//Validación para sólo consultar en la tabla de la clase las columnas
			if(count($nombre_columnas_tabla) >= count($columnas_actualizar)){

				//Bucle para obtener las columnas a editar
				for($i = 1; $i < sizeof($nombre_columnas_tabla); $i++){

					//Validación para evitar agregar un campo con indice que no existe
					if(isset($columnas_actualizar[$i])){

						//Construcción de la columna a actualizar
						$columnas_editar[$z] = $nombre_columnas_tabla[$i]." = '".$columnas_actualizar[$i]."'";
						//Incremento del indice del arreglo final
						$z++;

					}

				}

				//Validación para confirmar que haya un arreglo de columnas de condiciones
				if(is_array($columnas_condiciones) OR is_object($columnas_condiciones)){

					//Validación para sólo consultar en la tabla de la clase las columnas
					if(count($nombre_columnas_tabla) >= count($columnas_condiciones)){

						//Indice para el nuevo arreglo
						$x = 0;
						//Bucle para obtener las condiciones para actualizar
						for($i = 0; $i < sizeof($nombre_columnas_tabla); $i++){

							//Validación para obtener los operadores de una actualización
							if(!$operadores_edicion[$i]){

								//Contiene el sigo =
								$operador_logico = ' = ';

							}
							else{

								//Contiene el operador lógico ingresado en el arreglo
								$operador_logico = $operadores_edicion[$i];

							}

							//Validación para evitar contar un indice sin información
							if(isset($columnas_condiciones[$i])){

								//Validación para evitar agregar al WHERE condición vacia
								if($columnas_condiciones[$i]){

									$columna_condicion[$x] = $nombre_columnas_tabla[$i].$operador_logico."'".$columnas_condiciones[$i]."'";

								}

							}

							//Incremento del indice del arreglo del WHERE
							$x++;

						}

					}
					else{
						
						return false;	

					}

				}
				else{
					
					return false;

				}

				//Conversión de Array a String para editar la información de columnas
				$set = implode(',',$columnas_editar);
				//Conversión de Array a String para las condiciones para actualizar
				$where = implode(' AND ',$columna_condicion);
				//Creación del script de SQL para guardar
				$consulta_sql = "UPDATE $this->tabla_clase SET $set WHERE $where";
				//Validación e instancia para realizar la consulta
				if(!$this->consultaSimple($consulta_sql)){
					
					return false;

				}
				else{
					
					return true;

				}

			}
			else{
				
				return false;

			}

		}
		else{
			
			return false;

		}

	}


	//Método para obtener el nombre de las columnas en una consulta
	public function nombreColumnasConsulta($columnas_consulta,$tipo_consulta){
		
		//Instancia para obtener el nombre de las columnas de la tabla de la Clase
		$nombre_columnas_tabla = $this->nombresColumnasTablaClase($this->tabla_clase,$tipo_consulta);
		//Validación para sólo consultar en la tabla de la clase las columnas
		if(count($nombre_columnas_tabla) >= count($columnas_consulta)){

			//Indice del arreglo que tendrá el nombre de la columnas
			$z = 0;
			//Bucle para recorrer y obtener el nombre de las columnas
			for($i = 0; $i < sizeof($nombre_columnas_tabla); $i++){

				//Validación para ignorar los indices no definidos
				if(isset($columnas_consulta[$i])){
		
					//Validación para ir agregando al arreglo final los nombres de las columnas
					if($columnas_consulta[$i] !== true){
			
						//Consultamos en el array que exista el nombre de la columna
						$nombre_columna = array_search($columnas_consulta[$i],$nombre_columnas_tabla);
						//Validación para confirmar que exista el nombre de la columna
						if($nombre_columna === false){
						}
						else{

							//Se almacena el nombre de la columna
							echo $nombre_columnas_consulta [$z] = $columnas_consulta[$i];
						}

					}
					else{

						//Se agrega el nombre de la columna al arreglo final
						$nombre_columnas_consulta [$z] = $nombre_columnas_tabla[$i];
						//Incremento del indice
						$z++;

					}

				}

			}

			//Se pasa de Arreglo a String
			$nombres_columnas = implode(',',$nombre_columnas_consulta);
			//Eliminación de Array
			unset($nombre_columnas_consulta);
			//Regrea el nombre de las columnas para la consulta
			return $nombres_columnas;

		}
		//Validación para evitar que superé el número de columnas de tablas foraneas
		else{

			//Validación para que sólo permita a las consultas Avanzadas
			if($tipo_consulta == 'Basica'){

				return false;

			}
			else{

				//Validación para corroborar que se hayan pasado las tablas foraneas
				if(!$this->tablas_foraneas){
				
					return false;

				}
				else{

					//Instancia para consultar las columnas de las tablas Foraneas y de la clase
					//$nombre_columnas_tabla = $this->nombresColumnasTablaClase($this->tabla_clase);
					//Se obtiene el nombre de las columnas de la tabla clase
					$nombre_columnas_tabla = $this->nombresColumnasTablas($consulta);
					//Validación para sólo consultar en la tabla de la clase las columnas
					if(count($nombre_columnas_tabla) > count($columnas_consulta)){
					
						//Indice del arreglo que tendrá el nombre de la columnas
						$z = 0;
						//Se declara Array en Blanco
						$nombre_columnas_consulta = array();
						//Bucle para recorrer y obtener el nombre de las columnas
						for($i = 0; $i < sizeof($columnas_consulta); $i++){
					
							//Validación para ir agregando al arreglo final los nombres de las columnas
							if($columnas_consulta[$i]){

								//Validación para ir agregando al arreglo final los nombres de las columnas
								if($columnas_consulta[$i] ==! true){
						
									//Consultamos en el array que exista el nombre de la columna
									$nombre_columna = array_search($columnas_consulta[$i],$nombre_columnas_tabla);
									//Validación para confirmar que exista el nombre de la columna
									if($nombre_columna === false){
									}
									else{

										//Se almacena el nombre de la columna
										$nombre_columnas_consulta [$z] = $nombre_columna;
									}

								}
								else{

									//Se agrega el nombre de la columna al arreglo final
									$nombre_columnas_consulta [$z] = $nombre_columnas_tabla[$i];
									//Incremento del indice
									$z++;

								}

							}

						}

						//Se pasa de Arreglo a String
						$nombres_columnas = implode(',',$nombre_columnas_consulta);
						//Eliminación de Array
						unset($nombre_columnas_consulta);
						//Regrea el nombre de las columnas para la consulta
						return $nombres_columnas;

					}
					else{
						
						return false;

					}

				}

			}

		}

	}

	
	//Método para obtener el nombre de las columnas de tablas
	public function creacionRelacionesTablas($tablas){

		//Validar que haya pasado el Array con los nombres de las tablas
		if(!is_array($tablas) AND !is_object($tablas)){

			return false;

		}
		else{

			//Indice para el array con las relaciones de las tablas
			$z = 0;
			//Bucle para obtener las relaciones de la tabla de la clase
			for($i = 1; $i < sizeof($tablas); $i++){

				//Construcción de las columnas foraneas de la tabla clase
				$columna_foranea[$z] = $this->fk_clase.$tablas[$i].'_'.$this->tabla_clase.' = '.$this->id_foraneas.$tablas[$i];
				$z++;

			}
			//Se pasa de Array a String
			$relaciones = implode(' AND ',$columna_foranea);
			//Eliminación de Array
			unset($columna_foranea);
			//Regreso de relaciones entre tablas
			return $relaciones;

		}

	}

	
	//Método para obtener las condiciones de una consulta
	public function creacionCondicionesConsulta($condiciones_consulta,$operadores_consulta){

		//Instancia para obtener el nombre de las columnas de la tabla de la Clase
		$nombre_columnas_tabla = $this->nombresColumnasTablaClase($this->tabla_clase);
		//Validación para sólo consultar en la tabla de la clase las columnas
		if(count($nombre_columnas_tabla) >= count($condiciones_consulta)){

			//Indice del arreglo que tendrá el nombre de la columnas
			$z = 0;
			//Bucle para recorrer y obtener el nombre de las columnas
			for($i = 0; $i < sizeof($nombre_columnas_tabla); $i++){
				
				//Validación para ir agregando al arreglo final los nombres de las columnas
				if(isset($condiciones_consulta[$i])){

					//Validación para poner un número a los operadores en caso de que no tenga
					if(!$operadores_consulta) $operadores_consulta=array();

					//Validación para no superar el tamaño del Array de los operadores
					if($i <= count($operadores_consulta)){

						//Validación para poner Operador = por Default en caso de que no sea arreglo o no información
						if((!is_array($operadores_consulta) OR !is_object($operadores_consulta)) AND (!isset($operadores_consulta[$i]))){

							//Se construye el operador para la consulta
							$operador_consulta = ' = ';;

						}
						else{

							//Se construye el operador para la consulta
							$operador_consulta = ' '.$operadores_consulta[$i].' ';

						}
					}
					else{

						//Se construye el operador para la consulta
						$operador_consulta = ' = ';

					}

					//Validación para agregar el AND después del primer WHERE
					if($z != 0){

						$and = ' AND ';

					}
					else{

						$and = null;

					}
			
					//Se agrega el nombre de la columna al arreglo final
					$nombre_columnas_condiciones [$z] = $and.$nombre_columnas_tabla[$i].$operador_consulta."'".$condiciones_consulta[$i]."'";
					//Incremento del indice
					$z++;

				}

			}

			//Se pasa de Arreglo a String
			$nombres_columnas = implode(' ',$nombre_columnas_condiciones);
			//Eliminación de Array
			unset($nombre_columnas_condiciones);
			//Eliminación de Array
			unset($operadores_consulta);
			//Regrea el nombre de las columnas para la consulta
			return $nombres_columnas;

		}
		//Validación para evitar que superé el número de columnas de tablas foraneas
		else{

			return false;

		}

	}


	//Método para obtener los nombre de las columnas de la tabla Clase
	public function nombresColumnasTablaClase($tabla_clase,$tipo_consulta=null){

		//Validación para agregar la , en las tablas foraneas
		if($this->tablas_foraneas AND $tipo_consulta == 'Avanzada'){

			$tablas_foraneas = $this->tablas_foraneas;
			//Las tablas foraneas se convierten en Array nuevamente
			$tablas = explode(',',$this->tablas_foraneas);
			//Instancia de Método para crear las relaciones entre tablas
			$condicion_where = ' WHERE '.$this->creacionRelacionesTablas($tablas);

		}
		else{

			$tablas_foraneas = null;
			//Instancia de Método para crear las relaciones entre tablas
			$condicion_where = null;

		}

		//Se genera el código SQL para obtener con ello el número de columnas de la tablas clase
		$consulta = "SELECT * FROM $tabla_clase$tablas_foraneas$condicion_where";
		//Se obtiene el nombre de las columnas de la tabla clase
		if(!$nombre_columnas_tabla = $this->nombresColumnasTablas($consulta)){

			return false;

		}
		else{
			
			return $nombre_columnas_tabla;

		}

	}


	//Método para obtener el nombre de la columna por la que se ordenará la consulta
	public function nombreColumnaOrden($columna_orden){

		//Se genera el código SQL para obtener con ello el número de columnas de la tablas clase
		$consulta = "SELECT * FROM $this->tabla_clase";
		//Se obtiene el nombre de las columnas de la tabla clase
		if(!$nombre_columnas_tabla = $this->nombresColumnasTablas($consulta)){

			return false;

		}
		else{

			//Validación para evitar que se pase el Array de las columna orden
			if(count($nombre_columnas_tabla) < count($columna_orden)){

				return false;

			}
			else{

				//Bucle para obtener el nombre de la columna del orden de la consulta
				for($i = 0; $i < sizeof($columna_orden); $i++){

					//validación para obtener nombre de columna
					if($columna_orden[$i]){

						//Se obtiene el nombre de la columna
						$columna_orden = $nombre_columnas_tabla[$i];

					}

				}

				//Eliminación de array
				unset($nombre_columnas_tabla);
				//Retorno de la columnas en orden
				return $columna_orden;

			}

		}

	}

}

//$tablas = array('usuario','sucursal','contacto_sucursal');
//$obj = new clase('reporte',$tablas);//,$tablas,'gh.gh = hu.hu'
/*$columnas = array('','Christian Zapata','CAZG',34567898765,'correo@hotmail',1,1,'Activado');
$where = array('','','','','','','','Activo');
$opera = array('','!=','','','');
$orden = array('','','');
$condiciones = array(12);
$where = array('','nombre','contrasena');
print_r($obj->consultaAvanzada());
//print_r($obj->nombresColumnasTablaClase('usuario'));
//echo $obj->guardar($columnas);
//echo $obj->actualizar($columnas,$condiciones);
*/
//$array_consulta[1] = true;$array_consulta[13] = true;
//$array_condiciones[8] = 1;
//print_r($obj->consultaAvanzada($array_consulta,$array_condiciones));
//echo '<br/><br/>';
//print_r($obj->consultaBasica());
?>