<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class TelefonoQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_telefono, telefono, tipo_telefono, nombre_com_cliente, id_cliente
        FROM telefono
        inner join cliente USING (id_cliente)
        WHERE telefono ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_telefono, telefono, tipo_telefono, nombre_com_cliente
        FROM telefono 
        inner join cliente USING (id_cliente)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_telefono, telefono, tipo_telefono, nombre_com_cliente, id_cliente
        FROM telefono 
        inner join cliente USING (id_cliente)
        WHERE id_telefono = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO telefono(telefono, tipo_telefono, id_cliente)
            VALUES (?, ?, ?)';
        $params = array($this->telefono, $this->tipo_telefono, $this->id_cliente);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE telefono
                SET telefono = ?, tipo_telefono = ?, id_cliente = ?
                WHERE id_telefono = ?';
        $params = array($this->telefono, $this->tipo_telefono, $this->id_cliente, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM telefono
        WHERE id_telefono = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
