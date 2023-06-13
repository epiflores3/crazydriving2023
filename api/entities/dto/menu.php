<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/menu_queries.php');

class Menu extends MenuQueries
{
    protected $id = null;
    protected $menu = null;

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
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->menu = $value;
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
        return $this->menu;
    }
}
