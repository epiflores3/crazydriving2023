<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Usuario extends UsuarioQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $correo = null;
    protected $alias = null;
    protected $clave = null;
    protected $imagen_usuario = null;
    protected $fechacreacion = null;
    protected $intentos = null;
    protected $estadousu = null;
    protected $idempleado = null;
    protected $codigo_recuperacion = null;
    protected $ruta = '../../images/usuario/';

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
    
    public function setCodigoRecuperacion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->codigo_recuperacion = $value;
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
    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setClave($value, $user)
    {
        if (Validator::validatePassword($value, $user)) {
            $this->clave = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imagen_usuario = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setFechaCracion($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechacreacion = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIntentos($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->intentos = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEstadousuario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {

            $this->estadousu = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idempleado = $value;
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
    public function getCorreo()
    {
        return $this->correo;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getAlias()
    {
        return $this->alias;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getClave()
    {
        return $this->clave;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstadousuario()
    {
        return $this->estadousu;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getImagen()
    {
        return $this->imagen_usuario;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getFechaCreacion()
    {
        return $this->fechacreacion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIntentos()
    {
        return $this->intentos;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdEmpleado()
    {
        return $this->idempleado;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getRuta()
    {
        return $this->ruta;
    }
    public function getCodigoRecuperacion()
    {
        return $this->codigo_recuperacion;
    }
}
