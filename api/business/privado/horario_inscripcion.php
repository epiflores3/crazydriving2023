<?php
require_once('../../entities/dto/horario_inscripcion.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $horarioiinscripcion = new HorarioInscripcion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'dui_cliente' =>null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readAll':
                if ($result['dataset'] = $horarioiinscripcion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'readOne':
                if (!$horarioiinscripcion->setId($_POST['id'])) {
                        $result['exception'] = 'Horario inscripcion incorrecto';
                } elseif ($result['dataset'] = $horarioiinscripcion->readOne()) {
                        $result['status'] = 1;
                } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                } else {
                        $result['exception'] = 'Horario inscripcion inexistente';
                }
                break;

                case 'searchModalDetalle':
                    $_POST = Validator::validateForm($_POST);
                    if ($_POST['searchInputDetalle'] == '') {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    } elseif ($result['dataset'] = $horarioiinscripcion->searchModalDetalle($_POST['searchInputDetalle'])) {
                        $result['status'] = 1;
                        // $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                        $horarioiinscripcion->setDUI($_POST['searchInputDetalle']);
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                break;

                case 'cargarSelectDetalle':
                    $_POST = Validator::validateForm($_POST);
                    if (!$horarioiinscripcion->setDUI($_POST['data'])) {
                            $result['exception'] = 'DUI no encontrado';
                    } 
                    elseif ($result['dataset'] = $horarioiinscripcion->cargarDetalleSesion()) {
                        $result['status'] = 1;
                        // $result['message'] = 'Existen '.count($result['dataset']).' registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                break;

                case 'search':
                    $_POST = Validator::validateForm($_POST);
                    if ($_POST['shorarioinscripcion'] == '') {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    } elseif ($result['dataset'] = $horarioiinscripcion->searchRows($_POST['shorarioinscripcion'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                    break;

            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$horarioiinscripcion->setIdDetalleInscripcion($_POST['detalleinscripcion'])) {
                    $result['exception'] = 'horario de la inscripciom incorrecto';
                } elseif (!$horarioiinscripcion->setIdHorario($_POST['horario'])) {
                    $result['exception'] = 'hoario incorrecto';                
                } elseif ($horarioiinscripcion->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Horario inscripcion creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

    
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$horarioiinscripcion->setId($_POST['id'])) {
                        $result['exception'] = 'id de horario inscripcion incorrecta';
                } elseif (!$data = $horarioiinscripcion->readOne()) {
                        $result['exception'] = 'horario de la inscripcion inexistente';
                } elseif (!$horarioiinscripcion->setIdDetalleInscripcion($_POST['detalleinscripcion'])) {
                        $result['exception'] = 'Detalle de la inscripcion incorrecto';
                } elseif (!$horarioiinscripcion->setIdHorario($_POST['horario'])) {
                        $result['exception'] = 'Horario incorrecto';
                } elseif ($horarioiinscripcion->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Horario de la inscripcion modificada correctamente';
                } else {
                        $result['exception'] = Database::getException();
                }
                break;

                case 'delete':
                    if (!$horarioiinscripcion->setId($_POST['idhorarioiincripcion'])) {
                        $result['exception'] = 'Horario incorrecta';
                    } elseif (!$data = $horarioiinscripcion->readOne()) {
                        $result['exception'] = 'Horario inexistente';
                    } elseif ($horarioiinscripcion->deleteRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Horario eliminado correctamente';
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