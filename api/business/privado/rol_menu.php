<?php
require_once('../../entities/dto/rol_menu.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $rolmenu = new RolMenu;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $rolmenu->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                } 
                break;

             
            case 'readOne':
                if (!$rolmenu->setId($_POST['id_rol_menu'])) {
                    $result['exception'] = 'Rol menu incorrecto';
                } elseif ($result['dataset'] = $rolmenu->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Rol menu inexistente';
                }
                break;    

            // case 'search':
            //     $_POST = Validator::validateForm($_POST);
            //     if ($_POST['search'] == '') {
            //         $result['exception'] = 'Ingrese un valor para buscar';
            //     } elseif ($result['dataset'] = $paquete->searchRows($_POST['search'])) {
            //         $result['status'] = 1;
            //         $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
            //     } elseif (Database::getException()) {
            //         $result['exception'] = Database::getException();
            //     } else {
            //         $result['exception'] = 'No hay coincidencias';
            //     }
            //     break;

                
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$rolmenu->setRol($_POST['rol'])) {
                    $result['exception'] = 'Rol incorrecto';
                } elseif (!$rolmenu->setMenu($_POST['menu'])) {
                    $result['exception'] = 'Menu incorrecto';
                } elseif ($rolmenu->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Rol menu creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
           
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$rolmenu->setId($_POST['id'])) {
                    $result['exception'] = 'Rol_menu incorrecto';
                }elseif (!$rolmenu->setRol($_POST['rol'])) {
                    $result['exception'] = 'Rol incorrecto';
                } elseif (!$rolmenu->setMenu($_POST['menu'])) {
                    $result['exception'] = 'Menu incorrecto';
                } elseif ($rolmenu->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Rol menu modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
             break;
                
              case 'delete':
                if (!$rolmenu->setId($_POST['id_rol_menu'])) {
                    $result['exception'] = 'Rol menu incorrecto';
                } elseif (!$data = $rolmenu->readOne()) {
                    $result['exception'] = 'Rol menu inexistente';
                } elseif ($rolmenu->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'Rol menu eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}