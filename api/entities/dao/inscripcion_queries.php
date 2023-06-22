<?php
require_once('../../helpers/database.php');

class InscripcionQueries {

    public function readAll()
    {
        $sql = 'SELECT  inscripcion.id_inscripcion, inscripcion.anticipo_paquete, inscripcion.fecha_registro, inscripcion.fecha_inicio, inscripcion.evaluacion, inscripcion.tipo_licencia, inscripcion.estado_cliente, cliente.nombre_com_cliente, empleado.nombre_com_empleado
	FROM inscripcion
    INNER JOIN cliente USING(id_cliente)
    INNER JOIN empleado USING(id_empleado)';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT  inscripcion.id_inscripcion, inscripcion.anticipo_paquete, inscripcion.fecha_registro, inscripcion.fecha_inicio, inscripcion.evaluacion, inscripcion.tipo_licencia, inscripcion.estado_cliente, cliente.nombre_com_cliente, cliente.id_cliente, empleado.nombre_com_empleado, empleado.id_empleado
        FROM inscripcion
        INNER JOIN cliente USING(id_cliente)
        INNER JOIN empleado USING(id_empleado)
        where id_inscripcion=? ';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow(){
        $sql = 'INSERT INTO inscripcion(anticipo_paquete, fecha_registro, fecha_inicio, evaluacion, tipo_licencia, estado_cliente, id_cliente, id_empleado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->anticipo, $this->fecharegistro, $this->fechainicio, $this->evaluacion,  $this->tipolicencia, $this->estadocliente, $this->idcliente, $this->idempleado);
        return Database::executeRow($sql, $params);
    }

    public function updateRow(){
        $sql = 'UPDATE inscripcion
                SET anticipo_paquete = ?, fecha_registro = ?, fecha_inicio = ?, evaluacion = ?, tipo_licencia = ?, estado_cliente = ?, id_cliente = ?, id_empleado = ?
                WHERE id_inscripcion = ?';
        $params = array($this->anticipo, $this->fecharegistro, $this->fechainicio, $this->evaluacion,  $this->tipolicencia, $this->estadocliente, $this->idcliente, $this->idempleado, $this->id);
        return Database::executeRow($sql, $params);
    }


    public function deleteRow(){
        $sql = 'DELETE FROM inscripcion
        WHERE id_inscripcion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }


}