<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/responsable_menor_queries.php');

class Responsable extends ResponsableQueries
{
    protected $id = null;
    protected $nombre = null;
    protected $telefono = null;
    protected $correo = null;
    protected $dui = null;
    protected $parentesco = null;
    protected $idcliente = null;

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
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDui($value)
    {
        if (Validator::validateDUI($value)){
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setParentesco($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->parentesco = $value;
            return true;
        } else {
            return false;
        }
    }
    
    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcliente = $value;
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
        return $this->nombre;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getDui()
    {
        return $this->dui;
    }

    public function getParentesco()
    {
        return $this->parentesco;
    }

    public function getIdCliente()
    {
        return $this->idcliente;
    }
}
