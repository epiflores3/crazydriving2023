<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');

class Usuario extends UsuarioQueries
{
    protected $id = null; 
    protected $correo = null; 
    protected $alias = null; 
    protected $clave = null; 
    protected $imagen = null; 
    protected $fechacreacion = null; 
    protected $intentos = null; 
    protected $estadousu = null;
    protected $idempleado = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
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

    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imagen = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setFechaCracion($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechacreacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIntentos($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->intentos = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setEstadousuario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            
            $this->estadousu = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idempleado = $value;
            return true;
        } else {
            return false;
        }
    }

       // public function setNombres($value)
    // {
    //     if (Validator::validateAlphabetic($value, 1, 50)) {
    //         $this->nombres = $value;
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function setApellidos($value)
    // {
    //     if (Validator::validateAlphabetic($value, 1, 50)) {
    //         $this->apellidos = $value;
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    
    // public function setTipousuario($value)
    // {
    //     if (Validator::validateNaturalNumber($value)) {
            
    //         $this->tipousuario = $value;
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


    public function getId()
    {
        return $this->id;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getEstadousuario()
    {
        return $this->estadousu;
    }
   
    public function getImagen()
    {
        return $this->imagen;
    }

    public function getFechaCreacion()
    {
        return $this->fechacreacion;
    }

    public function getIntentos()
    {
        return $this->intentos;
    }

    public function getIdEmpleado()
    {
        return $this->idempleado;
    }

    // public function getNombres()
    // {
    //     return $this->nombres;
    // }

    // public function getApellidos()
    // {
    //     return $this->apellidos;
    // }

    // public function getTipousuario()
    // {
    //     return $this->tipousuario;
    // }
}

