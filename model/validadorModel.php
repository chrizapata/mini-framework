<?php
//Clase Validadora
class validador{

	//ATRIBUTOS
	//Variable que contiene el tipo de campo Correo
	private $correo = 'correo';
	//Variable que contiene el tipo de campo Texto
	private $texto = 'texto';
	//Variable que contiene el tipo de campo Numeríco
	private $numerico = 'numero';
	//Variable que contiene el tipo de campo Flotante
	private $flotante = 'flotante';

	//MÉTODOS
	//Método para campos obligatorios
	public function campoObligatorio($tipo_campo,$nombre_campo,$longitud_minima,$longitud_maxima){
		//Comparación para tipo de campo -> Correo
		if($tipo_campo == $this->correo){
			//Comparación para validar que no esté vacio el campo correo
			if(!$this->campoVacio($nombre_campo)){
				return false;
			}
			else{
				//Validación para corroborar que sea un Correo
				if(!$this->validaCorreo($nombre_campo)){
					return false;
				}
				else{
					return true;
				}
			}
		}
		//Comparación para tipo de campo -> Texto
		else if($tipo_campo == $this->texto){
			//Comparación para validar que no esté vacio el campo texto
			if(!$this->campoVacio($nombre_campo)){
				return false;
			}
			else{
				//Validación para medir la longitud
				if(!$this->validaLongitud($nombre_campo,$longitud_minima,$longitud_maxima)){
					return false;
				}
				else{
					return true;
				}
			}
		}
		//Comparación para tipo de campo -> Numeríco
		else if($tipo_campo == $this->numerico){
			//Comparación para validar que no esté vacio el campo texto
			if(!$this->campoVacio($nombre_campo)){
				return false;
			}
			else{
				//Validación para medir la longitud
				if(!$this->validaLongitud($nombre_campo,$longitud_minima,$longitud_maxima)){
					return false;
				}
				else{
					//Validación para corroborar que sea númerico el campo
					if(!$this->validaNumero($nombre_campo)){
						return false;
					}
					else{
						return true;
					}
				}
			}
		}
		//Comparación para tipo de campo -> Flotante
		else if($tipo_campo == $this->flotante){
			//Comparación para validar que no esté vacio el campo texto
			if(!$this->campoVacio($nombre_campo)){
				return false;
			}
			else{
				//Validación para medir la longitud
				if(!$this->validaLongitud($nombre_campo,$longitud_minima,$longitud_maxima)){
					return false;
				}
				else{
					//Validación para corroborar que sea flotante el campo
					if(!$this->validaFlotante($nombre_campo)){
						return false;
					}
					else{
						return true;
					}
				}
			}
		}
		//Comparación para tipo de campo -> Selección
		else{
			//Comparación para validar que esté seleccionado algo
			if(!$this->validaSeleccion($nombre_campo)){
				return false;
			}
			else{
				return true;
			}
		}
	}

	//Método para campos no obligatorios
	public function campoNoObligatorio($tipo_campo,$nombre_campo,$longitud_minima,$longitud_maxima){
		//Comparación para tipo de campo -> Correo
		if($tipo_campo == $this->correo){
			//Comparación para validar que no esté vacio el campo
			if($this->campoVacio($nombre_campo)){
				//Validación para corroborar que sea un Correo
				if(!$this->validaCorreo($nombre_campo)){
					return false;
				}
				else{
					return true;
				}
			}
			else{
				return true;
			}
		}
		//Comparación para tipo de campo -> Texto
		else if($tipo_campo == $this->texto){
			//Comparación para validar que no esté vacio el campo
			if($this->campoVacio($nombre_campo)){
				//Validación para corroborar que sea un Correo
				if(!$this->validaLongitud($nombre_campo,$longitud_minima,$longitud_maxima)){
					return false;
				}
				else{
					return true;
				}
			}
			else{
				return true;
			}
		}
		//Comparación para tipo de campo -> Numeríco
		else{
			//Validación para medir la longitud
			if(!$this->validaLongitud($nombre_campo,$longitud_minima,$longitud_maxima)){
				return false;
			}
			else{
				//Validación para corroborar que sea númerico el campo
				if(!$this->validaNumero($nombre_campo)){
					return false;
				}
				else{
					return true;
				}
			}
		}
	}

	//Método para corroborar que la información sea enviada de nuestra App Web
	public function validarFormularioEnvio($parametro_formulario,$url_formulario,$url_formulario_www){
		//Validación para saber sí está en producción la App Web
		if($parametro_formulario == 'P'){
			//Valida que se haya enviado petición desde nuestro formulario en Producción
			if($_SERVER['HTTP_REFERER'] != $url_formulario AND $_SERVER['HTTP_REFERER'] != $url_formulario_www){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			//Valida que se haya enviado información desde LOCALHOST
			if($_SERVER['HTTP_REFERER'] != $url_formulario){
				return false;
			}
			else{
				return true;
			}
		}
	}

	//Método para comprobar que un campo no esté vacio
	public function campoVacio($nombre_campo){
		if(!$nombre_campo){
			return false;
		}
		else{
			return true;
		}
	}

	//Método para comprobar la longitud de un campo
	public function validaLongitud($nombre_campo,$longitud_minima,$longitud_maxima){
		if(strlen($nombre_campo) < $longitud_minima || strlen($nombre_campo) > $longitud_maxima){
			return false;
		}
		else{
			return true;
		}
	}

	//Método para comprobar que sea un correo
	public function validaCorreo($nombre_campo){
		if(filter_var($nombre_campo,FILTER_VALIDATE_EMAIL) === false){
			return false;
		}
		else{
			return true;
		}
	}

	//Método para validar un Select
	public function validaSeleccion($nombre_campo){
		if(!$nombre_campo){
			return false;
		}
		else{
			return true;
		}
	}

	//Método para validar un número
	public function validaNumero($nombre_campo){
		if(filter_var($nombre_campo,FILTER_VALIDATE_INT) === false){
			return false;
		}
		else{
			return true;
		}
	}

	//Método para validar un número con decimales (PHP)
	public function validaFlotante($nombre_campo){
		if(is_float($nombre_campo)){
			return false;
		}
		else{
			return true;
		}
	}
}
?>