<?php

/**ModificarEmpleado.php: Se recibirán por POST los siguientes valores: empleado_json (id, nombre, correo,
clave, id_perfil, sueldo y pathFoto, en formato de cadena JSON) y foto (para modificar un empleado en la base
de datos. Invocar al método Modificar.
Nota: El valor del id, será el id del empleado 'original', mientras que el resto de los valores serán los del
empleado modificado.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */
require_once "./clases/empleado.php";


if($_SERVER["REQUEST_METHOD"]=="POST")
{


    $empleado_json=isset($_POST["empleado_json"])?trim($_POST["empleado_json"]):null;
    $std=json_decode($empleado_json);
    var_dump($std);
    $empl_modificar=new Empleado($std->id,$std->nombre,$std->correo,$std->clave,$std->id_perfil,"",$std->pathFoto,$std->sueldo);
    $empl_modificar->set_foto();
    if($empl_modificar->Modificar())
    {
        echo '{"exito":true,"mensaje":"modificacion exitosa"}';
    }else
    {
        
        echo '{"exito":false,"mensaje":"Error en  modificacion"}';
    }
}
?>