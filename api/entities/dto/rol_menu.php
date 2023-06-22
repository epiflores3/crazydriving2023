<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/rol_menu_queries.php');

class RolMenu extends RolMenuQueries
{
    protected $id = null;
    protected $idmenu = null;
    protected $idrol = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMenu($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idmenu = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setRol($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idrol = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMenu()
    {
        return $this->idmenu;
    }

    public function getRol()
    {
        return $this->idrol;
    }
}
