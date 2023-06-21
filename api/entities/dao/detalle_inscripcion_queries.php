<?php
require_once('../../helpers/database.php');

class DetalleInscripcionQueries {

    public function readAll()
    {
        $sql = 'SELECT detalle_inscripcion.id_detalle_inscripcion, detalle_inscripcion.fecha_inicio, detalle_inscripcion.dia, paquete.descripcion, inscripcion.id_inscripcion, empleado.nombre_com_empleado
	FROM detalle_inscripcion
    INNER JOIN empleado USING(id_empleado)
    INNER JOIN paquete USING(id_paquete)
    INNER JOIN inscripcion USING(id_inscripcion)';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT detalle_inscripcion.id_detalle_inscripcion, detalle_inscripcion.fecha_inicio, detalle_inscripcion.dia, paquete.id_paquete,paquete.descripcion, inscripcion.id_inscripcion, empleado.id_empleado, empleado.nombre_com_empleado
        FROM detalle_inscripcion 
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN paquete USING(id_paquete)
        INNER JOIN inscripcion USING(id_inscripcion)
        WHERE id_detalle_inscripcion=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

}