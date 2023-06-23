<?php
require_once('../../helpers/database.php');

class RolMenuQueries{

    public function readAll()
    {
        $sql = 'SELECT id_rol_menu, rol, menu
        FROM rol_menu
        INNER JOIN rol USING(id_rol)
        INNER JOIN menu USING(id_menu)';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql = 'SELECT id_rol_menu, id_rol, rol, id_menu, menu
        FROM rol_menu
        INNER JOIN rol USING(id_rol)
        INNER JOIN menu USING(id_menu)
        WHERE id_rol_menu = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function createRow(){
        $sql = 'INSERT INTO rol_menu(id_rol, id_menu)
            VALUES (?, ?)';
        $params = array($this->idrol, $this->idmenu);
        return Database::executeRow($sql, $params);
    }

    public function updateRow(){
        $sql = 'UPDATE rol_menu
                SET id_rol = ?, id_menu = ?
                WHERE id_rol_menu = ?';
        $params = array($this->idrol, $this->idmenu, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM rol_menu
        WHERE id_rol_menu = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}