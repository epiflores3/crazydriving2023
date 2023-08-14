<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class SesionQueries
{
    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, nombre_com_empleado, placa
        FROM sesion
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN vehiculo USING(id_vehiculo)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_sesion, hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, nombre_com_empleado, id_vehiculo, placa
        FROM sesion 
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN detalle_inscripcion USING(id_detalle_inscripcion)
        INNER JOIN vehiculo USING(id_vehiculo)
        WHERE id_sesion=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento buscar(search)
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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO sesion(hora_inicio, hora_fin, asistencia, tipo_clase, estado_sesion, id_detalle_inscripcion, id_empleado, id_vehiculo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->inicio, $this->fin, $this->asistencia,  $this->tipoclase, $this->estadosesion, $this->iddetalleinscripcion, $this->idempleado, $this->idvehiculo);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE sesion
                SET hora_inicio=?, hora_fin=?, asistencia=?, tipo_clase=?, estado_sesion=?, id_detalle_inscripcion=?, id_empleado=?, id_vehiculo
                WHERE id_sesion = ?';
        $params = array($this->inicio, $this->fin, $this->asistencia,  $this->tipoclase, $this->estadosesion, $this->iddetalleinscripcion, $this->idempleado, $this->idvehiculo, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM sesion
        WHERE id_sesion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el reporte parametrizado de sesiones por un tipo de clase
    public function sesiontipoclase()
    {
        $sql = 'SELECT ses.id_sesion, ses.fecha_sesion, ses.hora_inicio, ses.hora_fin, emp.nombre_com_empleado
        FROM sesion ses
		INNER JOIN empleado emp USING(id_empleado)
        WHERE tipo_clase = ? 
		GROUP BY ses.id_sesion, ses.fecha_sesion, ses.hora_inicio, ses.hora_fin, emp.nombre_com_empleado
        ORDER BY nombre_com_empleado';
        $params = array($this->tipoclase);
        return Database::getRows($sql, $params);
    }
}
