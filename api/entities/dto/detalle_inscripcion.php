<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_inscripcion_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class DetalleInscripcion extends DetalleInscripcionQueries
{
    //id_detalle_inscripcion, fecha_inicio, dia, id_paquete, id_inscripcion, id_empleado
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $fechainicio = null;
    protected $dia = null;
    protected $idpaquete = null;
    protected $idinscripcion = null;
    protected $idempleado = null;
    protected $duicliente = null;



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
    public function setFechaInicio($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechainicio = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDia($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->dia = $value;
            return true;
        } else {
            return false;
        }
    }


    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdEmpleado($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->idempleado = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdPaquete($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->idpaquete = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdInscripcion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->idinscripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setDUI($value)
    {
        if (Validator::validateDUI($value)) {
            $this->duicliente = $value;
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
    public function getFechaInicio()
    {
        return $this->fechainicio;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDia()
    {
        return $this->dia;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getPaquete()
    {
        return $this->idpaquete;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getInscripcion()
    {
        return $this->idinscripcion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEmpleado()
    {
        return $this->idempleado;
    }

     //Método para obtener los valores de los atributos correspondientes
     public function getDUI()
     {
         return $this->duicliente;
     }
}
