<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class RegistrosFallidosQueries
{
   
//Para leer la tabla de los refistros fallidos
    public function readAll()
    {
        $sql = 'SELECT id_bitacora, usuario, accion, fecha_realizado, estado_usuario
        FROM bitacora';
        return Database::getRows($sql);
    }

}