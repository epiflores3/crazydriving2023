<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/sesion_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Sesion extends SesionQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    //id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, dia, nombre_com_empleado, placa
    protected $id = null;
    protected $inicio = null;
    protected $fin = null;
    protected $tipoclase = null;
    protected $asistencia = null;
    protected $estadosesion = null;
    protected $iddetalleinscripcion = null;
    protected $idempleado = null;
    protected $idvehiculo = null;

    const TIPOCLASE = array(
        array('Práctica', 'Práctica'),
        array('Teórica', 'Teórica'),
        array('Mecánica', 'Mecánica')
    );

    const ESTADOSESION = array(
        array('Pendiente', 'Pendiente'),
        array('Incompleta', 'Incompleta'),
        array('Finalizada', 'Finalizada')
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
    public function setInicio($value)
    {
        if (Validator::validateHours($value)) {
            $this->inicio = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setFin($value)
    {
        if (Validator::validateHours($value)) {
            $this->fin = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setAsistencia($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->asistencia = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTipoClase($value)
    {
          if (in_array($value, array_column(self::TIPOCLASE, 0))) {
            $this->tipoclase = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEstadoSesion($value)
    {
        if (in_array($value, array_column(self::ESTADOSESION, 0))) {
            $this->estadosesion = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdDetalleInscripcion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->iddetalleinscripcion = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idempleado = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdVehiculo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idvehiculo = $value;
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
    public function getInicio()
    {
        return $this->inicio;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getFin()
    {
        return $this->fin;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getAsistencia()
    {
        return $this->asistencia;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTipoClase()
    {
        return $this->tipoclase;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstadoSesion()
    {
        return $this->estadosesion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdDetalleInscripcion()
    {
        return $this->iddetalleinscripcion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdEmpleado()
    {
        return $this->idempleado;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdVehiculo()
    {
        return $this->idvehiculo;
    }
}
