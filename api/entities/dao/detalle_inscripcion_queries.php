<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class DetalleInscripcionQueries
{

    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT detalle_inscripcion.id_detalle_inscripcion, detalle_inscripcion.fecha_inicio, detalle_inscripcion.dia, paquete.descripcion, inscripcion.id_inscripcion, empleado.nombre_com_empleado
        FROM detalle_inscripcion
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN paquete USING(id_paquete)
        INNER JOIN inscripcion USING(id_inscripcion)
        WHERE detalle_inscripcion.fecha_inicio::text ILIKE ? OR detalle_inscripcion.dia::text ILIKE ? OR detalle_inscripcion.id_inscripcion::text ILIKE ? OR empleado.nombre_com_empleado ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT detalle_inscripcion.id_detalle_inscripcion, detalle_inscripcion.fecha_inicio, detalle_inscripcion.dia, paquete.descripcion, inscripcion.id_inscripcion, empleado.nombre_com_empleado
	FROM detalle_inscripcion
    INNER JOIN empleado USING(id_empleado)
    INNER JOIN paquete USING(id_paquete)
    INNER JOIN inscripcion USING(id_inscripcion)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT detalle_inscripcion.id_detalle_inscripcion, detalle_inscripcion.fecha_inicio, detalle_inscripcion.dia, paquete.id_paquete,paquete.descripcion, inscripcion.id_inscripcion, empleado.id_empleado, empleado.nombre_com_empleado
        FROM detalle_inscripcion 
        INNER JOIN empleado USING(id_empleado)
        INNER JOIN paquete USING(id_paquete)
        INNER JOIN inscripcion USING(id_inscripcion)
        WHERE id_detalle_inscripcion=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO detalle_inscripcion(fecha_inicio, dia, id_paquete, id_inscripcion, id_empleado)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->fechainicio, $this->dia, $this->idpaquete, $this->idinscripcion, $this->idempleado);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE detalle_inscripcion
                SET fecha_inicio = ?, dia = ?, id_paquete = ?, id_inscripcion = ?, id_empleado = ?
                WHERE id_detalle_inscripcion = ?';
        $params = array($this->fechainicio, $this->dia, $this->idpaquete, $this->idinscripcion, $this->idempleado, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM detalle_inscripcion
        WHERE id_detalle_inscripcion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function BuscarInscripcion($value){
        $sql=
        "SELECT a.id_inscripcion, d.dui_cliente 
        from inscripcion a 
        INNER JOIN  cliente d USING (id_cliente)
        where d.dui_cliente = ? and a.estado_cliente = 'Pendiente'";
        $params = array("$value");
        return  Database::getRow($sql, $params);
    }
}
