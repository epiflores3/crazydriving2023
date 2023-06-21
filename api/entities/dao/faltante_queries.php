<?php
require_once('../../helpers/database.php');

class FaltanteQueries{

    public function readAll()
    {
        $sql = 'SELECT id_faltante, cantidad_minuto, id_sesion
	FROM faltante';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT a.id_faltante, a.cantidad_minuto, x.id_sesion, d.dui_cliente
        FROM faltante a
        Inner Join sesion x USING (id_sesion)
        Inner Join detalle_inscripcion b USING (id_detalle_inscripcion) 
        INNER JOIN inscripcion c USING (id_inscripcion) 
        INNER JOIN  cliente d USING (id_cliente)
        WHERE id_faltante=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    protected $dui;

    public function searchModal($value)
    {
        $sql = 'SELECT a.id_sesion, d.dui_cliente 
        from sesion a 
        Inner Join detalle_inscripcion b USING (id_detalle_inscripcion) 
        INNER JOIN inscripcion c USING (id_inscripcion) 
        INNER JOIN  cliente d USING (id_cliente)
        where d.dui_cliente ILIKE ?';
        $params = array("$value");
        return  Database::getRow($sql, $params);
        
        
    }


    public function cargarSesion()
    {
        $sql = 'SELECT a.id_sesion
        from sesion a 
        Inner Join detalle_inscripcion b USING (id_detalle_inscripcion) 
        INNER JOIN inscripcion c USING (id_inscripcion)
        INNER JOIN  cliente d USING (id_cliente)
        where d.dui_cliente ILIKE ?';
        $params = array($this->duicliente);
        // print_r($params);
        return Database::getRows($sql, $params);
    }

    
// select a.id_sesion from sesion a Inner Join detalle_inscripcion b USING (id_detalle_inscripcion) 
// INNER JOIN inscripcion c USING (id_inscripcion) INNER JOIN  cliente d USING (id_cliente)
// where d.dui_cliente='53824577-0'


    public function createRow()
    {
        $sql = 'INSERT INTO faltante(cantidad_minuto, id_sesion)
            VALUES (?,?)';
        $params = array($this->cantidadminuto, $this->idsesion);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE faltante
                SET cantidad_minuto =?, id_sesion =?
                WHERE id_faltante = ?';
        $params = array($this->cantidadminuto, $this->idsesion,  $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM faltante
                WHERE id_faltante = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}