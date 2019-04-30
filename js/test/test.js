
//Variables de configuraciones para notificaciones
var contenido_descripcion="",numero_caracteres_descripcion=700,contenido_asunto="",contenedor_msj='transparencia',msj='mensaje',id_form='form-nota',controlador_proceso='?modulo=test',despues_ir='?modulo=test';

//Fución para contador de caracteres de la nota
function caracteresDescripcion(){
	//Contiene el valor máximo del input la descripción de una actividad
	var caracteres_descripcion = document.getElementById('nota').value.length;
	//Validación para comprobar que no superte lo máximo
  	if(caracteres_descripcion <= numero_caracteres_descripcion){
  		//Contiene el valor del input de la descripción
    	contenido_descripcion = document.getElementById('nota').value;
  	}
  	else{
  		//Se reeemplaza la información del input de la descripción por el más actual
    	document.getElementById('nota').value = contenido_descripcion; 
  	}
  	//Validación para notificar que ya es el limite
  	if(caracteres_descripcion >= numero_caracteres_descripcion){
  		//Cambiar el color a la notificación de caracteres
    	document.getElementById('contadorDescripcion').style.color = "#ff0000";
  	}
  	else{
  		//Color de la notificación de carcteres
    	document.getElementById('contadorDescripcion').style.color = "black";
  	}
  	//Cambio de label para tener el número de caracteres que faltan
  	document.getElementById('contadorDescripcion').innerHTML = document.getElementById('nota').value.length+' / 700';
}

