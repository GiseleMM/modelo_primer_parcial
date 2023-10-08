<?php
/**AltaUsuario.php: Se recibe por POST el correo, la clave, el nombre y el id_perfil. Se invocará al método
Agregar.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido. */
require_once "./clases/usuario.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
$correo=isset($_POST["correo"])?trim($_POST["correo"]):null;

$clave=isset($_POST["clave"])?trim($_POST["clave"]):null;

$nombre=isset($_POST["nombre"])?trim($_POST["nombre"]):null;

$id_perfil=isset($_POST["id_perfil"])?trim($_POST["id_perfil"]):null;
    ///VALIDAR LARGO DE CLAVE

$usuario=new Usuario(-1,$nombre,$correo,$clave,(int)$id_perfil,"");
if($usuario->Agregar())
{
    echo '{"exito":true,"mensaje":"usuario agregado"}';
}else{
    
    echo '{"exito":false,"mensaje":"usaurio NO agregado en base de datos"}';
}
}
?>