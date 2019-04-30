<?php
//Versión 0.7.5
//CONEXIÓN
abstract class conexion{

	//ATRIBUTOS
	//URL de Servidor
	private $servidor = SERVIDOR;
	//Usuario de BD
	private $usuario_db = USUARIO_DB;
	//Contraseña de BD
	private $contrasena_db = CONTRASENA_DB;
	//Nombre de la BD
	private $nombre_db = NOMBRE_DB;
	//Link de la conexión creada a la BD
	private $conexion_db = null;
	//Resultados de una consulta a la BD
	protected $consulta_db = null; 
	//Resultados de una consulta a la BD en arreglo asociativo
	protected $resultados = null;
	//Arreglo que contiene la información de una Matriz Asociativa
	protected $informacion = array();
	//Contiene el número de columnas devueltas en una consulta
	protected $columnas = null;

	//MÉTODOS
	//Método del Constructor
	/*public function __construct(){
		//Variable que contien la dirección del Servidor
		$this->servidor = SERVIDOR;
		//Variable que contiene el nombre de usuario de la BD
		$this->usuario_db = USUARIO_DB;
		//Variable que contiene la contraseña del usuario de la BD
		$this->contrasena_db = CONTRASENA_DB;
		//Variable que contiene el nombre de la BD
		$this->nombre_db = NOMBRE_DB;
	}*/


	//Método del Destructor
	public function __destruct(){

	}


	//Método para Conectar a la Base de Datos
	private function conectarDB(){

		//Variable que contiene la conexión a la BD
		if(!$this->conexion_db = new mysqli($this->servidor,$this->usuario_db,$this->contrasena_db,$this->nombre_db)){
			//Envió de error de conexión de BD
			echo 'Error en la conexión de la Base de Datos: '.$this->conexion_db->connect_error();

		}
		else{

			//Tipo de codificación para mostrar información de la BD
			$this->conexion_db->set_charset('utf8');
			return $this->conexion_db;

		}

	}


	//Método para Cerrar la Conexión a la BD
	private function cerrarDB(){

		//Cerramos la conexión a la Base de Datos
		mysqli_close($this->conexion_db);

	}


	//Método para Insetar, Actualizar y Eliminar información de la BD
	protected function consultaSimple($consulta){

		//Variable que contiene el resultado de una consulta a la BD
		if(!$this->conectarDB()->query($consulta)){

			$this->cerrarDB();
			return false;

		}
		else{

			$this->cerrarDB();
			return true;

		}	

	}


	//Método para obtener información de la BD
	protected function consultaMultiple($consulta){

		//Validación para corroborar que haya un parametro
		if(!empty($consulta)){
			//Variable que contiene el resultado de una consulta a la BD
			$this->consulta_db = $this->conectarDB()->query($consulta);
			//Validación para saber sí se obtuvo algo en la consulta
			if(!$this->consulta_db->num_rows){
	
				$this->cerrarDB();
				return false;

			}
			else{

				//Se declara el Array en blanco
				$this->informacion = array();
				//Bucle para ir almacenando en nuestro array la información obtenida
				while($this->resultados = mysqli_fetch_array($this->consulta_db, MYSQLI_ASSOC)){
					
					//Se almancena la información en un Array
					$this->informacion[] = $this->resultados;

				}
				$this->cerrarDB();
				return $this->informacion;

			}

		}
		else{

			return false;

		}

	}

	
	//Método para Obtener el número de resultados de información de la BD
	protected function numeroResultados($consulta){

		//Variable que contiene el resultado de una consulta a la BD
		$this->consulta_db = $this->conectarDB()->query($consulta);
		if(!$this->consulta_db->num_rows){

			$this->cerrarDB();
			return false;

		}
		else{

			//Variable para obtener el número de columnas de un resultado
			$numero_columnas = $this->consulta_db->num_rows;
			$this->cerrarDB();
			return $numero_columnas;

		}

	}


	//Método para Obtener el nombre de las columnas de una tabla
	protected function nombresColumnasTablas($consulta){

		//Variable que contiene el resultado de una consulta a la BD
		$this->consulta_db = $this->conectarDB()->query($consulta);
		$this->informacion = array();

		//Bucle para ir almacenando en nuestro array la información obtenida
		while($this->resultados = mysqli_fetch_field($this->consulta_db)){

			$this->informacion [] = $this->resultados->name;

		}

		$this->cerrarDB();
		return $this->informacion;

	}

}

?>