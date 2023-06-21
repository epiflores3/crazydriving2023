<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/horario_inscripcion_queries.php');

class HorarioInscripcion extends HorarioInscripcionQueries
{
    protected $id = null;
    protected $idhorario = null;
    protected $iddetalleinscripcion = null;
    protected $duicliente = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdHorario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idhorario = $value;
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

    public function setDUI($value)
    {
        if (Validator::validateDUI($value)) {
            $this->duicliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdHorario()
    {
        return $this->idhorario;
    }

    public function getIdDetalleInscripcion()
    {
        return $this->iddetalleinscripcion;
    }

    public function getDUI()
    {
        return $this->duicliente;
    }


}
