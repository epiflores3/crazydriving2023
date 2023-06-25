<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/faltante_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Faltante extends FaltanteQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $cantidadminuto = null;
    protected $idsesion = null;
    protected $duicliente = null;

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setCantidadMinuto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidadminuto = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdSesion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->idsesion = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDUI($value)
    {
        if (Validator::validateDUI($value)) {
            $this->duicliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getId()
    {
        return $this->id;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCantidadMinjuto()
    {
        return $this->cantidadminuto;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdSesion()
    {
        return $this->idsesion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDUI()
    {
        return $this->duicliente;
    }
}
