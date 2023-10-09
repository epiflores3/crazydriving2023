<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/paquete_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Paquete extends PaqueteQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $descripp = null;
    protected $valorpaquete = null;
    protected $transmision = null;
    protected $cantidadclase = null;
    protected $idtipopaquete = null;

    const TRANSMISION = array(
        array('Estándar', 'Estándar'),
        array('Automático', 'Automático')
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
    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripp = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setValorPaquete($value)
    {
        if (Validator::validateMoney($value)) {
            $this->valorpaquete = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTranmision($value)
    {
        //print_r(array_search($value, array_column(self::TRANSMISION, 0)));
        if (in_array($value, array_column(self::TRANSMISION, 0))) {
            $this->transmision = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setCantidadClase($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidadclase = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTipoPaquete($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idtipopaquete = $value;
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
    public function getDescripcion()
    {
        return $this->descripp;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getValorPaquete()
    {
        return $this->valorpaquete;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTransmision()
    {
        return $this->transmision;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCantidadClase()
    {
        return $this->cantidadclase;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTipoPaquete()
    {
        return $this->idtipopaquete;
    }
}
