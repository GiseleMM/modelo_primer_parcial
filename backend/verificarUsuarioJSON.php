<?php
require_once "./clases/usuario.php";
/*VerificarUsuarioJSON.php: (POST) Se recibe el parámetro usuario_json (correo y clave, en formato de cadena
JSON) y se invoca al método TraerUno.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $usuario_json=isset($_POST["usuario_json"])?trim($_POST["usuario_json"]):null;
    if(isset($usuario_json))
    {

        $std=json_decode($usuario_json);
      $usuario=Usuario::TraerUno($std->correo,$std->clave);
      if(isset($usuario))
      {
        echo '{"exito":true,"mensaje":"usuario encontrado id='.$usuario->id.'"}';
      }else{
        echo '{"exito":false,"mensaje":"usuario NO encontrado"}';
      }
    }
}
?>