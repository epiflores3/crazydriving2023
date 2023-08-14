<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class ModeloQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_modelo, modelo, tipo_vehiculo, marca
        FROM modelo
        INNER JOIN marca USING(id_marca)
        WHERE modelo ILIKE ? OR marca ILIKE ?';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_modelo, modelo, tipo_vehiculo, marca
        FROM modelo
        INNER JOIN marca USING(id_marca)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_modelo, modelo, tipo_vehiculo, marca, id_marca
        FROM modelo
        INNER JOIN marca USING(id_marca)
        WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO modelo(modelo, tipo_vehiculo, id_marca)
            VALUES (?, ?, ?)';
        $params = array($this->modelo, $this->tipo_vehiculo, $this->marca);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE modelo
                SET modelo=?, tipo_vehiculo=?, id_marca=?
                WHERE id_modelo = ?';
        $params = array($this->modelo, $this->tipo_vehiculo, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM modelo
        WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

     //Método para realizar el reporte parametrizado de vehiculos por modelos
     public function vehiculosmodelos()
     {
         $sql = 'SELECT ve.id_vehiculo, mo.modelo, ve.placa
         FROM vehiculo ve
         INNER JOIN modelo mo USING(id_modelo)
         WHERE tipo_vehiculo = ? 
         GROUP BY ve.id_vehiculo, mo.modelo, ve.placa
         ORDER BY mo.modelo';
         $params = array($this->tipo_vehiculo);
         return Database::getRows($sql, $params);
     }
}
