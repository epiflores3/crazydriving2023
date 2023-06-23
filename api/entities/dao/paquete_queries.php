<?php
require_once('../../helpers/database.php');

class PaqueteQueries{


    public function searchRows($value)
    {
        $sql = 'SELECT id_paquete, descripcion, valor_paquete, cantidad_clase, transmision, tipo_paquete
        FROM paquete
        INNER JOIN tipo_paquete USING(id_tipo_paquete)
        WHERE cantidad_clase::text ILIKE ? OR valor_paquete::text ILIKE ? OR transmision::text ILIKE ? OR tipo_paquete ILIKE ?';
        $params = array("%$value%", "%$value%","%$value%","%$value%");
        return Database::getRows($sql, $params);
    }

  
    public function readAll()
    {
        $sql = 'SELECT id_paquete, descripcion, valor_paquete, cantidad_clase, transmision, tipo_paquete
        FROM paquete
        INNER JOIN tipo_paquete USING(id_tipo_paquete)';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql = 'SELECT id_paquete, descripcion, valor_paquete, cantidad_clase, transmision, id_tipo_paquete, tipo_paquete
        FROM paquete
        INNER JOIN tipo_paquete USING(id_tipo_paquete)
        WHERE id_paquete = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow(){
        $sql = 'INSERT INTO paquete(descripcion, valor_paquete, cantidad_clase, transmision, id_tipo_paquete)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->descripp, $this->valorpaquete, $this->cantidadclase, $this->transmision, $this->idtipopaquete);
        return Database::executeRow($sql, $params);
    }

    public function updateRow(){
        $sql = 'UPDATE paquete
                SET descripcion = ?, valor_paquete = ?, cantidad_clase = ?, transmision = ?, id_tipo_paquete = ?
                WHERE id_paquete = ?';
        $params = array($this->descripp, $this->valorpaquete, $this->cantidadclase, $this->transmision, $this->idtipopaquete, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM paquete
        WHERE id_paquete = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}