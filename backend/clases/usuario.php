<?php
require_once "ibm.php";
class Usuario implements IBM
{
    //CLAVE DE OCHO base de datos
    //ningun null sin perfil
    //id_pefil fK INT
    //id INT 
    //resto varchar
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    public function __construct(int $id, string $nombre, string $correo, string $clave, int $id_perfil, string $perfil)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        $this->perfil = $perfil;
    }
    public function ToJSON(): string
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
    public function GuardarEnArchivo(): string
    {
        $obj = new stdClass();
        // echo  dirname(__DIR__);
        // echo "**********************";
        // echo __FILE__;die();
        $path =dirname(__DIR__)."\archivos\usuarios.json";
        
        $array = array();
        try {
            $contenido = file_get_contents($path);
            if ($contenido === false) {
                array_push($array, $this);
            } else {

                $buffer = json_decode($contenido);

                $array = array_map(function ($s) {
                    $aux = new Usuario($s->id, $s->nombre, $s->correo, $s->clave, $s->id_perfil, $s->perfil);
                    return $aux;
                }, $buffer);
                array_push($array, $this);
                var_dump($array);
            }

            if (file_put_contents($path, json_encode($array, JSON_PRETTY_PRINT))) {
                $obj->exito = "true";
                $obj->mensaje = "Guardado en archivo $path";
            } else {
                $obj->exito = "false";
                $obj->mensaje = "Error guardado en archivo $path";
            }
        } catch (Exception $th) {
            $obj->exito = "false";
            $mensaje = $th->getMessage();
            $obj->mensaje = "Excepcion en guardado en archivo $mensaje";
        }


        return json_encode($obj, JSON_PRETTY_PRINT);
    }

    public static function TraerTodosJSON(): array
    {
        $path =dirname(__DIR__)."\archivos\usuarios.json";
        $array = array();
        try {
            $contenido = file_get_contents($path);
            if ($contenido !== false) {

                $buffer = json_decode($contenido);

                $array = array_map(function ($s) {
                    $aux = new Usuario($s->id, $s->nombre, $s->correo, $s->clave, $s->id_perfil, $s->perfil);
                    return $aux;
                }, $buffer);
            }
        } catch (Exception) {
            return null;
        }
        return $array;
    }

    /**Método de instancia Agregar(): agrega, a partir de la instancia actual, un nuevo registro en la tabla usuarios
(id,nombre, correo, clave e id_perfil), de la base de datos usuarios_test. Retorna true, si se pudo agregar,
false, caso contrario. */
    public function Agregar(): bool
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root", "");
            $sql = $pdo->prepare("INSERT INTO usuarios (nombre,correo,clave,id_perfil) VALUES(:nombre,:correo,:clave,:id_perfil)");
            $sql->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(":correo", $this->correo, PDO::PARAM_STR);
            $sql->bindParam(":clave", $this->clave, PDO::PARAM_STR);
            $sql->bindParam(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

            if ($sql->execute()) {

                return true;
            }
            return false;
        } catch (PDOException) {
            return false;
        }
    }
    /*
    Método de clase TraerTodos(): retorna un array de objetos de tipo Usuario, recuperados de la base de datos
(con la descripción del perfil correspondiente).
     */
    public static function TraerTodos(): array
    {
        $array = array();
        try {
            $pdo = new PDo("mysql:host=localhost;dbname=usuarios_test", "root", "");
            $sql = $pdo->prepare("SELECT usuarios.id, usuarios.nombre,usuarios.correo,usuarios.clave,usuarios.id_perfil, perfiles.descripcion as perfil FROM usuarios INNER JOIN perfiles ON usuarios.id_perfil=perfiles.id");
            $sql->execute();
            while ($fila = $sql->fetchObject()) {

                $aux = new Usuario((int)$fila->id, $fila->nombre, $fila->correo, $fila->clave, (int)$fila->id_perfil, $fila->perfil);
                array_push($array, $aux);
            }
        } catch (PDOException $th) {
            echo $th->getMessage();
        }

        // var_dump($array);
        return $array;
    }

//     Método de clase TraerUno($params): retorna un objeto de tipo Usuario, de acuerdo al correo y clave que ser
// reciben en el parámetro $params.
    public static function TraerUno(string $correo,string $clave):Usuario|null
    {
        $usuario=null;
        try {
            $pdo=new PDO("mysql:host=localhost;dbname=usuarios_test","root","");

            $sql=$pdo->prepare("SELECT usuarios.id,usuarios.nombre,usuarios.correo,usuarios.clave,usuarios.id_perfil ,perfiles.descripcion as perfil FROM usuarios INNER JOIN perfiles ON usuarios.id_perfil=perfiles.id WHERE correo=:correo AND clave=:clave");
            $sql->bindParam(":correo",$correo,PDO::PARAM_STR);
            $sql->bindParam(":clave",$clave,PDO::PARAM_STR);
            $sql->execute();
            $fila=$sql->fetch();
          if($fila!==false)
                $usuario= new Usuario((int)$fila["id"], $fila["nombre"], $fila["correo"], $fila["clave"], (int)$fila["id_perfil"], $fila["perfil"]);
            
            

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return $usuario;
 
    }
    // la interface IBM. Esta interface poseerá los métodos:
//Modificar: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
//Retorna true, si se pudo modificar, false, caso contrario.
    public function Modificar(): bool
    {
        $modificado=false;

        try {

$pdo=new PDo("mysql:host=localhost;dbname=usuarios_test","root","");
$sql=$pdo->prepare("UPDATE usuarios SET  (nombre,correo,clave,id_perfil) VALUES (:nombre,:correo,:clave,:id_perfil) WHERE id=:id;");
$sql->bindParam(":nombre",$this->nombre,PDO::PARAM_STR);
$sql->bindParam(":correo",$this->correo,PDO::PARAM_STR);
$sql->bindParam(":clave",$this->clave,PDO::PARAM_STR);
$sql->bindParam(":id_perfil",$this->id_perfil,PDO::PARAM_INT);
$sql->bindParam(":id",$this->id,PDO::PARAM_INT);
if($sql->execute()) $modificado=true;

        } catch (PDOException $th) {
            $modificado=false;
        }
        return $modificado;
    }
/*Eliminar (estático): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro.
Retorna true, si se pudo eliminar, false, caso contrario. */ 
    public static function Eliminar($id): bool
    {
        $elimanado=false;
        if(isset($id))
        {
            try {
                $pdo=new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
                $sql=$pdo->prepare("DELETE FROM usuarios WHERE id=:id;");
                $sql->bindParam(":id",$id,PDO::PARAM_INT);
                if($sql->execute())
                {
                    $elimanado=true;
                }


            } catch (PDOException $th) {
               $elimanado=false;
            }
        }
        return $elimanado;
    }
}