//Función para mostrar el formulario de Nota
function agregarNota(modo,id_nota,nota,contenedor_nota){
  if(modo=='Activar'){
    document.getElementById('transparencia_popup').style.display='block';
    document.getElementById('form-nota').style.display='block';
  }
  else{
    document.getElementById('transparencia_popup').style.display='none';
    document.getElementById('form-nota').style.display='none';    
  }
}
//Función para añadir Nota
function guardarNota(){
  var error=false;tipo_informacion='nota',nota=formulario.nota.value,tipo_nota=formulario.tipo_nota.value;
  var notificacion_alerta = '<b>¡Ojo!</b> Hay información invalida que acabas de ingresar, verifícala.';
  var notificacion_envio = 'Por favor, espera...';
  var notificacion_correcta = '<strong>¡Bien!</strong>. Tu nota ha sido registrado correctamente.';
  var notificacion_error = 'No se pudo agregar tu nota. Inténtalo más tarde.';
  var notificacion_formulario = '<b>¡Ups!</b> Al parecer tienes problemas con tu navegador. Reinícialo y vuelve a intentarlo.';
  nota=nota.replace("\n","<br>");
  document.getElementById('transparencia_popup').style.display='none';
  if(!campoObligatorio('texto',nota,4,700,'error-nota','Ingres la nota correspondiente.','La nota debe contener entres 4 a 700 caracteres.','')) error = true;
  if(error){
    notificaciones('','','','','','');
    //Notificación de Alertar al usuario
    notificaciones(notificacion_alerta,'','','','','');
    agregarNota('Activar','','','');
  }
  else{
    notificaciones('','','','','','');
    //Notificación de proceso de envío de información
    notificaciones('',notificacion_envio,'','','','');
    //Se intancia el Objeto AJAX
    var ajax = nuevoAjax();
    //Pasa los datos por POST
    ajax.open("POST",url_proceso,true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //Envío de las variables correspondientes.
    ajax.send("tipo_informacion="+tipo_informacion+"&nota="+nota+"&tipo_nota="+tipo_nota);
    ajax.onreadystatechange=function(){
      if(ajax.readyState == 4){
        //Se envia impresión de respuesta al Servidor
        var respuesta = ajax.responseText;
        //Variable que toma las respuesta del Servidor (Sólo sé los caracteres necesarios)
        var notificacion = respuesta.substr(0,2);//numero_caracteres
        //alert(notificacion);
        //Validación para saber si o hay error y enviar al ticket creado
        if(notificacion == 'FO'){
          //Cierra la nostificaciones
          notificaciones('','','','','','');
          //Se envía la notificación de mensaje Error
          notificaciones('','','',notificacion_formulario,'','');
          agregaNota('Activar','','','');
        }
        else if(notificacion == 'NO' ){
          //Cierra la nostificaciones
          notificaciones('','','','','','');
          //Se envía la notificación de mensaje Incorrecto
          notificaciones('Al parecer <strong>la nota que describes no es valida</strong>.','','','','','');
          //Se instancia la función de notificaciones para envíar mensaje al INPUT
          mensajes('error-nota','La actividad debe contener mínimo 4 y máximo 700 caracteres.');
          agregarNota('Activar','','','');
        }
        else if(notificacion == 'ER'){
          //Cierra la nostificaciones
          notificaciones('','','','','','');
          //Se envía la notificación de mensaje Incorrecto
          notificaciones(notificacion_alerta,'','','','','');
          agregarNota('Activar','','','');
        }
        else if(notificacion == 'OK'){
          //Cierra la nostificaciones
          notificaciones('','','','','','');
          /*document.getElementById('seguimiento-muestra').style.display='block';
          document.getElementById('titulo-seguimiento').innerHTML='Seguimiento '+tipo_nota;
          document.getElementById('descripcion-seguimiento').innerHTML=nota;*/
          document.getElementById('nota').value='';
          seguimientoNota();
          //Nombre de la función correcta para guardar un ticket
          var funcion_fin = 'cerrarCorrecto()';
          //Se envía la notificación de mensaje correcto
          notificaciones('','',notificacion_correcta,'','',funcion_fin);
        }
        else{
          //Cierra la nostificaciones
          notificaciones('','','','','','');
          //Se envía la notificación de mensaje Incorrecto
          notificaciones(notificacion_alerta,'','','','','');
          agregarNota('Activar','','','');
        }
      }
    }
  }
}
//Función para mostrar el seguimiento recien almacenado
function seguimientoNota(){
  tipo_informacion='ver_seguimiento';
  $.ajax({
      type : 'POST',
      url:url_proceso,
      dataType:'json',
      data:{tipo_informacion:'ver_seguimiento'},
      success:function(resultado){
        document.getElementById('seguimiento-muestra').style.display='block';
        
        var url='images/usuarios/user-man.png';
          
        var contenedor_seguimiento='contenedor-seguimiento-'+resultado.id_nota;
        var funcion_eliminar_seguimiento='eliminarNota(\''+resultado.id_nota+'\',\''+contenedor_seguimiento+'\')';
        var componenete_seguimiento_usuario='<div class="contenedor-seguimiento" id="'+contenedor_seguimiento+'"><div class="usuario-seguimiento"><img src="'+url+'" class="foto-usuario" alt="Foto de "/><br/><label>'+resultado.nombre_usuario+'</label></div><div class="seguimiento">'+resultado.descripcion_nota+'</div><label class="date-seguimiento">Nota '+resultado.tipo_nota+' | '+resultado.fecha_hora_nota+'</label><div class="linea-seguimiento"></div><div class="opcion-eliminacion" onclick="'+funcion_eliminar_seguimiento+'"><img src="images/lib/eliminar.png" alt="Eliminar seguimiento"/></div></div>';
        $('#seguimiento-muestra').append(componenete_seguimiento_usuario);
      },
      error:function( jqXHR, textStatus, errorThrown ){
      }
  });
}
//Función para confirmar eliminar Notas
function eliminarNota(id_nota,id_contenedor){
  var mensaje_pregunta = '¿Estás seguro de <b>eliminar la nota seleccionada</b>?', funcion_pregunta = 'eliminacionNota('+id_nota+',"'+id_contenedor+'")';
    notificaciones('','','','',mensaje_pregunta,funcion_pregunta);
}
function eliminacionNota(id_nota,id_contenedor){
  var notificacion_envio = 'Por favor, espera...',notificacion_correcta='<strong>¡Listo!</strong>. Nota eliminada.',notificacion_error = 'No se ha podido eliminar la nota. Inténtalo más tarde.',notificacion_formulario = '<b>¡Ups!</b> Al parecer tienes problemas con tu navegador. Reinícialo y vuelve a intentarlo.',tipo_informacion='eliminar_nota';
  notificaciones('','','','','','');
  notificaciones('',notificacion_envio,'','','','');
  var ajax = nuevoAjax();
  ajax.open("POST",url_proceso,true);
  ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //Envío de las variables correspondientes.
  ajax.send("id_nota="+id_nota+"&tipo_informacion="+tipo_informacion);
  ajax.onreadystatechange=function(){
    if(ajax.readyState == 4){
      //Se envia impresión de respuesta al Servidor
      var respuesta = ajax.responseText;
      //Variable que toma las respuesta del Servidor (Sólo sé toma las 2 primeras letras)
      var notificacion = respuesta.substr(0,2);
      //alert(notificacion);
      //Validación para mostrar notificación Correcto
      if(notificacion == 'FR'){
        //Cierra la nostificaciones
        notificaciones('','','','','','');
        //Se envía la notificación de mensaje Error
        notificaciones('','','',notificacion_formulario,'','');
      }
      else if(notificacion == 'ER'){
        //Cierra la nostificaciones
        notificaciones('','','','','','');
        //Se envía la notificación de mensaje Error
        notificaciones('','','',notificacion_error,'','');
      }
      else if(notificacion == 'OK'){
          //Cierra la nostificaciones
          notificaciones('','','','','','');
          document.getElementById(id_contenedor).style.display='none';
          //Nombre de la función correcta para guardar un ticket
          var funcion_fin = 'cerrarCorrecto()';
          //Se envía la notificación de mensaje correcto
          notificaciones('','',notificacion_correcta,'','',funcion_fin);
      }
      else{
        //Cierra la nostificaciones
        notificaciones('','','','','','');
        //Se envía la notificación de mensaje Error
        notificaciones('','','',notificacion_error,'','');
      }
    }
  }
  
}