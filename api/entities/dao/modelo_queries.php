<?php
require_once('../../helpers/database.php');

class ModeloQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_modelo, modelo, marca
        FROM modelo
        INNER JOIN marca USING(id_marca)
        WHERE modelo ILIKE ? OR marca ILIKE ?';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_modelo, modelo, marca
        FROM modelo
        INNER JOIN marca USING(id_marca)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_modelo, modelo, marca, id_marca
        FROM modelo
        INNER JOIN marca USING(id_marca)
        WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO modelo(modelo, id_marca)
            VALUES (?, ?)';
        $params = array($this->modelo, $this->marca);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow()
    {
        $sql = 'UPDATE modelo
                SET modelo=?, id_marca=?
                WHERE id_modelo = ?';
        $params = array($this->modelo, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM modelo
        WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}