/*Función para el envío de Notificaciones al usuario
    notificacion_alerta = Contiene el mensaje que se mostrará en la notificación de alerta
    notificacion_envio  = Contiene el mensaje que notificará el envío de información
    notifiacion_correcta = Contiene el mensaje que mostrará cuando es correcto el proceso
    notificacion_error  = Contiene el mensaje del error al no lograrse el proceso
    notificacion_pregunta = Contiene la pregunta para que se muestre la notificación
*/
//Función para enviar notificaciones al Usuario
function notificaciones(notificacion_alerta,notificacion_envio,notificacion_correcta,notificacion_error,notificacion_pregunta,nombre_funcion_pregunta){
  
    //Variables de las imagenes para notificaciones
    //Contiene la ruta de la imagen de Advertencia
    var ruta_imagen_advertencia = "images/lib/advertencia.png";
    //Contiene el parametro ALT de la imagen de Advertencia
    var alt_imagen_advertencia = "Advertencia!";

    //Contiene la ruta de la imagen de Error
    var ruta_imagen_error = "images/lib/error.png";
    //Contiene el parametro ALT de la imagen de Error
    var alt_imagen_error = "Error!";  

    //Contiene la ruta de la imagen de OK
    var ruta_imagen_ok = "images/lib/ok.png";
    //Contiene el parametro ALT de la imagen de OK
    var alt_imagen_ok = "OK!";
    
    //Contiene la ruta de la imagen del Loader
    var ruta_imagen_loader = "images/lib/loader.gif";
    //Contiene el atributo ALT de la imagen del loader
    var alt_imagen_loader = "Loading!";

    //Label para botón para cerrar mensajes
    var label_cerrar = 'Cerrar';
    //Label para botón para Aceptar en pregunta
    var label_aceptar = 'Aceptar';
    //Label para botón para Cancelar en pregunta
    var label_cancelar = 'Cancelar';


    //Condiciones para mostrar las notificaciones
    //Condición que permite enviar una alerta al usuario && id_div_error == '' && mensaje_div_error == '' && notificacion_envio == ''
    if(notificacion_alerta != ''){
        notificacionAlerta(notificacion_alerta,ruta_imagen_advertencia,alt_imagen_advertencia,label_cerrar);
    }
    //Condición que permite notificar al usuario de envío de información && id_div_error == '' && mensaje_div_error == '' && notificacion_alerta == ''
    else if(notificacion_envio != ''){
        notificacionEnvio(notificacion_envio,ruta_imagen_loader,alt_imagen_loader);
    } 
    //Condición para notificar correctamente el proceso de envío
    else if(notificacion_correcta != ''){
        notificacionCorrecta(notificacion_correcta,ruta_imagen_ok,alt_imagen_ok,label_cerrar,nombre_funcion_pregunta);
    }
     //Condición para notificar incorrectamente el proceso de envío
    else if(notificacion_error != ''){
        notificacionError(notificacion_error,ruta_imagen_error,alt_imagen_error,label_cerrar);
    }
    //Condición para hacer una notificación de pregunta
    else if(notificacion_pregunta != ''){
        notificacionPregunta(notificacion_pregunta,ruta_imagen_advertencia,alt_imagen_advertencia,label_cancelar,label_aceptar,nombre_funcion_pregunta);
    }
    //Condición que permite cerrar las notificaciones
    else{
        cerrarNotificacion();
    }
}


/*
Función para mostrar los mensajes en los INPUTS
id_div_error        = Parametro con el ID del elemento con el mensaje que aparece debajo de un INPUT
mensaje_div_error   = Contiene el mensaje que se mostrará en el DIV error debajo de un INPUT
*/
//Función para mostrar errores en los INPUT de los Formularios
function mensajes(id_div_error,mensaje_div_error){

    //Condiciones de mensajes para INPUT
    //Condición que muestra el mensaje de error de un INPUT
    if(!id_div_error == '' && !mensaje_div_error == ''){
        mensajeError(id_div_error,mensaje_div_error);
    }
    //Condición que permite borrar el mensaje de error de un INPUT && mensaje_div_error == '' && notificacion_alerta == '' && notificacion_envio == ''
    else{
        borrarMensajeError(id_div_error);
    }
}




