<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/vehiculo_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Vehiculo extends VehiculoQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $placa = null;
    protected $tipo_vehiculo = null;
    protected $id_modelo = null;

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setPlaca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->placa = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTipoVehiuclo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipo_vehiculo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setId_modelo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_modelo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getId()
    {
        return $this->id;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getPlaca()
    {
        return $this->placa;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTipo_vehiculo()
    {
        return $this->tipo_vehiculo;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getId_Tipo()
    {
        return $this->id_modelo;
    }
}
