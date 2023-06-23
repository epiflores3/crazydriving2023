<?php
require_once('../../helpers/database.php');

class HorarioInscripcionQueries{

    public function searchRows($value)
    {
        $sql = 'SELECT id_horario_inscripcion, id_detalle_inscripcion, id_horario
        FROM horario_inscripcion
        WHERE id_detalle_inscripcion::text ILIKE ? OR id_horario::text ILIKE ?';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_horario_inscripcion, id_detalle_inscripcion, id_horario
	FROM horario_inscripcion';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT id_horario_inscripcion, id_detalle_inscripcion, id_horario
        FROM horario_inscripcion 
        WHERE id_horario_inscripcion=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO horario_inscripcion(id_detalle_inscripcion, id_horario)
            VALUES (?,?)';
        $params = array($this->iddetalleinscripcion, $this->idhorario);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE horario_inscripcion
        SET id_detalle_inscripcion = ?, id_horario = ?
        where id_horario_inscripcion=?';
        $params = array($this->iddetalleinscripcion, $this->idhorario, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql='DELETE FROM horario_inscripcion 
              WHERE id_horario_inscripcion = ?';
        $params=array($this->id);
        return Database:: executeRow($sql, $params);
    } 

    public function searchModalDetalle($value)
    {
        $sql = 'SELECT a.id_detalle_inscripcion, d.dui_cliente 
        from detalle_inscripcion a 
        INNER JOIN inscripcion c USING (id_inscripcion) 
        INNER JOIN  cliente d USING (id_cliente)
        where d.dui_cliente ILIKE ?';
        $params = array("$value");
        return  Database::getRow($sql, $params);
    }

    public function cargarDetalleSesion()
    {
        $sql = 'SELECT a.id_detalle_inscripcion
        from detalle_inscripcion a  
        INNER JOIN inscripcion c USING (id_inscripcion)
        INNER JOIN  cliente d USING (id_cliente)
        where d.dui_cliente ILIKE ?';
        $params = array($this->duicliente);
        //  print_r($params);
        return Database::getRows($sql, $params);
    }


}