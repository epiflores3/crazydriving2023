<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class UsuarioQueries
{
    //Método para comprobar el usuario
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


     //Método para comprobar el usuario
     public function checkMail($correo)
     {
         $sql = 'SELECT id_usuario FROM usuario WHERE correo_usuario = ?';
         $params = array($correo);
         if ($data = Database::getRow($sql, $params)) {
             $this->id = $data['id_usuario'];
             $this->correo = $correo;
             return true;
         } else {
             return false;
         }
     }

    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = "SELECT id_usuario, correo_usuario, alias_usuario, clave_usuario, imagen_usuario, fecha_creacion, intento, estado_usuario, id_empleado
        FROM usuario
            WHERE correo_usuario   ILIKE ? OR alias_usuario ILIKE ?";
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function checkEstado($alias)
    {
        //Consulta de datos para verificar si existe un usuario con el alias
        $sql = 'SELECT id_usuario, estado_usuario, EXTRACT(days FROM (CURRENT_TIMESTAMP - fecha_bloqueo)) AS dias_bloqueo
                FROM usuario WHERE alias_usuario = ?';
        //Valor que se envía al parámetro
        $params = array($alias);
        //Si encuentra datos ingresa a la estructura
        if ($data = Database::getRow($sql, $params)) {
            // Captura la información del usuario *************
            $this->id = $data['id_usuario'];
            // Se revisa el estado del usuario
            if ($data['estado_usuario'] == "Bloqueado") {
                // Verifica si el tiempo de diferencia en mayor o igual al 24hrs
                if($data['dias_bloqueo'] > 0){
                    // Se actualiza el usuario a estado Activo
                    $sql = "UPDATE usuario SET intento = 0, estado_usuario = 'Activo', fecha_bloqueo = NULL WHERE id_usuario = ?";
                    $params = array($this->id);
                    return Database::executeRow($sql, $params);
                }else{
                    return false;
                }
            } else {
                return true;
            }            
        } else {
            return false;
        }

    }

    //Método para comprobar la contraseña del usuario
    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario, intento, estado_usuario FROM usuario WHERE id_usuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);

        if (password_verify($password, $data['clave_usuario']) ) {
            // Reiniciar el contador de intentos fallidos a 0
            $sql = 'UPDATE usuario SET intento = 0 WHERE id_usuario = ?';
            Database::executeRow($sql, $params);
            return true;
        } else {
            // Verificar y actualizar el contador de intentos fallidos toma el número entero y le suma 1
            $intentosFallidos = intval($data['intento']) + 1;

            if ($intentosFallidos >= 5) {
                $sql = "UPDATE usuario SET intento = 0, estado_usuario = 'Bloqueado',  fecha_bloqueo = CURRENT_TIMESTAMP WHERE id_usuario = ?";
                Database::executeRow($sql, $params);
            } else {
                // Si no se ha alcanzado el límite, simplemente actualizamos el contador de intentos fallidos.
                $sql = 'UPDATE usuario SET intento = ? WHERE id_usuario = ?';
                $params = array($intentosFallidos, $this->id);
                Database::executeRow($sql, $params);
            }
            return false;
        }
    }

    //Método para realizar el mantenimiento read(leer)
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

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO usuario(correo_usuario, alias_usuario, clave_usuario, imagen_usuario, fecha_creacion, intento, estado_usuario, id_empleado )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->correo, $this->alias, $this->clave, $this->imagen_usuario, $this->fechacreacion, $this->intentos, $this->estadousu, $this->idempleado);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
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

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para comprobar que existen empleados en la base de datos
    public function readEmpleado()
    {
        $sql = 'SELECT id_empleado, nombre_com_empleado FROM empleado';
        return Database::getRows($sql);
    }

    //Para cambiar la clave
    public function changePassword()
    {
        $sql = 'UPDATE usuario
                SET clave_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->clave, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    //Para leer el usuario que inicio sesion
    public function readProfile()
    {
        $sql = 'SELECT usuario.id_usuario, usuario.correo_usuario, usuario.alias_usuario, usuario.clave_usuario, usuario.fecha_creacion, usuario.id_empleado
        FROM usuario
        INNER JOIN empleado USING(id_empleado)
        WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    //Para editar el perfil del usuario
    public function editProfile()
    {
        $sql = 'UPDATE usuario
                SET correo_usuario = ?, alias_usuario = ?, fecha_creacion = ?, id_empleado = ?
                WHERE id_usuario = ?';
        $params = array($this->correo, $this->alias, $this->fechacreacion, $this->idempleado,  $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }
}
