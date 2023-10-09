<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/inscripcion_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class Inscripcion extends InscripcionQueries
{
    // id_inscripcion, anticipo_paquete, fecha_registro, fecha_inicio, evaluacion, tipolicencia, estado_cliente, id_cliente, id_empleado
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $anticipo = null;
    protected $fecharegistro = null;
    protected $fechainicio = null;
    protected $evaluacion = null;
    protected $tipolicencia = null;
    protected $estadocliente = null;
    protected $idpaquete = null;
    protected $idcliente = null;
    protected $idempleado = null;
    protected $idhorario = null;

    const ESTADOS = array(
        array('En proceso', 'En proceso'),
        array('Pendiente', 'Pendiente'),
        array('Finalizado', 'Finalizado'),
        array('Suspendido', 'Suspendido')
    );

    const TIPOLICENCIA = array(
        array('Liviana', 'Liviana'),
        array('Particular', 'Particular'),
        array('Motocicleta', 'Motocicleta'),
        array('Juvenil motocicleta', 'Juvenil motocicleta'),
        array('Juvenil particular', 'Juvenil particular'),
        array('Pesada', 'Pesada'),
        array('Pesada T', 'Pesada T')
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
    public function setAnticipo($value)
    {
        if (Validator::validateMoney($value)) {
            $this->anticipo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setFechar($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecharegistro = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setFechai($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechainicio = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEvaluacion($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->evaluacion = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setEstado($value)
    {
        if (in_array($value, array_column(self::ESTADOS, 0))) {
            $this->estadocliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setTlicencia($value)
    {
        if (in_array($value, array_column(self::TIPOLICENCIA, 0))) {
            $this->tipolicencia = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdcliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idcliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setIdPaquete($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idpaquete = $value;
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
    public function setIdempleado($value)
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
    public function getAnticipo()
    {
        return $this->anticipo;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstado()
    {
        return $this->evaluacion;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getTipolicencia()
    {
        return $this->tipolicencia;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getEstadocliente()
    {
        return $this->estadocliente;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdcliente()
    {
        return $this->idcliente;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdempleado()
    {
        return $this->idempleado;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdpaquete()
    {
        return $this->idpaquete;
    }

    //Método para obtener los valores de los atributos correspondientes
    public function getIdhorario()
    {
        return $this->idhorario;
    }
}
