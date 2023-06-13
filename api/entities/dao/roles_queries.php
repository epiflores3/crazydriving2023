<?php
require_once('../../helpers/database.php');

class RolesQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_rol, rol
        FROM rol
        WHERE rol ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_rol, rol
        FROM rol';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_rol, rol 
        FROM rol
        WHERE id_rol = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO rol(rol)
            VALUES (?)';
        $params = array($this->rol);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow()
    {
        $sql = 'UPDATE rol
                SET rol=?
                WHERE id_rol = ?';
        $params = array($this->rol, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM rol
        WHERE id_rol = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}