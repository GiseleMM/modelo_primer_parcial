<?php
/*
EliminarEmpleado.php: Recibe el parámetro id por POST y se deberá borrar el empleado (invocando al
método Eliminar).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/
require_once "./clases/empleado.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{

    $id=isset($_POST["id"])?trim($_POST["id"]):null;
    if(isset($id))
    {
        if(Empleado::Eliminar((int)$id))
        {
            echo '{"exito":true,"mensaje":"eliminacion exitosa"}';
        }else{
            
            echo '{"exito":false,"mensaje":"ERROR en eliminacion"}';
        }

    }else
    {
        
        echo '{"exito":false,"mensaje":"ERROR eliminacion id no valido"}';
    }

}

?>