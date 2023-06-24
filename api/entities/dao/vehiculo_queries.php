<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class VehiculoQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT ve.id_vehiculo, ve.placa, ve.tipo_vehiculo, modelo
        FROM vehiculo ve
        inner join modelo USING (id_modelo)
        WHERE placa ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT ve.id_vehiculo, ve.placa, ve.tipo_vehiculo, modelo
        FROM vehiculo ve
        inner join modelo USING (id_modelo)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT ve.id_vehiculo, ve.placa, ve.tipo_vehiculo, modelo, id_modelo
        FROM vehiculo ve
        inner join modelo USING (id_modelo)
        WHERE id_vehiculo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO vehiculo(placa, tipo_vehiculo, id_modelo)
            VALUES (?, ?, ?)';
        $params = array($this->placa, $this->tipo_vehiculo, $this->id_modelo);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE vehiculo
                SET placa = ?, tipo_vehiculo = ?, id_modelo = ?
                WHERE id_vehiculo = ?';
        $params = array($this->placa, $this->tipo_vehiculo, $this->id_modelo, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM vehiculo
        WHERE id_vehiculo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
