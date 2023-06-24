<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/telefono_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Telefono extends TelefonoQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $telefono = null;
    protected $tipo_telefono = null;
    protected $id_cliente = null;

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
    public function setTelefono($value)
    {
        if (Validator::validatePhone($value, 1, 50)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTipoTelefono($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipo_telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setId_cliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
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
    public function getTelefono()
    {
        return $this->telefono;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTipo_telefono()
    {
        return $this->tipo_telefono;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getId_Tipo()
    {
        return $this->id_cliente;
    }
}
