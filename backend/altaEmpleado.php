<?php 
/*

Crear las siguientes páginas, en el directorio backend del proyecto:

AltaEmpleado.php: Se recibirán por POST todos los valores: nombre, correo, clave, id_perfil, sueldo y foto
para registrar un empleado en la base de datos.
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
 */
require_once "./clases/empleado.php";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if($_POST)
    {
        $nombre=isset($_POST["nombre"])?trim($_POST["nombre"]):null;
    
        $correo=isset($_POST["correo"])?trim($_POST["correo"]):null;
        
        $clave=isset($_POST["clave"])?trim($_POST["clave"]):null;
        
        $id_perfil=isset($_POST["id_perfil"])?trim($_POST["id_perfil"]):null;
        
        $sueldo=isset($_POST["sueldo"])?trim($_POST["sueldo"]):null;
        if(isset($nombre,$correo,$clave,$id_perfil,$sueldo))
        {
            $em=new Empleado(-1,$nombre,$correo,$clave,(int)$id_perfil,"","",$sueldo);
            $em->set_foto();//modifica la foto
            if($em->Agregar())
            {
                echo '{"exito":true,"mensaje":"Alta exitosa"}';
            }else{
                
                echo '{"exito":false,"mensaje":"NO se pudo dar el alta"}';
            }
        }else
        {
            echo '{"exito":false,"mensaje":"NO se pudo dar el alta"}';
        }
    }


}
?>