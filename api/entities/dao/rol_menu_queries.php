<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class RolesMenuQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_rol_menu, id_rol, opciones, acciones
            FROM rol
            WHERE rol ::text ILIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)

    public function readAll()
    {
        $sql = 'SELECT rol_menu.id_rol_menu, rol.id_rol, rol.rol, rol_menu.opciones, rol_menu.acciones
            FROM rol_menu
            INNER JOIN rol USING (id_rol)
            ORDER BY opciones';
        return Database::getRows($sql);
    }


    public function readOne()
    {
        $sql = 'SELECT rol_menu.id_rol_menu, rol.id_rol, rol.rol, rol_menu.opciones, rol_menu.acciones
            FROM rol_menu
            INNER JOIN rol USING (id_rol)
            WHERE id_rol_menu = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO rol_menu(id_rol,opciones,acciones)
                VALUES (?,?,?)';
        $params = array($this->idrol, $this->opciones, $this->acciones);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE rol_menu
                    SET  id_rol=?, opciones=?, acciones=?
                    WHERE id_rol_menu = ?';
        $params = array($this->idrol,  $this->opciones, $this->acciones, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM rol_menu
            WHERE id_rol_menu = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
