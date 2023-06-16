<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/telefono_queries.php');

class Telefono extends TelefonoQueries
{
    protected $id = null;
    protected $telefono = null;
    protected $tipo_telefono = null;
    protected $id_cliente = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validatePhone($value, 1, 50)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoTelefono($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipo_telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setId_cliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            return false;
        }
    }


    

    public function getId()
    {
        return $this->id;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getTipo_telefono()
    {
        return $this->tipo_telefono;
    }

    public function getId_Tipo()
    {
        return $this->id_cliente;
    }

}
