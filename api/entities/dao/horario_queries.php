<?php
require_once('../../helpers/database.php');

class HorarioQueries{

    public function readAll()
    {
        $sql = 'SELECT id_horario, inicio, fin
	FROM horario';
        return Database::getRows($sql);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO horario(inicio, fin)
            VALUES (?,?)';
        $params = array($this->inicio, $this->fin);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE horario
        SET inicio = ?, fin = ?
        where id_horario=?';
        $params = array($this->inicio, $this->fin, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function readOne(){
        $sql='SELECT id_horario, inicio, fin
        FROM horario 
        WHERE id_horario=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function deleteRow(){
        $sql='DELETE FROM horario 
              WHERE id_horario = ?';
        $params=array($this->id);
        return Database:: executeRow($sql, $params);
    } 
}