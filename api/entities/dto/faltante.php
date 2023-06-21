<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/faltante_queries.php');

class Faltante extends FaltanteQueries
{
    protected $id = null;
    protected $cantidadminuto = null;
    protected $idsesion = null;
    protected $duicliente = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidadMinuto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidadminuto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdSesion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->idsesion = $value;
            return true;
        } else {
            return false;
        }
    }

     public function setDUI($value)
    {
        if (Validator::validateDUI($value)) {
            $this->duicliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCantidadMinjuto()
    {
        return $this->cantidadminuto;
    }

    public function getIdSesion()
    {
        return $this->idsesion;
    }

    public function getDUI()
    {
        return $this->duicliente;
    }


}