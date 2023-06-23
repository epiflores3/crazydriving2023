<?php
require_once('../../entities/dto/modelo.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $modelo = new Modelo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $modelo->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readOne':
                if (!$modelo->setId($_POST['id_modelo'])) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif ($result['dataset'] = $modelo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Modelo inexistente';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $modelo->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $modelo->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$modelo->setModelo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo incorrecto';
                }
                if (!$modelo->setMarca($_POST['marca'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif ($modelo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modelo creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$modelo->setId($_POST['id'])) {
                    $result['exception'] = 'id de modelo incorrecto';
                } elseif (!$data = $modelo->readOne()) {
                    $result['exception'] = 'Modelo inexistente';
                } elseif (!$modelo->setModelo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif (!$modelo->setMarca($_POST['marca'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif ($modelo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modelo modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$modelo->setId($_POST['id_modelo'])) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif (!$data = $modelo->readOne()) {
                    $result['exception'] = 'Mnenú inexistente';
                } elseif ($modelo->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modelo eliminado correctamente';
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
