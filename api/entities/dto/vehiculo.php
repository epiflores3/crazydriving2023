<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/vehiculo_queries.php');

class Vehiculo extends VehiculoQueries
{
    protected $id = null;
    protected $placa = null;
    protected $tipo_vehiculo = null;
    protected $id_modelo = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPlaca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->placa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setTipoVehiuclo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipo_vehiculo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setId_modelo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_modelo = $value;
            return true;
        } else {
            return false;
        }
    }


    

    public function getId()
    {
        return $this->id;
    }

    public function getPlaca()
    {
        return $this->placa;
    }

    public function getTipo_vehiculo()
    {
        return $this->tipo_vehiculo;
    }

    public function getId_Tipo()
    {
        return $this->id_modelo;
    }

}
