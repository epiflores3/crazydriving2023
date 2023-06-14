<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/modelo_queries.php');

class Modelo extends ModeloQueries
{
    protected $id = null;
    protected $modelo = null;
    protected $marca = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setModelo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    } 

    public function setMarca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->marca = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function getMarca()
    {
        return $this->marca;
    }
}
