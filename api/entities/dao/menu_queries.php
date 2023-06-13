<?php
require_once('../../helpers/database.php');

class MenuQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_menu, menu
        FROM menu
        WHERE menu ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_menu, menu
        FROM menu';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_menu, menu 
        FROM menu
        WHERE id_menu = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO menu(menu)
            VALUES (?)';
        $params = array($this->menu);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow()
    {
        $sql = 'UPDATE menu
                SET menu=?
                WHERE id_menu = ?';
        $params = array($this->menu, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM menu
        WHERE id_menu = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}