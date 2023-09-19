<?php
require_once('../../entities/dto/registros_intentos.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $fallidos = new RegistrosFallidos;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
   
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
                case 'readAll':
                    if ($result['dataset'] = $fallidos->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;

               
              
            default:
               
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
   
} else {
    print(json_encode('Recurso no disponible'));
}