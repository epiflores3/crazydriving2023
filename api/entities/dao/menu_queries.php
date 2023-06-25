<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class MenuQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_menu, menu
        FROM menu
        WHERE menu ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO menu(menu)
            VALUES (?)';
        $params = array($this->menu);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE menu
                SET menu=?
                WHERE id_menu = ?';
        $params = array($this->menu, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM menu
        WHERE id_menu = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
