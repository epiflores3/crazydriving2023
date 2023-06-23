<?php
require_once('../../helpers/database.php');

class SesionQueries
{

    public function readAll()
    {
        $sql = 'SELECT id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, nombre_com_empleado, placa
        FROM sesion
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN detalle_inscripcion USING(id_detalle_inscripcion)
        INNER JOIN vehiculo USING(id_vehiculo)';
        return Database::getRows($sql);
    }

     public function readOne(){
        $sql='SELECT id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, nombre_com_empleado, id_vehiculo, placa
        FROM sesion 
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN detalle_inscripcion USING(id_detalle_inscripcion)
        INNER JOIN vehiculo USING(id_vehiculo)
        WHERE id_sesion=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones de buscar(search)
    */
    public function searchRows($value)
    {
        $sql = 'SELECT  id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, nombre_com_empleado, id_vehiculo, placa
        FROM sesion
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN detalle_inscripcion USING(id_detalle_inscripcion)
        INNER JOIN vehiculo USING(id_vehiculo)
        WHERE hora_inicio::text ILIKE ? OR  hora_fin::text ILIKE ? OR nombre_com_empleado ILIKE ? OR placa ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO sesion(hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, id_empleado, id_vehiculo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->inicio, $this->fin, $this->asistencia,  $this->tipoclase, $this->estadosesion, $this->iddetalleinscripcion , $this->idempleado , $this->idvehiculo);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow()
    {
        $sql = 'UPDATE sesion
                SET hora_inicio=?, hora_fin=?, asistencia=?, tipo_clase=?, estado_sesion=?, id_detalle_inscripcion=?, id_empleado=?, id_vehiculo
                WHERE id_sesion = ?';
        $params = array($this->inicio, $this->fin, $this->asistencia,  $this->tipoclase, $this->estadosesion, $this->iddetalleinscripcion , $this->idempleado , $this->idvehiculo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM sesion
        WHERE id_sesion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}