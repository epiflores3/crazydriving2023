<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class AfpQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_afp, nombre_afp
        FROM afp
        WHERE nombre_afp ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_afp, nombre_afp
        FROM afp';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_afp, nombre_afp 
        FROM afp
        WHERE id_afp = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO afp(nombre_afp)
            VALUES (?)';
        $params = array($this->afp);
        return Database::executeRow($sql, $params);
    }

    // //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE afp
                SET nombre_afp=?
                WHERE id_afp = ?';
        $params = array($this->afp, $this->id);
        return Database::executeRow($sql, $params);
    }

    // //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM afp
        WHERE id_afp = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
