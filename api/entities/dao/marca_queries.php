<?php
require_once('../../helpers/database.php');

class MarcaQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_marca, marca
        FROM marca
        WHERE marca ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_marca, marca
        FROM marca';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_marca, marca 
        FROM marca
        WHERE id_marca = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO marca(marca)
            VALUES (?)';
        $params = array($this->marca);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow()
    {
        $sql = 'UPDATE marca
                SET marca=?
                WHERE id_marca = ?';
        $params = array($this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM marca
        WHERE id_marca = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}