<?php
//ListadoUsuariosJSON.php: (GET) Se mostrará el listado de todos los usuarios en formato JSON.

require_once "./clases/usuario.php";

$array=Usuario::TraerTodosJSON();
foreach ($array as $key => $value) {
    echo $value->ToJSON().",</br>";
}
?>