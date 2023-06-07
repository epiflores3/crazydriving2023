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
        $sql = 'SELECT id_usuario, alias_usuario, clave_usuario, imagen_usuario, fecha_creacion, intento, estado_usuario
        FROM usuario';
        return Database::getRows($sql);
    }

    // public function readOne()
    // {
    //     $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, tipo_usuario, estado_usuario, id_estado_usuario, id_tipo_usuario
    //     FROM usuario
    //     INNER JOIN tipo_usuario USING(id_tipo_usuario)
    //     INNER JOIN estado_usuario USING(id_estado_usuario)
    //     WHERE id_usuario = ?';
    //     $params = array($this->id);
    //     return Database::getRow($sql, $params);
    // }

  
  
}