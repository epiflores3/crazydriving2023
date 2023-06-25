<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/horario_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Horario extends HorarioQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $inicio = null;
    protected $fin = null;

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
    public function setInicio($value)
    {
        if (Validator::validateHours($value)) {
            $this->inicio = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setFin($value)
    {
        if (Validator::validateHours($value)) {
            $this->fin = $value;
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
    public function getIncio()
    {
        return $this->inicio;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getFin()
    {
        return $this->fin;
    }
}
