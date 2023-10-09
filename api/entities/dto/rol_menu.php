<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/rol_menu_queries.php');

//Clases que se utilizarán para poder manejar los datos de la entidad correspondiente
class RolM extends RolesMenuQueries
{
    //Declarar los atributos de los campos que se encuentran en la tabla correspondiente
    protected $id = null;
    protected $idrol = null;
    protected $opciones = null;
    protected $acciones = null;
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
    public function setRol($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idrol = $value;
            return true;
        } else {
            return false;
        }
    }

     //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
     public function setOpciones($value)
     {
         if (Validator::validateAlphanumeric($value, 1, 50)) {
             $this->opciones = $value;
             return true;
         } else {
             return false;
         }
     }

      //Método para validar dependiendo del dato que se utiliza, asimismo asignarle los valores de los atributos
    public function setAcciones($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->acciones = $value;
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
    public function getRol()
    {
        return $this->idrol;
    }

     //Método para obtener los valores de los atributos correspondientes
     public function getOpciones()
     {
         return $this->opciones;
     }

      //Método para obtener los valores de los atributos correspondientes
    public function getAcciones()
    {
        return $this->acciones;
    }
}
