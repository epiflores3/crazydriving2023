<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class HorarioQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_horario, inicio, fin
        FROM horario
        WHERE inicio::text ILIKE ?  OR  fin::text ILIKE ?';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_horario, inicio, fin
	FROM horario';
        return Database::getRows($sql);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO horario(inicio, fin)
            VALUES (?,?)';
        $params = array($this->inicio, $this->fin);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE horario
        SET inicio = ?, fin = ?
        where id_horario=?';
        $params = array($this->inicio, $this->fin, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_horario, inicio, fin
        FROM horario 
        WHERE id_horario=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM horario 
              WHERE id_horario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
