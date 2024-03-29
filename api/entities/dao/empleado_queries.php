<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class EmpleadoQueries
{
    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado,empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.asesor, empleado.estado_empleado, sucursal.nombre_sucursal, afp.nombre_afp, rol.rol
        FROM empleado
        INNER JOIN sucursal USING(id_sucursal)
        INNER JOIN afp USING (id_afp)
        INNER JOIN rol USING (id_rol)';
        return Database::getRows($sql);
    }

    public function readRol()
    {
        $sql = 'SELECT * FROM rol';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.estado_empleado, empleado.asesor, sucursal.id_sucursal, sucursal.nombre_sucursal, afp.id_afp,  afp.nombre_afp, rol.id_rol, rol.rol
        FROM empleado
        INNER JOIN sucursal USING(id_sucursal)
        INNER JOIN afp USING (id_afp)
        INNER JOIN rol USING (id_rol)
        where id_empleado=? ';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT empleado.id_empleado, empleado.nombre_com_empleado, empleado.dui_empleado,empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.asesor, empleado.estado_empleado, sucursal.nombre_sucursal, afp.nombre_afp, rol.rol
        FROM empleado
        INNER JOIN sucursal USING(id_sucursal)
        INNER JOIN afp USING (id_afp)
        INNER JOIN rol USING (id_rol)
        WHERE nombre_com_empleado ILIKE ? OR nombre_sucursal ILIKE ?';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO empleado(nombre_com_empleado, dui_empleado, licencia_empleado, telefono_empleado, fecha_nac_empleado, direccion_empleado, correo_empleado, id_afp, asesor, estado_empleado, id_sucursal, id_rol)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->dui, $this->licencia, $this->telefono, $this->fechaN, $this->direccion, $this->correo, $this->AFP, $this->asesor, $this->estado, $this->idsucursal, $this->idrol);
        return Database::executeRow($sql, $params);
    }

    public function createFirstEmpleado()
    {
        $this->idrol = 1;

        $sql = 'INSERT INTO empleado(nombre_com_empleado, dui_empleado, telefono_empleado, fecha_nac_empleado, direccion_empleado, correo_empleado, id_afp, estado_empleado, id_rol, id_sucursal)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->dui, $this->telefono, $this->fechaN, $this->direccion, $this->correo, $this->AFP, $this->estado, $this->idrol, $this->idsucursal);
        return Database::executeRow($sql, $params);
    }


    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow($current_imagen)
    {
        // Se verifica si existe una nueva imagen de licencia para borrar la actual, de lo contrario se mantiene la actual.
        ($this->licencia) ? Validator::deleteFile($this->getRuta(), $current_imagen) : $this->licencia = $current_imagen;
        
        $sql = 'UPDATE empleado
               	SET nombre_com_empleado=?, dui_empleado=?, licencia_empleado=?, telefono_empleado=?, fecha_nac_empleado=?, direccion_empleado=?, correo_empleado=?, estado_empleado=?, asesor=?, id_sucursal=?, id_afp=?, id_rol=?
                WHERE id_empleado = ?';
                $params = array($this->nombre, $this->dui, $this->licencia, $this->telefono, $this->fechaN, $this->direccion, $this->correo, $this->estado,  $this->asesor,  $this->idsucursal, $this->AFP, $this->idrol, $this->id);
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

    // Reporte que filtre empleados que pertenecen por AFP
    public function empleadosPorAfp()
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

    // Reporte que filtre empleados por sucursal
    public function empleadosPorSucu()
    {
        $sql = 'SELECT nombre_com_empleado, nombre_sucursal
        FROM empleado 
        INNER JOIN sucursal USING (id_sucursal)
        WHERE id_sucursal = ?
        group by  nombre_com_empleado, nombre_sucursal
        ORDER BY nombre_com_empleado';
        $params = array($this->idsucursal);
        return Database::getRows($sql, $params);
    }

    // Reporte que filtre empleados por sucursal en especifico
    public function empPorSucuEspecifico()
    {
        $sql = 'SELECT nombre_com_empleado, nombre_sucursal
        FROM empleado 
        INNER JOIN sucursal USING (id_sucursal)
        WHERE id_sucursal = ?
        group by  nombre_com_empleado, nombre_sucursal
        ORDER BY nombre_com_empleado';
        $params = array($this->idsucursal);
        return Database::getRows($sql, $params);
    }

    //Método para realizar una validación en específico
    public function validarAsesorEmpleado()
    {
        $sql = 'SELECT empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.estado_empleado, empleado.asesor, rol.rol, sucursal.nombre_sucursal, afp.nombre_afp
        FROM empleado
        INNER JOIN rol USING(id_rol)
        INNER JOIN sucursal USING(id_sucursal)
        INNER JOIN afp USING(id_afp)
        where asesor = ?
        group by  empleado.nombre_com_empleado, empleado.dui_empleado, empleado.licencia_empleado, empleado.telefono_empleado, empleado.fecha_nac_empleado, empleado.direccion_empleado, empleado.correo_empleado, empleado.estado_empleado, empleado.asesor, rol.rol, sucursal.nombre_sucursal, afp.nombre_afp
        order by nombre_com_empleado';
        $params = array($this->asesor);
        return Database::getRows($sql);
    }
}
