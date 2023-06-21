<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/horario_queries.php');

class Horario extends HorarioQueries
{
    protected $id = null;
    protected $inicio = null;
    protected $fin = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setInicio($value)
    {
        if (Validator::validateHours($value)) {
            $this->inicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFin($value)
    {
        if (Validator::validateHours($value)) {
            $this->fin = $value;
            return true;
        } else {
            return false;
        }
    }


    public function getId()
    {
        return $this->id;
    }

    public function getIncio()
    {
        return $this->inicio;
    }

    public function getFin()
    {
        return $this->fin;
    }
}
