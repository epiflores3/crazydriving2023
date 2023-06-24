<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class SucursalQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_sucursal, nombre_sucursal, direccion_sucursal
        FROM sucursal
        WHERE sucursal ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO sucursal(nombre_sucursal, direccion_sucursal)
            VALUES (?, ?)';
        $params = array($this->nombre_sucursal,  $this->direccion_sucursal);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE sucursal
                SET nombre_sucursal=?, direccion_sucursal=?
                WHERE id_sucursal = ?';
        $params = array($this->nombre_sucursal,  $this->direccion_sucursal, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM sucursal
        WHERE id_sucursal = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
