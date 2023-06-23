<?php
require_once('../../helpers/database.php');

class DetalleInscripcionQueries {

    public function searchRows($value)
    {
        $sql = 'SELECT detalle_inscripcion.id_detalle_inscripcion, detalle_inscripcion.fecha_inicio, detalle_inscripcion.dia, paquete.descripcion, inscripcion.id_inscripcion, empleado.nombre_com_empleado
        FROM detalle_inscripcion
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN paquete USING(id_paquete)
        INNER JOIN inscripcion USING(id_inscripcion)
        WHERE detalle_inscripcion.fecha_inicio::text ILIKE ? OR detalle_inscripcion.dia::text ILIKE ? OR detalle_inscripcion.id_inscripcion::text ILIKE ? OR empleado.nombre_com_empleado ILIKE ?';
        $params = array("%$value%", "%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

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

    public function createRow(){
        $sql = 'INSERT INTO detalle_inscripcion(fecha_inicio, dia, id_paquete, id_inscripcion, id_empleado)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->fechainicio, $this->dia, $this->idpaquete, $this->idinscripcion, $this->idempleado);
        return Database::executeRow($sql, $params);
    }

    public function updateRow(){
        $sql = 'UPDATE detalle_inscripcion
                SET fecha_inicio = ?, dia = ?, id_paquete = ?, id_inscripcion = ?, id_empleado = ?
                WHERE id_detalle_inscripcion = ?';
        $params = array($this->fechainicio, $this->dia, $this->idpaquete, $this->idinscripcion, $this->idempleado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM detalle_inscripcion
        WHERE id_detalle_inscripcion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }


}