<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/marca_queries.php');

class Marca extends MarcaQueries
{
    protected $id = null;
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

    public function getMarca()
    {
        return $this->marca;
    }
}
