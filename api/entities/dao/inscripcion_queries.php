<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class InscripcionQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT inscripcion.id_inscripcion, inscripcion.anticipo_paquete, inscripcion.fecha_registro, inscripcion.fecha_inicio, inscripcion.evaluacion, inscripcion.tipo_licencia, inscripcion.estado_cliente, cliente.nombre_com_cliente, empleado.nombre_com_empleado
        FROM inscripcion
        INNER JOIN cliente USING(id_cliente)
        INNER JOIN empleado USING(id_empleado)
        WHERE  inscripcion.evaluacion::text ILIKE ? OR cliente.nombre_com_cliente ILIKE ? OR empleado.nombre_com_empleado ILIKE ? OR inscripcion.tipo_licencia::text ILIKE ? OR inscripcion.fecha_registro::text ILIKE ? OR  inscripcion.fecha_inicio::text ILIKE ? OR inscripcion.estado_cliente::text ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT  inscripcion.id_inscripcion, inscripcion.anticipo_paquete, inscripcion.fecha_registro, inscripcion.fecha_inicio, inscripcion.evaluacion, inscripcion.tipo_licencia, inscripcion.estado_cliente, cliente.nombre_com_cliente, empleado.nombre_com_empleado
	FROM inscripcion
    INNER JOIN cliente USING(id_cliente)
    INNER JOIN empleado USING(id_empleado)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT  inscripcion.id_inscripcion, inscripcion.anticipo_paquete, inscripcion.fecha_registro, inscripcion.fecha_inicio, inscripcion.evaluacion, inscripcion.tipo_licencia, inscripcion.estado_cliente, cliente.nombre_com_cliente, cliente.id_cliente, empleado.nombre_com_empleado, empleado.id_empleado
        FROM inscripcion
        INNER JOIN cliente USING(id_cliente)
        INNER JOIN empleado USING(id_empleado)
        where id_inscripcion=? ';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO inscripcion(anticipo_paquete, fecha_registro, fecha_inicio, evaluacion, tipo_licencia, estado_cliente, id_cliente, id_empleado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->anticipo, $this->fecharegistro, $this->fechainicio, $this->evaluacion,  $this->tipolicencia, $this->estadocliente, $this->idcliente, $this->idempleado);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE inscripcion
                SET anticipo_paquete = ?, fecha_registro = ?, fecha_inicio = ?, evaluacion = ?, tipo_licencia = ?, estado_cliente = ?, id_cliente = ?, id_empleado = ?
                WHERE id_inscripcion = ?';
        $params = array($this->anticipo, $this->fecharegistro, $this->fechainicio, $this->evaluacion,  $this->tipolicencia, $this->estadocliente, $this->idcliente, $this->idempleado, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM inscripcion
        WHERE id_inscripcion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    // //Validar que no se repita
    // public function uniqueCustomerRegistration(){
    //     $sql = 'SELECT *
    //     FROM inscripcion where id_cliente=?';
    //     $params = array($this->idcliente);
    //     return Database::getRow($sql, $params);
    // }

    //Consulta para grafico lineal top 5 fechas con más fechas de inicio, se crean 2 variables de uso, feha inicio, y fecha final para que funcione
    public function cantidadFechasInicio($fecha_inicial, $fecha_final)
    {
        $sql = 'SELECT count(id_inscripcion) as cantidad, fecha_inicio from inscripcion
            where fecha_inicio between ? and ?
            group by fecha_inicio
            order by cantidad desc limit 5';
        $params = array($fecha_inicial, $fecha_final);
        return Database::getRows($sql, $params);
    }


    public function cantidadHorariosMasSolicitados($hora_inicial, $hora_final)
    {
        $sql = 'SELECT count(id_inscripcion) as cantidad, inicio from inscripcion
        INNER JOIN horario USING(id_horario)
        where inicio between ? and ?
        group by inicio
        order by cantidad desc limit 5';
        $params = array($hora_inicial, $hora_final);
        return Database::getRows($sql, $params);
    }

    
}
