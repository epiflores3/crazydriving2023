<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/empleado_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Empleado extends EmpleadoQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $nombre = null;
    protected $dui = null;
    protected $licencia = null;
    protected $telefono = null;
    protected $fechaN = null;
    protected $direccion = null;
    protected $correo = null;
    protected $AFP = null;
    protected $estado = null;
    protected $idrol = null;
    protected $idsucursal = null;
    protected $ruta = '../../img/licencia_empleado/';

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
    public function setDui($value)
    {
        if (Validator::validateDUI($value, 1, 50)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setLicencia($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->licencia = Validator::getFileName();
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
    public function setNacimiento($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaN = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDireccion($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->direccion = $value;
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
    public function setAFP($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->AFP = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setRol($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idrol = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setSucursal($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idsucursal = $value;
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
    public function getDUI()
    {
        return $this->dui;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getLicencia()
    {
        return $this->licencia;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTelefono()
    {
        return $this->telefono;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getNacimiento()
    {
        return $this->fechaN;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDireccion()
    {
        return $this->direccion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getCorreo()
    {
        return $this->correo;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getAFP()
    {
        return $this->AFP;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstado()
    {
        return $this->estado;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getRol()
    {
        return $this->idrol;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getSucursal()
    {
        return $this->idsucursal;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getRuta()
    {
        return $this->ruta;
    }
}
