<?php
require_once('../../entities/dto/notificacion.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $notificacion = new Notificacion;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
   
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
                case 'notifi':
                    $_POST = Validator::validateForm($_POST);
                    if (!$notificacion->setAccion($_POST['accion'])) {
                        $result['exception'] = 'Accion no leida';
                    } elseif (!$notificacion->createNoti()) {
                        $result['status'] = 1;
                        $result['message'] = 'Notificacion creada';
                    } else {
                        $result['exception'] = Database::getException();
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