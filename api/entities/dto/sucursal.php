<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/sucursal_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Sucursal extends SucursalQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $nombre_sucursal = null;
    protected $direccion_sucursal = null;

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
    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_sucursal = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDireccion($value)
    {
        if (Validator::validateString($value, 1, 100)) {
            $this->direccion_sucursal = $value;
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
    public function getNombre()
    {
        return $this->nombre_sucursal;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDireccion()
    {
        return $this->direccion_sucursal;
    }
}
