<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/modelo_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Modelo extends ModeloQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $modelo = null;
    protected $tipo_vehiculo = null;
    protected $marca = null;

    const TIPOVEHICULO = array(
        array('Carro', 'Carro'),
        array('Pick up', 'Pick up'),
        array('Motocicleta', 'Motocicleta')
    );

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
    public function setModelo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTipoVehiculo($value)
    {
        if (in_array($value, array_column(self::TIPOVEHICULO, 0))) {
            $this->tipo_vehiculo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setMarca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->marca = $value;
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
    public function getModelo()
    {
        return $this->modelo;
    }

     //Método para obtener los valores de los atributos correspondientes
     public function getTipo_vehiculo()
     {
         return $this->tipo_vehiculo;
     }

    //Método para obtener los valores de los atributos correspondientes
    public function getMarca()
    {
        return $this->marca;
    }
}
