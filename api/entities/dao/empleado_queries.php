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

}