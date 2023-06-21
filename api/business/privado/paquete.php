<?php
require_once('../../entities/dto/paquete.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $paquete = new Paquete;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $paquete->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                } 
                break;

                case 'getTransmision':
                    $result ['status'] = 1;
                    $result ['dataset']=array(
                        array('Estándar','Estándar'),
                        array('Automático','Automático')
                    );
                    break;

            case 'readOne':
                if (!$paquete->setId($_POST['id_paquete'])) {
                    $result['exception'] = 'Paquete incorrecto';
                } elseif ($result['dataset'] = $paquete->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Paquete inexistente';
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
                if (!$paquete->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecto';
                } elseif (!$paquete->setValorPaquete($_POST['valorpaquete'])) {
                    $result['exception'] = 'Valor paquete incorrecto';
                }   elseif (!$paquete->setTranmision($_POST['transmision'])) {
                    $result['exception'] = 'Transmisión incorrecto';
                }   elseif (!$paquete->setCantidadClase($_POST['cantidadclases'])) {
                    $result['exception'] = 'Cantidad de clases incorrecto';
                } elseif (!$paquete->setTipoPaquete($_POST['tipopaquete'])) {
                    $result['exception'] = 'Tipo paquete incorrecta';
                } elseif ($paquete->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Paquete creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
           
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$paquete->setId($_POST['id'])) {
                    $result['exception'] = 'Paquete incorrecto';
                }elseif (!$paquete->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Decsripción incorrecto';
                } elseif (!$paquete->setValorPaquete($_POST['valorpaquete'])) {
                    $result['exception'] = 'Valor paquete incorrecto';
                }   elseif (!$paquete->setTranmision($_POST['transmision'])) {
                    $result['exception'] = 'Transmisicion incorrecto';
                }   elseif (!$paquete->setCantidadClase($_POST['cantidadclases'])) {
                    $result['exception'] = 'Cantidad de clases incorrecto';
                } elseif (!$paquete->setTipoPaquete($_POST['tipopaquete'])) {
                    $result['exception'] = 'Tipo paquete incorrecta';
                } elseif ($paquete->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
             break;
                
              case 'delete':
                if (!$paquete->setId($_POST['id_paquete'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$data = $paquete->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($paquete->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'Pedido eliminado correctamente';
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