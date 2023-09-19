<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/registros_intentos_queries.php');

class RegistrosFallidos extends RegistrosFallidosQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $usuario = null;
    protected $accion = null;

    public function setUsuarios($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

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

    public function getUsuario()
    {
        return $this->usuario;
    }

}
