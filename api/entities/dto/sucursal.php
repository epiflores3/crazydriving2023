<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/sucursal_queries.php');

class Sucursal extends SucursalQueries
{
    protected $id = null;
    protected $nombre_sucursal = null;
    protected $direccion_sucursal = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_sucursal = $value;
            return true;
        } else {
            return false;
        }
    } 

    public function setDireccion($value)
    {
        if (Validator::validateString($value, 1, 100)) {
            $this->direccion_sucursal = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre_sucursal;
    }

    public function getDireccion()
    {
        return $this->direccion_sucursal;
    }
}
