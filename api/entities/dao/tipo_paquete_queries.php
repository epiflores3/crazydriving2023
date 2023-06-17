<?php
require_once('../../helpers/database.php');

class TipoPaqueteQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_tipo_paquete, tipo_paquete
        FROM tipo_paquete
        WHERE tipo_paquete ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_tipo_paquete, tipo_paquete
        FROM tipo_paquete';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_tipo_paquete, tipo_paquete 
        FROM tipo_paquete
        WHERE id_tipo_paquete = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tipo_paquete(tipo_paquete)
            VALUES (?)';
        $params = array($this->tipo_paquete);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow()
    {
        $sql = 'UPDATE tipo_paquete
                SET tipo_paquete=?
                WHERE id_tipo_paquete = ?';
        $params = array($this->tipo_paquete, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tipo_paquete
        WHERE id_tipo_paquete = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}