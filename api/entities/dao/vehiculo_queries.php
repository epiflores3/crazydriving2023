<?php
require_once('../../helpers/database.php');

class VehiculoQueries
{
     /*
    *   Métodos para realizar las operaciones de buscar(search) de marca
    */
    public function searchRows($value){
        $sql = 'SELECT id_marca, marca
        FROM marca
        WHERE marca ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll(){
        $sql = 'SELECT ve.id_vehiculo, ve.placa, ve.tipo_vehiculo, modelo
        FROM vehiculo ve
        inner join modelo USING (id_modelo)';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql = 'SELECT ve.id_vehiculo, ve.placa, ve.tipo_vehiculo, mo.modelo
        FROM vehiculo ve
        INNER JOIN modelo mo on mo.id_modelo = ve.id_modelo
        WHERE id_vehiculo = ?';
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
        $sql = 'UPDATE marca
                SET marca=?
                WHERE id_marca = ?';
        $params = array($this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM vehiculo
        WHERE id_vehiculo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
} 