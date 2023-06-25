<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class TipoPaqueteQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_tipo_paquete, tipo_paquete
        FROM tipo_paquete
        WHERE tipo_paquete ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO tipo_paquete(tipo_paquete)
            VALUES (?)';
        $params = array($this->tipo_paquete);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE tipo_paquete
                SET tipo_paquete=?
                WHERE id_tipo_paquete = ?';
        $params = array($this->tipo_paquete, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM tipo_paquete
        WHERE id_tipo_paquete = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
