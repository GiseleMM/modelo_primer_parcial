<?php

/*
ListadoEmpleados.php: (GET) Se mostrará el listado completo de los empleados (obtenidos de la base de
datos) en una tabla (HTML con cabecera). Invocar al método TraerTodos.
Nota: preparar la tabla (HTML) con una columna extra para que muestre la imagen de la foto (50px X 50px).
 */
require_once "./clases/empleado.php";
//var_dump($_SERVER);
 if($_SERVER["REQUEST_METHOD"]=="GET")
 {
    
        $array=Empleado::TraerTodos();
    echo "estoy en listado";
       echo grilla($array);
  


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
                $tabla.= "<th>SUELDO </th>";
                $tabla.= "<th>FOTO </th>";
        
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
            $tabla.="<td> $value->perfil <td>";
            $tabla.="<td> $value->sueldo <td>";
$array=explode("/",$value->foto);
$foto=end($array);

            $tabla.='<td><img src="./empleados/fotos/'.$foto.' " alt="foto empleado" srcset="" width="100px" height="100px"> <td>';

            
            $tabla.="</tr>";
            }
    $tabla.="</tbody>
            </table>";
    
    return $tabla;
    }
 
?>
