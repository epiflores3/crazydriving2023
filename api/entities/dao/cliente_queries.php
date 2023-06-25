<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class ClienteQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, nombre_com_cliente, dui_cliente, fecha_nac_cliente, direccion_cliente, correo_cliente, clave_cliente, estado_cliente
        FROM cliente
        WHERE nombre_com_cliente ILIKE ? OR dui_cliente ILIKE ? OR correo_cliente ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_com_cliente, dui_cliente, fecha_nac_cliente, direccion_cliente, correo_cliente, clave_cliente, estado_cliente
        FROM cliente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT * FROM cliente
        WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO cliente(nombre_com_cliente, dui_cliente, fecha_nac_cliente, direccion_cliente, correo_cliente, clave_cliente, estado_cliente)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->dui, $this->fechaN, $this->direccion, $this->correo, $this->clave, $this->estado);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE cliente
                SET nombre_com_cliente = ?, dui_cliente = ?, fecha_nac_cliente = ?, direccion_cliente = ?, correo_cliente = ?, clave_cliente = ?, estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre, $this->dui, $this->fechaN, $this->direccion, $this->correo, $this->clave, $this->estado, $this->id);
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
