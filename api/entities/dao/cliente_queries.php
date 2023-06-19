<?php
require_once('../../helpers/database.php');

class ClienteQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de vehiculo
    */
    public function searchRows($value){
        $sql = 'SELECT ve.id_vehiculo, ve.placa, ve.tipo_vehiculo, modelo
        FROM vehiculo ve
        inner join modelo USING (id_modelo)
        WHERE placa ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll(){
        $sql = 'SELECT id_cliente, nombre_com_cliente, dui_cliente, fecha_nac_cliente, direccion_cliente, correo_cliente, clave_cliente, estado_cliente
        FROM cliente';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT *FROM cliente
        WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO cliente(nombre_com_cliente, dui_cliente, fecha_nac_cliente, direccion_cliente, correo_cliente, clave_cliente, estado_cliente)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->dui, $this->fechaN, $this->direccion, $this->correo, $this->clave, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE cliente
                SET nombre_com_cliente = ?, dui_cliente = ?, fecha_nac_cliente = ?, direccion_cliente = ?, correo_cliente = ?, clave_cliente = ?, estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre, $this->dui, $this->fechaN, $this->direccion, $this->correo, $this->clave, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM vehiculo
        WHERE id_vehiculo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
} 