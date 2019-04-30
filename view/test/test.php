<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>TEST</title>
		<meta name="description" content="TEST"/> 
		<meta name="copyright" content="© 2019. Christian Zapata"/>
		<meta name="author" content="Christian Zapata"/>
		<link href="images/lib/service_icono.ico" type="image/x-icon" rel="shortcut icon"/>
		<!--CSS-->
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta_css;?>style.css"/>
		<!--Contiene los estilos que se usan en el sistema para Resoluciones grandes-->
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta_css;?>styleGreat.css" media="screen and (min-width: 981px)"/>
		<!--Contiene los estilos que se usan en el sistema para Resoluciones pequeñas-->
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta_css;?>styleMini.css"  media="screen and (max-width: 980px)"/>
		<!--Contiene los estilos que se en la vista actual para Resoluciones Grandes-->
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta_css;?>test/testGreat.css" media="screen and (min-width: 981px)"/>
		<!--Contiene los estilos que se en la vista actual para Resoluciones Pequeñas-->
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta_css;?>test/testMini.css" media="screen and (max-width: 980px)"/>

	</head>

	<body>
		<div id="transparencia_popup" class="transparencia_notificacion">
		<div class="contenedor-formularios-popups" id="contenedor-formularios-popups">
			<form id="form-nota" name="form-nota" method="post" style="display:none;">
				<div class="componente-informacion-largo-popup">
					<hr class="linea-solida">
					<h3>Agregar nota</h3>
					<hr class="linea-solida">

				</div>
				<div class="componente-formulario-popup">
					<label>Tipo de nota:</label>
					<select name="tipo_nota" id="tipo_nota">
						<option value="Privada">Privada</option>
						<option value="Pública">Pública</option>
					</select>	
				</div>
				<div class="componente-formulario-textarea-popup">
					<b class="obligatorio">*</b><label>Nota:</label> <label class="mostrar-informacion" id="contadorDescripcion">0/700</label>
					<textarea name="nota" id="nota" onkeyup="caracteresDescripcion()" placeholder="Añade tu nota (4 a 700 caracteres)" maxlength="700"></textarea>
					<div id="error-nota" class="error-formulario"></div>
				</div>
				
				<div class="componente-botones-centrados" style="width:80%">
					<input type="button" value="Cerrar" class="cancelar alineacion-left display-great" onclick="agregarNota('Desactivar')" />
					<input type="button" value="Guardar" class="aceptar alineacion-right display-great" onclick="guardarNota()" />
				</div>
				
				<div class="botones-flotantes display-mini">
					<input type="button" value="Cerrar" class="cancelar-50 alineacion-left display-mini" onclick="agregarNota('Desactivar')" />
					<input type="button" value="Guardar" class="aceptar-50 alineacion-left display-mini" onclick="guardarNota()" />
				</div>
			</form>
		</div>
	</div>
		<!-- MSJ -->
		<div id="transparencia" class="transparencia_notificacion">
			<div id="mensaje" class="notificacion"></div>
		</div>

		<section>
			<?php
			//Archivo que muestra reporte creado
			include('test.html');
			?>
		</section>

		<footer class="flotante">
			<?php
			//Archivo del FOOTER
			include('view/estructura/footer.html');
			?>
		</footer>

		<script src="js/lib/jquery/jquery.js" type="text/javascript"></script>
		<!--JS para poder validar los campos del formulario-->
		<script src="js/lib/validador.js" type="text/javascript"></script>
		<!--JS para poder enviar notificaciones a Usuario-->
		<script src="js/lib/notificaciones.js" type="text/javascript"></script>
		<!--JS de vista, para proceso del formulario-->
		<script src="js/test/test.js" type="text/javascript"></script>
	</body>
</html>