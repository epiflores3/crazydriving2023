<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/notificacion_queries.php');

class Notificacion extends NotificacionQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $accion = null;

    public function setAccion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->accion = $value;
            return true;
        } else {
            return false;
        }
    }
    public function getAccion()
    {
        return $this->accion;
    }

}
