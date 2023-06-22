<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/inscripcion_queries.php');

class Inscripcion extends InscripcionQueries{

   // id_inscripcion, anticipo_paquete, fecha_registro, fecha_inicio, evaluacion, tipolicencia, estado_cliente, id_cliente, id_empleado

    protected $id = null;
    protected $anticipo = null;
    protected $fecharegistro = null;
    protected $fechainicio = null;
    protected $evaluacion = null;
    protected $tipolicencia = null;
    protected $estadocliente = null;
    protected $idcliente = null;
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

    public function setAnticipo($value)
    {
        if (Validator::validateMoney($value)) {
            $this->anticipo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechar($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecharegistro = $value;
            return true;
        } else {
            return false;
        }
    }
  
    
    public function setFechai($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechainicio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEvaluacion($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->evaluacion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadocliente = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setTlicencia($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->tipolicencia = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setIdcliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdempleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idempleado = $value;
            return true;
        } else {
            return false;
        }
    }

   
public function getId()
{
    return $this->id;
}

public function getAnticipo()
    {
        return $this->anticipo;
    }

    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    public function getEvaluacion()
    {
        return $this->evaluacion;
    }

    public function getEstado()
    {
        return $this->evaluacion;
    }


    public function getTipolicencia()
    {
        return $this->tipolicencia;
    }

    public function getEstadocliente()
    {
        return $this->estadocliente;
    }

    public function getIdcliente()
    {
        return $this->idcliente;
    }

    public function getIdempleado()
    {
        return $this->idempleado;
    }

    
    

}
