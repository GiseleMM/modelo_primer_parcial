<?php

/*Crear, en ./backend/clases, la interface IBM. Esta interface poseerá los métodos:
Modificar: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
Retorna true, si se pudo modificar, false, caso contrario.
Eliminar (estático): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro.
Retorna true, si se pudo eliminar, false, caso contrario. */
interface IBM
{
    public function Modificar():bool;
    public static function Eliminar($id):bool;

}
?>