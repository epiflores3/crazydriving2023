<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/sesion_queries.php');

class Sesion extends SesionQueries
{

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

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setInicio($value)
    {
        if (Validator::validateHours($value)) {
            $this->inicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFin($value)
    {
        if (Validator::validateHours($value)) {
            $this->fin = $value;
            return true;
        } else {
            return false;
        }
    
}

public function setAsistencia($value)
{
    if (Validator::validateBoolean($value)) {
        $this->asistencia = $value;
        return true;
    } else {
        return false;
    }
}

public function setTipoClase($value)
{
    if (Validator::validateAlphanumeric($value, 1, 50)) {
        $this->tipoclase = $value;
        return true;
    } else {
        return false;
    }
}

public function setEstadoSesion($value)
{
    if (Validator::validateAlphanumeric($value, 1, 50)) {
        $this->estadosesion = $value;
        return true;
    } else {
        return false;
    }
}



public function setIdDetalleInscripcion($value)
{
    if (Validator::validateNaturalNumber($value)) {
        $this->iddetalleinscripcion = $value;
        return true;
    } else {
        return false;
    }
}

public function setIdEmpleado($value)
{
    if (Validator::validateNaturalNumber($value)) {
        $this->idempleado = $value;
        return true;
    } else {
        return false;
    }
}

public function setIdVehiculo($value)
{
    if (Validator::validateNaturalNumber($value)) {
        $this->idvehiculo = $value;
        return true;
    } else {
        return false;
    }
}

public function getId()
{
    return $this->id;
}

public function getInicio()
{
    return $this->inicio;
}

public function getFin()
{
    return $this->fin;
}

public function getAsistencia()
{
    return $this->asistencia;
}

public function getTipoClase()
{
    return $this->tipoclase;
}

public function getEstadoSesion()
{
    return $this->estadosesion;
}



public function getIdDetalleInscripcion()
{
    return $this->iddetalleinscripcion;
}

public function getIdEmpleado()
{
    return $this->idempleado;
}

public function getIdVehiculo()
{
    return $this->idvehiculo;
}

}