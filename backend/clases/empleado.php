<?php
require_once  "usuario.php";
require_once "icrud.php";
class Empleado extends Usuario implements ICRUD
{
    public string $foto;
    public float $sueldo;
    public function __construct($id, $nombre, $correo, $clave, $id_perfil, $perfil, $foto, $sueldo)
    {
        parent::__construct($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }

    public function get_foto()
    {
        $array=explode("/",$this->foto);
        var_dump($array);
        return $this->foto;
    }
    public function set_foto()
    {
        $errores = [];
        
        $destino=dirname(__DIR__);
        $destino=str_replace('\\',  '/' ,$destino);
        $destino.="/empleados/fotos/";
        
    
      //$destino="./../../empleados/fotos/";
        $tamMax = 100000;
        $aux = isset($_FILES["foto"]) ? $_FILES["foto"] : null;
        if (isset($aux)) {

          
            if ($aux["error"] !== 0) {
                array_push($errores, "error en subida de archivo");
            }

            $array_imagen = getimagesize($aux["tmp_name"]);
            if ($array_imagen === false) {
                array_push($errores, "tipo no valido,no es una imagen");
            }
            if ($aux["size"] > $tamMax) {
                array_push($errores, "imagen supera los 4000");
            }
            if(count($errores)==0)
            {

                $extension=pathinfo($aux["name"],PATHINFO_EXTENSION);
                
                    $archivo="$this->nombre.".date("His").".".$extension;
                    $destino.=$archivo;
                    var_dump($aux["tmp_name"]);
                    echo "DESTINO: $destino";

                move_uploaded_file($aux["tmp_name"],$destino);
                $this->foto="./backend/empleados/fotos/$archivo";
            }
            else{

                var_dump($errores);
                $this->foto="";

            }
        }
    }
    

    /*Agregar (de instancia): agrega, a partir de la instancia actual, un nuevo registro en la tabla empleados
(id,nombre, correo, clave, id_perfil, foto y sueldo), de la base de datos usuarios_test. Retorna true, si se pudo
agregar, false, caso contrario. */
    public function Agregar(): bool
    {
        $agregado = false;
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            $sql = $pdo->prepare("INSERT INTO empleados (nombre,correo,clave,id_perfil,foto,sueldo) VALUES(:nombre,:correo,:clave,:id_perfil,:foto,:sueldo);");
            $sql->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(":correo", $this->correo, PDO::PARAM_STR);
            $sql->bindParam(":clave", $this->clave, PDO::PARAM_STR);
            $sql->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $sql->bindParam(":foto", $this->foto, PDO::PARAM_STR);
            $sql->bindParam(":sueldo", $this->sueldo, PDO::PARAM_STR);

            if ($sql->execute()) {
                $agregado = true;
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
            $agregado = false;
        }
        return $agregado;
    }

    /*
    Modificar (de instancia): Modifica en la base de datos el registro coincidente con la instancia actual (comparar
por id). Retorna true, si se pudo modificar, false, caso contrario.
Nota: Si la foto es pasada, guardarla en “./backend/empleados/fotos/”, con el nombre formado por el nombre
punto tipo punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg). Caso contrario, sólo actualizar
el campo de la base. */
    public function Modificar(): bool
    {
        $modificado=false;
        try {
            $pdo=new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            if($this->foto!==""){
              //UPDATE `empleados` SET `id`='[value-1]',`correo`='[value-2]',`clave`='[value-3]',`nombre`='[value-4]',`id_perfil`='[value-5]',`foto`='[value-6]',`sueldo`='[value-7]' WHERE 1
            $sql=$pdo->prepare("UPDATE empleados SET nombre=:nombre,correo=:correo,clave=:clave,id_perfil=:id_perfil,foto=:foto,sueldo=:sueldo WHERE id=:id;");
            $sql->bindParam(":foto", $this->foto, PDO::PARAM_STR);
            }else
            {
                $sql=$pdo->prepare("UPDATE empleados SET nombre=:nombre,correo=:correo,clave=:clave,id_perfil=:id_perfil,sueldo=:sueldo WHERE id=:id;");
                
            }
            $sql->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
                $sql->bindParam(":correo", $this->correo, PDO::PARAM_STR);
                $sql->bindParam(":clave", $this->clave, PDO::PARAM_STR);
                $sql->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
          
                $sql->bindParam(":sueldo", $this->sueldo, PDO::PARAM_STR);
                
                $sql->bindParam(":id", $this->id, PDO::PARAM_INT);
                if($sql->execute())
                {
                    $modificado=true;
                }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
     

        return $modificado;
    }
    /*
    Eliminar (de clase): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro.
Retorna true, si se pudo eliminar, false, caso contrario */

    public static function Eliminar($id): bool
    {
        $eliminado=false;
        if(isset($id))
        {
            try {
                $pdo=new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
                $sql=$pdo->prepare("DELETE FROM empleados WHERE id=:id;");
                $sql->bindParam(":id", $id, PDO::PARAM_INT);
                if($sql->execute())$eliminado=true;

            } catch (PDOException $th) {
                echo $th->getMessage();
                $eliminado=false;
            }

        }
        return $eliminado;
    }
    public static function TraerTodos(): array
    {
        $array = [];
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            $sql = $pdo->prepare("SELECT empleados.id,empleados.nombre,empleados.correo,empleados.clave,empleados.id_perfil, perfiles.descripcion as perfil,empleados.foto,empleados.sueldo FROM empleados INNER JOIN perfiles ON empleados.id_perfil=perfiles.id");
            //SELECT `id`, `correo`, `clave`, `nombre`, `id_perfil`, `foto`, `sueldo` FROM `empleados` WHERE 1
            $sql->execute();
            while ($fila = $sql->fetchObject()) {

                $aux = new Empleado((int)$fila->id, $fila->nombre, $fila->correo, $fila->clave, (int)$fila->id_perfil, $fila->perfil, $fila->foto, $fila->sueldo);
                array_push($array, $aux);
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            $array = null;
        }
        return $array;
    }
}
