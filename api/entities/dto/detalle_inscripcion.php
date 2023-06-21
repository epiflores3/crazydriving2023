<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/detalle_inscripcion_queries.php');

class DetalleInscripcion extends DetalleInscripcionQueries{
    //id_detalle_inscripcion, fecha_inicio, dia, id_paquete, id_inscripcion, id_empleado
    protected $id = null;
    protected $fechainicio = null;
    protected $dia = null;
    protected $idpaquete = null;
    protected $idinscripcion = null;
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

    public function setFechaInicio($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechainicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDia($value)
{
    if (Validator::validateAlphanumeric($value, 1, 50)) {
        $this->dia = $value;
        return true;
    } else {
        return false;
    }
}


public function setIdEmpleado($value)
{
    if (Validator::validateAlphanumeric($value, 1, 50)) {
        $this->idempleado = $value;
        return true;
    } else {
        return false;
    }
}

public function setIdPaquete($value)
{
    if (Validator::validateAlphanumeric($value, 1, 50)) {
        $this->idpaquete = $value;
        return true;
    } else {
        return false;
    }
}

public function setIdInscripcion($value)
{
    if (Validator::validateAlphanumeric($value, 1, 50)) {
        $this->idinscripcion = $value;
        return true;
    } else {
        return false;
    }
}

public function getId()
{
    return $this->id;
}

public function getFechaInicio()
{
    return $this->fechainicio;
}

public function getDia()
{
    return $this->dia;
}

public function getPaquete()
{
    return $this->idpaquete;
}

public function getInscripcion()
{
    return $this->idinscripcion;
}

public function getEmpleado()
{
    return $this->idempleado;
}


}
