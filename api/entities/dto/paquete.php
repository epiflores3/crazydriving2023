<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/paquete_queries.php');

class Paquete extends PaqueteQueries
{
    protected $id = null;
    protected $descripp = null;
    protected $valorpaquete = null;
    protected $transmision = null;
    protected $cantidadclase = null;
    protected $idtipopaquete = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripp = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setValorPaquete($value)
    {
        if (Validator::validateMoney($value)) {
            $this->valorpaquete = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTranmision($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->transmision = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidadClase($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidadclase = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoPaquete($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idtipopaquete = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescripcion()
    {
        return $this->descripp;
    }

    public function getValorPaquete()
    {
        return $this->valorpaquete;
    }

    public function getTransmision()
    {
        return $this->transmision;
    }

    public function getCantidadClase()
    {
        return $this->cantidadclase;
    }
    public function getTipoPaquete()
    {
        return $this->idtipopaquete;
    }

}
