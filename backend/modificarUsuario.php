<?php

/**Crear las siguientes páginas, en el directorio backend del proyecto:
ModificarUsuario.php: Se recibirán por POST los siguientes valores: usuario_json (id, nombre, correo, clave y
id_perfil, en formato de cadena JSON), para modificar un usuario en la base de datos. Invocar al método
Modificar.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
*/
require_once "./clases/usuario.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $usuario_json=isset($_POST["usuario_json"])?trim($_POST["usuario_json"]):null;
    if(isset($usuario_json))
    {
        $std=json_decode($usuario_json);
        $usuario=new Usuario($std->id,$tdo->nombre,$std->correo,$std->clave,$std->id_perfil,"");
        if($usuario->Modificar())
        {
            echo '{"exito":true,"mensaje":"modificacion exitosa"}';
        }else
        {
            echo '{"exito":false,"mensaje":"falla en modificacion"}';            
        }

    }
}
?>