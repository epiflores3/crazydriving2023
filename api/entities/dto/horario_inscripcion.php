<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/horario_inscripcion_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class HorarioInscripcion extends HorarioInscripcionQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $idhorario = null;
    protected $iddetalleinscripcion = null;
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
    public function setIdHorario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idhorario = $value;
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
    public function getIdHorario()
    {
        return $this->idhorario;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdDetalleInscripcion()
    {
        return $this->iddetalleinscripcion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getDUI()
    {
        return $this->duicliente;
    }
}
