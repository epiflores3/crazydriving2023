<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/empleado_queries.php');

class Empleado extends EmpleadoQueries
{

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

    public function setDui($value)
    {
        if (Validator::validateDUI($value, 1, 50)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setLicencia($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->licencia = Validator::getFileName();
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

    public function setNacimiento($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaN = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->direccion = $value;
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

    public function setAFP($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->AFP = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setRol($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idrol = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSucursal($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idsucursal = $value;
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

    public function getDUI()
    {
        return $this->dui;
    }

    public function getLicencia()
    {
        return $this->licencia;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getNacimiento()
    {
        return $this->fechaN;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getAFP()
    {
        return $this->AFP;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getRol()
    {
        return $this->idrol;
    }

    public function getSucursal()
    {
        return $this->idsucursal;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}
