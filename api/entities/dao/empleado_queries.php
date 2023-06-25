<?php
require_once('../../helpers/database.php');

class EmpleadoQueries {

    public function readAll()
    {    
    $sql = 'SELECT  empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.nombre_afp, empleado.estado_empleado, rol.rol, sucursal.nombre_sucursal
	FROM empleado
    INNER JOIN rol USING(id_rol)
    INNER JOIN sucursal USING(id_sucursal)';
    return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT  empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.nombre_afp, empleado.estado_empleado, rol.rol, rol.id_rol, sucursal.nombre_sucursal, sucursal.id_sucursal
        FROM empleado
        INNER JOIN rol USING(id_rol)
        INNER JOIN sucursal USING(id_sucursal)
        where id_empleado=? ';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

     /*
    *   Métodos para realizar las operaciones de buscar(search) de pedido
    */
    public function searchRows($value)
    {
        $sql = 'SELECT  empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.nombre_afp, empleado.estado_empleado, rol.rol, rol.id_rol, sucursal.nombre_sucursal, sucursal.id_sucursal
        FROM empleado
        INNER JOIN rol USING(id_rol)
        INNER JOIN sucursal USING(id_sucursal)
        WHERE nombre_com_empleado ILIKE ? OR nombre_sucursal ILIKE ?';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO empleado(nombre_com_empleado, dui_empleado, licencia_empleado, telefono_empleado, fecha_nac_empleado, direccion_empleado, correo_empleado, nombre_afp, estado_empleado, id_rol, id_sucursal)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->dui, $this->licencia, $this->telefono, $this->fechaN, $this->direccion, $this->correo, $this->AFP, $this->estado, $this->idrol, $this->idsucursal );
        return Database::executeRow($sql, $params);
    }

    public function updateRow($current_imagen)
    {
        // Se verifica si existe una nueva imagen de licencia para borrar la actual, de lo contrario se mantiene la actual.
        ($this->licencia) ? Validator::deleteFile($this->getRuta(), $current_imagen) : $this->licencia = $current_imagen;
        $sql = 'UPDATE empleado
                SET nombre_com_empleado = ?, dui_empleado = ?, licencia_empleado = ?, telefono_empleado = ?, fecha_nac_empleado = ?, direccion_empleado = ?, correo_empleado = ?, nombre_afp = ?, estado_empleado = ?, id_rol = ?, id_sucursal = ?
                WHERE id_empleado = ?';
        $params = array($this->nombre, $this->dui, $this->licencia, $this->telefono, $this->fechaN, $this->direccion, $this->correo, $this->AFP, $this->estado, $this->idrol, $this->idsucursal, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM empleado
                WHERE id_empleado = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}