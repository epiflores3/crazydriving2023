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

    //Consulta para grafico lineal top 5 fechas con más fechas de inicio, se crean 2 variables de uso, inicial, y final para que funcione
    public function inscripcionesMasFechas($inicial, $final)
    {
        $sql = 'SELECT count(id_inscripcion) as cantidad, fecha_registro from inscripcion
            where fecha_registro between ? and ?
            group by fecha_registro
            order by cantidad desc limit 5';
        $params = array($inicial, $final);
        return Database::getRows($sql, $params);
    }

    //Consulta para grafico lineal top 5 fechas con más fechas de inicio, se crean 2 variables de uso, hora inicial, y hora final para que funcione
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

    //Para hacer grafico de pastel, donde se muestra la cantidad de inscripciones por evaluación.
    public function cantidadEvaluacionInscripcion()
    {
        $sql = 'SELECT inscripcion.evaluacion, ROUND((COUNT(id_inscripcion) * 100.0 / (SELECT COUNT(id_inscripcion) FROM inscripcion)), 2) porcentaje
        FROM inscripcion
        GROUP BY inscripcion.evaluacion ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

    //Para hacer grafico, donde se muestra los paquetes más vendidos.
    public function cantidadPaquetesMasVendidos()
    {
        $sql = 'SELECT paquete.valor_paquete, ROUND((COUNT(id_paquete) * 100.0 / (SELECT COUNT(id_paquete) FROM paquete)), 2) porcentaje
          FROM paquete
          GROUP BY paquete.valor_paquete ORDER BY porcentaje DESC Limit 5';
        return Database::getRows($sql);
    }

    // Filtra todas las inscripciones que le pertenecen a una licencia en específico
    public function inscripcionLicencia()
    {
        $sql = 'SELECT ins.anticipo_paquete, ins.fecha_registro, ins.fecha_inicio, ins.evaluacion, ins.estado_cliente, paq.descripcion, cli.nombre_com_cliente, emp.nombre_com_empleado, hor.inicio, hor.fin
        FROM inscripcion ins
        INNER JOIN paquete paq USING(id_paquete)
		INNER JOIN cliente cli USING(id_cliente)
		INNER JOIN empleado emp USING(id_empleado)
		INNER JOIN horario hor USING(id_horario)
        WHERE tipo_licencia = ? 
		GROUP BY ins.anticipo_paquete, ins.fecha_registro, ins.fecha_inicio, ins.evaluacion, ins.estado_cliente, paq.descripcion, cli.nombre_com_cliente, emp.nombre_com_empleado, hor.inicio, hor.fin
        ORDER BY nombre_com_cliente';
        $params = array($this->tipolicencia);
        return Database::getRows($sql, $params);
    }

    //Para hacer reporte general de inscripciones por estado del cliente
    public function inscripcionEstadoCliente()
    {
        $sql = 'SELECT ins.anticipo_paquete, ins.fecha_registro, ins.fecha_inicio, ins.evaluacion, ins.estado_cliente, paq.descripcion, cli.nombre_com_cliente, emp.nombre_com_empleado, hor.inicio, hor.fin
            FROM inscripcion ins
            INNER JOIN paquete paq USING(id_paquete)
            INNER JOIN cliente cli USING(id_cliente)
            INNER JOIN empleado emp USING(id_empleado)
            INNER JOIN horario hor USING(id_horario)
            WHERE ins.estado_cliente = ?
            GROUP BY ins.anticipo_paquete, ins.fecha_registro, ins.fecha_inicio, ins.evaluacion, ins.estado_cliente, paq.descripcion, cli.nombre_com_cliente, emp.nombre_com_empleado, hor.inicio, hor.fin
            ORDER BY nombre_com_cliente';
        $params = array($this->estadocliente);
        return Database::getRows($sql, $params);
    }
}
