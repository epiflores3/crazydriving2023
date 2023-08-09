<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class EmpleadoQueries
{

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT  empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.estado_empleado, rol.rol, sucursal.nombre_sucursal, afp.nombre_afp
	FROM empleado
    INNER JOIN rol USING(id_rol)
    INNER JOIN sucursal USING(id_sucursal)
    INNER JOIN afp USING(id_afp)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT  empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.nombre_afp, empleado.estado_empleado, rol.rol, rol.id_rol, sucursal.nombre_sucursal, sucursal.id_sucursal
        FROM empleado
        INNER JOIN rol USING(id_rol)
        INNER JOIN sucursal USING(id_sucursal)
        where id_empleado=? ';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento buscar(search)
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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO empleado(nombre_com_empleado, dui_empleado, licencia_empleado, telefono_empleado, fecha_nac_empleado, direccion_empleado, correo_empleado, nombre_afp, estado_empleado, id_rol, id_sucursal)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->dui, $this->licencia, $this->telefono, $this->fechaN, $this->direccion, $this->correo, $this->AFP, $this->estado, $this->idrol, $this->idsucursal);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
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

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM empleado
                WHERE id_empleado = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function EmpleadosPorAfp()
    {
        $sql = 'SELECT nombre_com_empleado, dui_empleado, nombre_sucursal
        FROM empleado 
        INNER JOIN afp USING (id_afp)
         INNER JOIN sucursal USING (id_sucursal)
        WHERE id_afp = ?
        group by  nombre_com_empleado, dui_empleado, nombre_sucursal
         ORDER BY nombre_com_empleado';
        $params = array($this->AFP);
        return Database::getRows($sql, $params);
    }
}
