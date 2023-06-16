<?php
require_once('../../helpers/database.php');

class SucursalQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_sucursal, nombre_sucursal, direccion_sucursal
        FROM sucursal
        WHERE sucursal ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_sucursal, nombre_sucursal, direccion_sucursal
        FROM sucursal'; 
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_sucursal, nombre_sucursal, direccion_sucursal 
        FROM sucursal
        WHERE id_sucursal = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO sucursal(nombre_sucursal, direccion_sucursal)
            VALUES (?, ?)';
        $params = array($this->nombre_sucursal,  $this->direccion_sucursal);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow()
    {
        $sql = 'UPDATE sucursal
                SET nombre_sucursal=?, direccion_sucursal=?
                WHERE id_sucursal = ?';
        $params = array($this->nombre_sucursal,  $this->direccion_sucursal, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM sucursal
        WHERE id_sucursal = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}