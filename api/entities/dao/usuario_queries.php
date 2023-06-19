<?php
require_once('../../helpers/database.php');

class UsuarioQueries
{

    public function checkUser($alias)
    {
        $sql = 'SELECT id_usuario FROM usuario WHERE alias_usuario = ?';
        $params = array($alias);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->alias = $alias;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuario WHERE id_usuario = ?';
        $params = array($this->id);
        $data= Database::getRow($sql,$params);
        if ($password==$data['clave_usuario']) {
        return true;
            }else{
        return false;
        }
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, correo_usuario, alias_usuario, clave_usuario, imagen_usuario, fecha_creacion, intento, estado_usuario, id_empleado
        FROM usuario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, correo_usuario, alias_usuario, clave_usuario, imagen_usuario, fecha_creacion, intento, estado_usuario, id_empleado
                FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuario(correo_usuario, alias_usuario, clave_usuario, imagen_usuario, fecha_creacion, intento, estado_usuario, id_empleado )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->correo, $this->alias, $this->clave, $this->imagen_usuario, $this->fechacreacion, $this->intentos, $this->estadousu, $this->idempleado);
        return Database::executeRow($sql, $params);
    }

    public function updateRow($current_imagen)
    {
        // Se verifica si existe una nueva imagen_usuario para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen_usuario) ? Validator::deleteFile($this->getRuta(), $current_imagen) : $this->imagen_usuario = $current_imagen;
        $sql = 'UPDATE usuario
                SET  correo_usuario = ?, alias_usuario = ?,  clave_usuario = ?,  imagen_usuario = ?,  fecha_creacion = ?, intento = ?,  estado_usuario = ?,  id_empleado = ?
                WHERE id_usuario = ?';
        $params = array($this->correo, $this->alias, $this->clave, $this->imagen_usuario, $this->fechacreacion, $this->intentos, $this->estadousu, $this->idempleado, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readEmpleado()
    {
        $sql = 'SELECT id_empleado, nombre_com_empleado FROM empleado';
        return Database::getRows($sql);
    }
  
}