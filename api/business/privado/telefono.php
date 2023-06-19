<?php
require_once('../../entities/dto/telefono.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $telefono = new Telefono;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $telefono->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readOne':
                if (!$telefono->setId($_POST['id_telefono'])) {
                    $result['exception'] = 'Telefono incorrecta';
                } elseif ($result['dataset'] = $telefono->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Telefono inexistente';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $telefono->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

                
                case 'getTipos':
                    $result ['status'] = 1;
                    $result ['dataset']=array(
                        array('Personal','Personal'),
                        array('Emergencia','Emergencia'),
                        array('Trabajo','Trabajo'),
                        array('Casa','Casa')
                    );
                    break;

            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$telefono->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecta';
                } elseif (!$telefono->setTipoTelefono($_POST['tipotelefono'])) {
                    $result['exception'] = 'Tipo de telefono incorrecta';
                } elseif (!$telefono->setId_cliente($_POST['cliente'])) {
                        $result['exception'] = 'Cliente incorrecto';
                } elseif ($telefono->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;


            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$telefono->setId($_POST['id'])) {
                    $result['exception'] = 'id de telefono incorrecta';
                } elseif (!$data = $telefono->readOne()) {
                    $result['exception'] = 'telefono inexistente';
                } elseif (!$telefono->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif (!$telefono->setTipoTelefono($_POST['tipotelefono'])) {
                    $result['exception'] = 'Tipo de telefono incorrecto';
                }elseif (!$telefono->setId_cliente($_POST['cliente'])) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif ($telefono->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Telefono modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$telefono->setId($_POST['id_telefono'])) {
                    $result['exception'] = 'Telefono incorrecta';
                } elseif (!$data = $telefono->readOne()) {
                    $result['exception'] = 'Telefono inexistente';
                } elseif ($telefono->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Telefono eliminado correctamente';
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
