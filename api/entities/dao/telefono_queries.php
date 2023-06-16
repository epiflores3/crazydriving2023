<?php
require_once('../../helpers/database.php');

class TelefonoQueries
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
        $sql = 'SELECT id_telefono, telefono, tipo_telefono, nombre_com_cliente
        FROM telefono 
        inner join cliente USING (id_cliente)';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql = 'SELECT id_telefono, telefono, tipo_telefono, nombre_com_cliente, id_cliente
        FROM telefono 
        inner join cliente USING (id_cliente)
        WHERE telefono = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow(){
        $sql = 'INSERT INTO vehiculo(placa, tipo_vehiculo, id_modelo)
            VALUES (?, ?, ?)';
        $params = array($this->placa, $this->tipo_vehiculo, $this->id_modelo);
        return Database::executeRow($sql, $params);
    }
   
    public function updateRow(){
        $sql = 'UPDATE vehiculo
                SET placa = ?, tipo_vehiculo = ?, id_modelo = ?
                WHERE id_vehiculo = ?';
        $params = array($this->placa, $this->tipo_vehiculo, $this->id_modelo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM vehiculo
        WHERE id_vehiculo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
} 