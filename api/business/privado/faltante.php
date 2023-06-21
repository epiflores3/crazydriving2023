<?php
require_once('../../entities/dto/faltante.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $faltante = new Faltante;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'dui_cliente' =>null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readAll':
                if ($result['dataset'] = $faltante->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'readOne':
                if (!$faltante->setId($_POST['id_faltante'])) {
                        $result['exception'] = 'Registro faltante incorrecto';
                } elseif ($result['dataset'] = $faltante->readOne()) {
                        $result['status'] = 1;
                } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                } else {
                        $result['exception'] = 'Registro faltante inexistente';
                }
                break;

            case 'searchModal':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['searchInput'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $faltante->searchModal($_POST['searchInput'])) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    $faltante->setDUI($_POST['searchInput']);
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
            break;


            case 'cargarSelect':
                $_POST = Validator::validateForm($_POST);
                if (!$faltante->setDUI($_POST['data'])) {
                        $result['exception'] = 'DUI no encontrado';
                } 
                elseif ($result['dataset'] = $faltante->cargarSesion()) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
            break;


            // case 'search':
            //     $_POST = Validator::validateForm($_POST);
            //     if ($_POST['search'] == '') {
            //         $result['exception'] = 'Ingrese un valor para buscar';
            //     } elseif ($result['dataset'] = $horario->searchRows($_POST['search'])) {
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
                if (!$faltante->setCantidadMinuto($_POST['cantidad'])) {
                    $result['exception'] = ' Cantidad incorrecta';
                } elseif (!$faltante->setIdSesion($_POST['sesion'])) {
                    $result['exception'] = 'sesion incorrecta'; 
                } elseif ($faltante->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Registro faltante creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$faltante->setId($_POST['id'])) {
                        $result['exception'] = 'id de la Sesion incorrecta';
                } elseif (!$data = $faltante->readOne()) {
                        $result['exception'] = 'Sesion inexistente';
                } elseif (!$faltante->setCantidadMinuto($_POST['cantidad'])) {
                        $result['exception'] = 'Cantidad incorrecto';
                } elseif (!$faltante->setIdSesion($_POST['sesion'])) {
                        $result['exception'] = 'Sesion incorrecto';
                } elseif ($faltante->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Sesion modificada correctamente';
                } else {
                        $result['exception'] = Database::getException();
                }
                break;

                case 'delete':
                    if (!$faltante->setId($_POST['id'])) {
                        $result['exception'] = 'Faltante incorrecta';
                    } elseif (!$data = $faltante->readOne()) {
                        $result['exception'] = 'Faltante inexistente';
                    } elseif ($faltante->deleteRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Faltante eliminado correctamente';
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