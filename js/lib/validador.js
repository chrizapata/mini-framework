//Funciones para cargar valores al terminó de carga del proyecto
onload = function(){
	//Contiene el valor del DIV Transparente para el mensaje
	div_transparente = document.getElementById(contenedor_msj);
	//Contiene el valor del DIV el mensaje
	div_mensaje = document.getElementById(msj);
	//Contiene el valor del Formulario a enviar
	formulario = document.getElementById(id_form);
	//Contiene la URL donde se procesa la información enviada de un formulario
	url_proceso = controlador_proceso;
}

//Función con los parametros AJAX
function nuevoAjax(){ 
	var xmlhttp = false; 
	try { 
		// No IE
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e){ 
		try{ 
			// IE 
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { 
			xmlhttp = false; 
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest != "undefined") { 
		xmlhttp = new XMLHttpRequest(); 
	} 
	return xmlhttp; 
}

//Función para validar los campos obligatorios
function campoObligatorio(tipo_campo,nombre_campo,longitud_minima,longitud_maxima,id_div_error_elemento,mensaje_error_vacio,mensaje_error_longitud,mensaje_error_correo){
	//Contiene el parametro Correo
	var correo = 'correo';
	//Contiene el parametro Texto
	var texto = 'texto';
	//Contiene el parametro Selección
	var seleccioon = 'seleccion';
	//Contiene el parametro númerico
	var numero = 'numero';
	//Contiene el parametro Flotante
	var flotante = 'flotante';

	//Verífica sí es correo el campo
	if(tipo_campo == correo){
		//Validación para corroborar que no esté vacio el campo
		if(!campoVacio(nombre_campo)){
			//Se instancia la función de notificaciones para envíar mensaje al INPUT
			mensajes(id_div_error_elemento,mensaje_error_vacio);
			return false;
		}
		else{
			//Se borra el mensaje de notificación de un INPUT
			mensajes(id_div_error_elemento,'');
			//Validación de correo
			if(!validarCorreo(nombre_campo)){
				//Se instancia la función de notificaciones para envíar mensaje al INPUT
				mensajes(id_div_error_elemento,mensaje_error_correo);
				return false;
			}
			else{
				//Se borra el mensaje de notificación de un INPUT
				mensajes(id_div_error_elemento,'');
				return true;
			}
		}
	}
	//Verífica sí es texto el campo
	else if(tipo_campo == texto){
		//Validación para corroborar que no esté vacio el campo
		if(!campoVacio(nombre_campo)){
			//Se instancia la función de notificaciones para envíar mensaje al INPUT
			mensajes(id_div_error_elemento,mensaje_error_vacio);
			return false;
		}
		else{
			//Se borra el mensaje de notificación de un INPUT
			mensajes(id_div_error_elemento,'');
			//Validación de Longitud
			if(!validaLongitud(nombre_campo,longitud_minima,longitud_maxima)){
				//Se instancia la función de notificaciones para envíar mensaje al INPUT
				mensajes(id_div_error_elemento,mensaje_error_longitud);
				return false;
			}
			else{
				//Se borra el mensaje de notificación de un INPUT
				mensajes(id_div_error_elemento,'');
				return true;
			}
		}
	}
	//Verífica sí es número el campo
	else if(tipo_campo == numero){
		//Validación para corroborar que no esté vacio el campo
		if(!campoVacio(nombre_campo)){
			//Se instancia la función de notificaciones para envíar mensaje al INPUT
			mensajes(id_div_error_elemento,mensaje_error_vacio);
			return false;
		}
		else{
			//Validación para corroborar sí es número
			if(!validaSoloNumeros(nombre_campo)){
				//Se instancia la función de notificaciones para envíar mensaje al INPUT
				mensajes(id_div_error_elemento,mensaje_error_correo);
				return false;
			}
			else{
				//Se borra el mensaje de notificación de un INPUT
				mensajes(id_div_error_elemento,'');
				//Validación de Longitud
				if(!validaLongitud(nombre_campo,longitud_minima,longitud_maxima)){
					//Se instancia la función de notificaciones para envíar mensaje al INPUT
					mensajes(id_div_error_elemento,mensaje_error_longitud);
					return false;
				}
				else{
					//Se borra el mensaje de notificación de un INPUT
					mensajes(id_div_error_elemento,'');
					return true;
				}
			}
		}
	}
	//Verifica números Flotantes
	else if(tipo_campo == flotante){
		//Validación para corroborar que no esté vacio el campo
		if(!campoVacio(nombre_campo)){
			//Se instancia la función de notificaciones para envíar mensaje al INPUT
			mensajes(id_div_error_elemento,mensaje_error_vacio);
			return false;
		}
		else{
			//Validación para corroborar sí es número
			if(isNaN(nombre_campo)){
				//Se instancia la función de notificaciones para envíar mensaje al INPUT
				mensajes(id_div_error_elemento,mensaje_error_correo);
				return false;
			}
			else{
				//Se borra el mensaje de notificación de un INPUT
				mensajes(id_div_error_elemento,'');
				//Validación de Longitud
				if(!validaLongitud(nombre_campo,longitud_minima,longitud_maxima)){
					//Se instancia la función de notificaciones para envíar mensaje al INPUT
					mensajes(id_div_error_elemento,mensaje_error_longitud);
					return false;
				}
				else{
					//Se borra el mensaje de notificación de un INPUT
					mensajes(id_div_error_elemento,'');
					return true;
				}
			}
		}
	}
	//Verífica sí es select el campo
	else{
		//Validación de seleccionar algo
		if (!validaSeleccion(nombre_campo)){
			//Se instancia la función de notificaciones para envíar mensaje al INPUT
			mensajes(id_div_error_elemento,mensaje_error_vacio);
			return false;
		}
		else{
			//Se borra el mensaje de notificación de un INPUT
			mensajes(id_div_error_elemento,'');
			return true;
		}
	}
}

//Función para validar campos no obligatorios
function campoNoObligatorio(tipo_campo,nombre_campo,longitud_minima,longitud_maxima,id_div_error_elemento,mensaje_error_longitud,mensaje_error_correo){
	//Contiene parametros de los campos texto
	var texto = 'texto';
	//Contiene los parametros de los compos correo
	var correo = 'correo';

	//Verífica sí es correo el campo
	if(tipo_campo == correo){
		//Validación para corrborar que tenga algo el campo
		if(campoVacio(nombre_campo)){
			//Validación de longitud
			if(!validaLongitud(nombre_campo,longitud_minima,longitud_maxima)){
				//Se instancia la función de notificaciones para envíar mensaje al INPUT
				mensajes(id_div_error_elemento,mensaje_error_longitud);
				return false;
			}
			else{
				//Se borra el mensaje de notificación de un INPUT
				mensajes(id_div_error_elemento,'');
				if(!validarCorreo(nombre_campo)){
					//Se instancia la función de notificaciones para envíar mensaje al INPUT
					notificaciones(id_div_error_elemento,mensaje_error_correo,'','','','');
					return false;
				}
				else{
					//Se borra el mensaje de notificación de un INPUT
					mensajes(id_div_error_elemento,'');
					return true;
				}
			}
		}
		else{
			return true;
		}	
	}
	//Verífica sí es texto
	else{
		//Validación para corrborar que tenga algo el campo
		if(campoVacio(nombre_campo)){
			//Validación de longitud
			if(!validaLongitud(nombre_campo,longitud_minima,longitud_maxima)){
				//Se instancia la función de notificaciones para envíar mensaje al INPUT
				mensajes(id_div_error_elemento,mensaje_error_longitud);
				return false;
			}
			else{
				//Se borra el mensaje de notificación de un INPUT
				mensajes(id_div_error_elemento,'');
				return true;
			}
		}
		else{
			return true;
		}
	}
}

//Función para validar campos vacios
function campoVacio(nombre_campo){
	if(!nombre_campo){
		return false;
	}
	else{
		return true;
	}
}

//Función para validar números dentro formulario
function validaSoloNumeros(nombre_campo){
	var expRegNumero = /^([0-9])*$/;
	if(!expRegNumero.test(nombre_campo)){
   		return false;
  	}
 	else{
  		return true;
 	}
}

//Función para validar números Flotantes
function validaSoloFlotantes(nombre_campo){
	if(isNaN(nombre_campo)){
		return false;
	}
	else{
		return true;
	}
}

//Función para validar los números flotantes dentro de un formulario
function validaSoloNumerosFlotantes(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toLowerCase();
    letras = "1234567890 ";
    //especiales = [8,37,39,46];
    //9 = TAB 37-39 = Flechas  8 = Borrar
    especiales = [8,37,39,9,46];
	tecla_especial = false
    for(var i in especiales){
    	if(key == especiales[i]){
            tecla_especial = true;
        	break;
        } 
    }
    if(letras.indexOf(tecla)==-1 && !tecla_especial){
       	return false; 
    }
}

//Función para validar las longitudes de los campos
function validaLongitud(nombre_campo,longitud_minima,longitud_maxima){
	if(nombre_campo.length < longitud_minima || nombre_campo.length > longitud_maxima){
		return false;
	}
	else{
		return true;
	}
}

//Función para validar correo
function validarCorreo(nombre_campo){
	var expRegEmail = /^[\w\.\_]+@([\w-]+\.)+[\w-]{2,4}$/;
	if(!expRegEmail.exec(nombre_campo)){
		return false;
	}
	else{
		return true;
	}
}

//Función para validar un Select
function validaSeleccion(nombre_campo){
	if(nombre_campo == 0){
		return false;
	}
	else{
		return true;
	}
}

//Función para añadir icono a documentación
function definirImagenesDocumento(extension_documento){
	//Excel
	if(extension_documento == 'xlsx' || extension_documento == 'xls'){
		return 'excel';
	}
	else if(extension_documento == 'html' || extension_documento == 'txt'){
		return 'txt';
	}
	else if(extension_documento == 'rar'){
		return 'rar';
	}
	else if(extension_documento == 'zip'){
		return 'zip';
	}
	else if(extension_documento == 'doc' || extension_documento == 'docx'){
		return 'word';
	}
	else if(extension_documento == 'pdf'){
		return 'pdf';
	}
	else if(extension_documento == 'mp3' || extension_documento == 'wav' || extension_documento == 'ogg'){
		return 'audio';
	}
	else if(extension_documento == 'mp4' || extension_documento == 'avi' || extension_documento == 'mov' || extension_documento == 'wmv'){
		return 'video';
	}
	else if(extension_documento == 'ppt' || extension_documento == 'pptx'){
		return 'power';
	}
	else if(extension_documento == 'ppsm' || extension_documento == 'pps' || extension_documento == 'ppsx'){
		return 'presentacion';
	}
	else if(extension_documento == 'exe'){
		return 'exe';
	}
	else if(extension_documento == 'gif'){
		return 'gif';
	}
	else if(extension_documento == 'jpg' || extension_documento == 'png' || extension_documento == 'jpeg'){
		return 'image';
	}
	else{
		return 'txt';
	}

}

//Función para poner formato de número de pesos
String.prototype.number_format = function(d){
    var n = this;
    var c = isNaN(d = Math.abs(d)) ? 2 : d;
    var s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + ',' : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + ',') + (c ? '.' + Math.abs(n - i).toFixed(c).slice(2) : "");
}