<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class NotificacionQueries
{
    public function createNoti()
    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('d-m-Y');
        $time = date("H:i:s");
        $sql = 'INSERT INTO notificacion(accion, fecha_registro, hora)
        VALUES (?, ?, ?)';
        $params = array($this->accion, $date, $time);
        return Database::executeRow($sql, $params);
    }

}