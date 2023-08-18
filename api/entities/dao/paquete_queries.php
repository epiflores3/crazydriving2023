<?php
require_once('../../helpers/database.php');

//Clase para poder tener acceso a todos de la entidad requerida
class PaqueteQueries
{
    //Método para realizar el mantenimiento buscar(search)
    public function searchRows($value)
    {
        $sql = 'SELECT id_paquete, descripcion, valor_paquete, cantidad_clase, transmision, tipo_paquete
        FROM paquete
        INNER JOIN tipo_paquete USING(id_tipo_paquete)
        WHERE cantidad_clase::text ILIKE ? OR valor_paquete::text ILIKE ? OR transmision::text ILIKE ? OR tipo_paquete ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para realizar el mantenimiento read(leer)
    public function readAll()
    {
        $sql = 'SELECT id_paquete, descripcion, valor_paquete, cantidad_clase, transmision, tipo_paquete
        FROM paquete
        INNER JOIN tipo_paquete USING(id_tipo_paquete)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_paquete, descripcion, valor_paquete, cantidad_clase, transmision, id_tipo_paquete, tipo_paquete
        FROM paquete
        INNER JOIN tipo_paquete USING(id_tipo_paquete)
        WHERE id_paquete = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar el mantenimiento crear(create)
    public function createRow()
    {
        $sql = 'INSERT INTO paquete(descripcion, valor_paquete, cantidad_clase, transmision, id_tipo_paquete)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->descripp, $this->valorpaquete, $this->cantidadclase, $this->transmision, $this->idtipopaquete);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento actualizar(update)
    public function updateRow()
    {
        $sql = 'UPDATE paquete
                SET descripcion = ?, valor_paquete = ?, cantidad_clase = ?, transmision = ?, id_tipo_paquete = ?
                WHERE id_paquete = ?';
        $params = array($this->descripp, $this->valorpaquete, $this->cantidadclase, $this->transmision, $this->idtipopaquete, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el mantenimiento eliminar(delete)
    public function deleteRow()
    {
        $sql = 'DELETE FROM paquete
        WHERE id_paquete = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para realizar el grafico de pastel de cantidad de paquetes por transmisiones 
    public function CantidadPaquetesPorTransmision()
    {
        $sql = 'SELECT paquete.transmision, ROUND((COUNT(id_paquete) * 100.0 / (SELECT COUNT(id_paquete) FROM paquete)), 2) porcentaje
        FROM paquete
        GROUP BY paquete.transmision ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

    //Método para realizar el grafico de paquetes por precios
    public function cantidadPaquetePrecio($precio_incial, $precio_final)
    {
        $sql = 'SELECT count(id_paquete) as cantidad, valor_paquete from inscripcion
        INNER JOIN paquete USING (id_paquete) 
        WHERE valor_paquete between ? and ?
        GROUP BY valor_paquete
        ORDER BY cantidad desc limit 5';
        $params = array($precio_incial, $precio_final);
        return Database::getRows($sql, $params);
    }

    //Método para realizar el reporte de los tipo de paquete
    public function tipoPaquete()
    {
        $sql = 'SELECT descripcion, valor_paquete, cantidad_clase, transmision
        FROM paquete 
        INNER JOIN tipo_paquete USING (id_tipo_paquete) 
        WHERE id_tipo_paquete = ?
        GROUP BY descripcion, valor_paquete, cantidad_clase, transmision
        ORDER BY valor_paquete';
        $params = array($this->idtipopaquete);
        return Database::getRows($sql, $params);
    }

    // Filtra todos los paquetes que le pertenecen a una transmisión en específico
    public function paquetesTransmision()
    {
        $sql = 'SELECT descripcion, valor_paquete, cantidad_clase, tipo_paquete
          FROM paquete 
          INNER JOIN tipo_paquete paq USING(id_tipo_paquete)
          WHERE transmision = ? 
          GROUP BY descripcion, valor_paquete, cantidad_clase, tipo_paquete
          ORDER BY valor_paquete';
        $params = array($this->transmision);
        return Database::getRows($sql, $params);
    }
}
