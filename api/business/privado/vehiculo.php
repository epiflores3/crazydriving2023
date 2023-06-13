<?php
require_once('../../entities/dto/vehiculo.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $vehiculo = new Vehiculo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $vehiculo->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readOne':
                if (!$vehiculo->setId($_POST['id_marca'])) {
                    $result['exception'] = 'Marca incorrecta';
                } elseif ($result['dataset'] = $vehiculo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Marca inexistente';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $vehiculo->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                /*Aqui me quede no he terminado el insert*/ 
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$valo->setId($_POST['id_vehiculo'])) {
                    $result['exception'] = 'Vehiculo incorrecto';
                } elseif (!$valo->setPlaca($_POST['placa'])) {
                    $result['exception'] = 'Placa incorrecta';
                } elseif (!$valo->setTipoVehiuclo($_POST['Tipo'])) {
                    $result['exception'] = 'Tipo de vehiculo incorrecta';
                } elseif (!$valo->setId_modelo($_POST['cantidad'])) {
                        $result['exception'] = 'Modelo incorrecta';
                } elseif ($valo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Vehiculo agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$vehiculo->setId($_POST['id'])) {
                    $result['exception'] = 'id de marca incorrecta';
                } elseif (!$data = $vehiculo->readOne()) {
                    $result['exception'] = 'Marca inexistente';
                } elseif (!$vehiculo->setMarca($_POST['marca'])) {
                    $result['exception'] = 'Marca incorrecto';
                } elseif ($vehiculo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$vehiculo->setId($_POST['id_vehiculo'])) {
                    $result['exception'] = 'Vehiculo incorrecta';
                } elseif (!$data = $vehiculo->readOne()) {
                    $result['exception'] = 'Vehiculo inexistente';
                } elseif ($vehiculo->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Vehiculo eliminado correctamente';
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
