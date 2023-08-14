<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/afp_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class AFP extends AfpQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $afp = null;

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
    public function setAfp($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->afp = $value;
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
    public function getAfp()
    {
        return $this->afp;
    }
}
