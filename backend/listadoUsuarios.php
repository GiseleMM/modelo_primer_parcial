<?php

/**ListadoUsuarios.php: (GET) Se mostrará el listado completo de los usuarios, exepto la clave (obtenidos de la
base de datos) en una tabla (HTML con cabecera). Invocar al método TraerTodos. */
require_once "./clases/usuario.php";
if($_SERVER["REQUEST_METHOD"]=="GET")
{
$array=Usuario::TraerTodos();
if(isset($array)){
    echo grilla($array);
}
}


function grilla($array){

   
    $tabla="<table style='border: 1px solid blue ;background-color:aquamarine'>
    <thead>
        <tr>";
    
            $tabla.= "<th>ID </th>";
            
            $tabla.= "<th>NOMBRE</th>";
            
            $tabla.= "<th>CORREO </th>";
            
            $tabla.= "<th> CLAVE </th>";
            
            $tabla.= "<th>ID_PERFIL </th>";
            
            $tabla.= "<th>PERFIL </th>";
    
        $tabla.="
        </tr>
    </thead>
    <tbody>";
        foreach ($array as $key => $value) {
        $tabla.="<tr><td> $value->id <td>";
        $tabla.="<td> $value->nombre <td>";
        $tabla.="<td> $value->correo <td>";
        $tabla.="<td> $value->clave <td>";
        $tabla.="<td> $value->id_perfil <td>";
        $tabla.="<td> $value->perfil <td></tr>";
        }
$tabla.="</tbody>
        </table>";

return $tabla;
}
?>