<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/tipo_paquete_queries.php');

class TipoPaquete extends TipoPaqueteQueries
{
    protected $id = null;
    protected $tipo_paquete = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoPaquete($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipo_paquete = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTipoPaquete()
    {
        return $this->tipo_paquete;
    }
}
