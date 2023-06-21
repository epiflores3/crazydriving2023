<?php
require_once('../../helpers/database.php');

class SesionQueries
{

    // public function readCMB()
    // {
    //     $sql = 'SELECT id_sesion
    //     FROM sesion';
    //     return Database::getRows($sql);
    // }

    public function readAll()
    {
        $sql = 'SELECT id_sesion, id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, dia, nombre_com_empleado, placa
        FROM sesion
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN detalle_inscripcion USING(id_detalle_inscripcion)
        INNER JOIN vehiculo USING(id_vehiculo)';
        return Database::getRows($sql);
    }

     public function readOne(){
        $sql='SELECT id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, dia, nombre_com_empleado, id_vehiculo, placa
        FROM sesion 
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN detalle_inscripcion USING(id_detalle_inscripcion)
        INNER JOIN vehiculo USING(id_vehiculo)
        WHERE id_sesion=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

}