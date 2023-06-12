<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/roles_queries.php');

class Roles extends RolesQueries
{
    protected $id = null;
    protected $rol = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setRol($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->rol = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRol()
    {
        return $this->rol;
    }
}
