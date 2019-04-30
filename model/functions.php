<?php
//Contiene el nombre de las Clases para su respectivo llamado
$jsArr = array();

//Función de precarga de un archivo para tomar el nombre de la Clase
function __autoload($class_name) {
    require_once ''.$class_name . 'Model.php';
}

?>