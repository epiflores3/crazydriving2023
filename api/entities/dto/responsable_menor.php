<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/responsable_menor_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Responsable extends ResponsableQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $nombre = null;
    protected $telefono = null;
    protected $correo = null;
    protected $dui = null;
    protected $parentesco = null;
    protected $idcliente = null;

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
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDui($value)
    {
        if (Validator::validateDUI($value)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setParentesco($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->parentesco = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcliente = $value;
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
        return $this->nombre;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTelefono()
    {
        return $this->telefono;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCorreo()
    {
        return $this->correo;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDui()
    {
        return $this->dui;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getParentesco()
    {
        return $this->parentesco;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdCliente()
    {
        return $this->idcliente;
    }
}
