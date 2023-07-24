<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class ResponsableQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_responsable_menor, nombre_com_responsable, telefono_responsable, correo_responsable, dui_responsable, parentesco, id_cliente
        FROM responsable_menor
        INNER JOIN cliente USING (id_cliente)
        WHERE nombre_com_responsable ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_responsable_menor, nombre_com_responsable, telefono_responsable, correo_responsable, dui_responsable, parentesco, nombre_com_cliente
        FROM responsable_menor
        INNER JOIN cliente USING (id_cliente)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_responsable_menor, nombre_com_responsable, telefono_responsable, correo_responsable, dui_responsable, parentesco, nombre_com_cliente
        FROM responsable_menor
        INNER JOIN cliente USING (id_cliente)
        WHERE id_responsable_menor = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO responsable_menor(nombre_com_responsable, telefono_responsable, correo_responsable, dui_responsable, parentesco, id_cliente)
            VALUES (?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->dui, $this->parentesco, $this->idcliente);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE responsable_menor
                SET nombre_com_responsable=?, telefono_responsable=?, correo_responsable=?, dui_responsable=?, parentesco=?, id_cliente=?
                WHERE id_responsable_menor = ?';
        $params = array($this->nombre, $this->telefono, $this->correo, $this->dui, $this->parentesco, $this->idcliente, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM responsable_menor
        WHERE id_responsable_menor = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para leer los clientes que existe en la base de datos
    public function readCliente()
    {
        $sql = 'SELECT id_cliente, nombre_com_cliente FROM cliente';
        return Database::getRows($sql);
    }
}
