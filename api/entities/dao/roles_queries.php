<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class RolesQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_rol, rol, opciones, acciones
        FROM rol
        WHERE rol ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)

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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO rol(rol)
            VALUES (?)';
        $params = array($this->rol);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE rol
                SET rol=?
                WHERE id_rol = ?';
        $params = array($this->rol, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM rol
        WHERE id_rol = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