//Función que permite mostrar un error en un INPUT
function mensajeError(div_error,mensaje){
    //obtenemos el ID del div_error y le pasamos un String en blanco
    document.getElementById(div_error).innerHTML = "";
    //obtenemos el ID del div_error y le pasamos el mensaje de error
    document.getElementById(div_error).innerHTML += mensaje;
}

//Función que permite borrar un error en un INPUT
function borrarMensajeError(div_error){
   document.getElementById(div_error).innerHTML = ""; 
}

//funcion que permite mostrar una notificación al usuario en pantalla de Alerta
function notificacionAlerta(mensaje_alerta,ruta_imagen_advertencia,alt_imagen_advertencia,label_cerrar){
    //se insertan las variables con las rutas de las imagenes de error junto con el boton para cerrar el mensaje de error
    var texto ="<img src='"+ruta_imagen_advertencia+"' alt='"+alt_imagen_advertencia+"'><br/><br/>"+mensaje_alerta+"<br><br><input type='button' value='"+label_cerrar+"' onClick='cerrarNotificacion()' class='advertencia alineacion-centro advertencia-largo'/>";
    div_mensaje.innerHTML += texto;
    div_transparente.style.display = "block";
}

//Funcion que muestra la notificación para envío de información
function notificacionEnvio(mensaje_envio,ruta_imagen_loader,alt_imagen_loader,label_cerrar){
    var texto = "<br/><br/><img src='"+ruta_imagen_loader+"' alt='"+alt_imagen_loader+"'><br/><br/>"+mensaje_envio;
    div_mensaje.innerHTML += texto;
    div_transparente.style.display = "block";
}

//Función que permite cerrar las notificaciones
function cerrarNotificacion(){
    div_transparente.style.display = "none";
    div_mensaje.innerHTML = "";
}

//Función que envía la notificación correcta
function notificacionCorrecta(mensaje_correcto,ruta_imagen_ok,alt_imagen_ok,label_cerrar,funcion_correcta){
    var texto = "<img src='"+ruta_imagen_ok+"' alt='"+alt_imagen_ok+"'><br/><br/>"+mensaje_correcto+"<br><br><input type='button' value='"+label_cerrar+"' onClick='"+funcion_correcta+"' class='aceptar alineacion-centro aceptar-largo'/>";
    div_mensaje.innerHTML += texto;
    div_transparente.style.display = "block";
}

//Función que envía la notificación Error
function notificacionError(mensaje_incorrecto,ruta_imagen_error,alt_imagen_error,label_cerrar){
    var texto = "<img src='"+ruta_imagen_error+"' alt='"+alt_imagen_error+"'><br/><br/>"+mensaje_incorrecto+"<br><br><input type='button' value='"+label_cerrar+"' onClick='cerrarNotificacion()' class='error alineacion-centro error-largo'/>";
    div_mensaje.innerHTML += texto;
    div_transparente.style.display = "block";
}

//Función que envía la notificación de una pregunta
function notificacionPregunta(notificacion_pregunta,ruta_imagen_advertencia,alt_imagen_advertencia,label_cancelar,label_aceptar,nombre_funcion_pregunta){
    var texto = "<img src='"+ruta_imagen_advertencia+"' alt='"+alt_imagen_advertencia+"'><br/><br/>"+notificacion_pregunta+"<br><br><input type='button' value='"+label_cancelar+"' onClick='cerrarNotificacion()' class='cancelar cancelar-50'/> <input type='button' value='"+label_aceptar+"' onClick='"+nombre_funcion_pregunta+"' class='advertencia advertencia-50'/>";
    div_mensaje.innerHTML += texto;
    div_transparente.style.display = "block";
}

//Función para cerrar un mensaje correcto con una dirección distinta
function cerrarMensajeCorrecto(){
    location.href = ir_despues;
}

//Función para cerrar un mensaje correcto de un proceso
function cerrarCorrectoMensaje(id){
    location.href = despues_ir+id;
}

//Función para cerrar un mensaje y quedarse en el mismo formulario
function cerrarCorrecto(){
    div_transparente.style.display = "none";
    div_mensaje.innerHTML = "";
}