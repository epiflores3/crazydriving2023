<?php
require_once('../../entities/dto/vehiculo.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia la clase correspondiente.
    $vehiculo = new Vehiculo;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
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
                //Se comprueba que los id estén correctos y que existen
            case 'readOne':
                if (!$vehiculo->setId($_POST['id_vehiculo'])) {
                    $result['exception'] = 'Vehiculo incorrecta';
                } elseif ($result['dataset'] = $vehiculo->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Vehiculo inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $vehiculo->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
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
                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'getTipos':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Carro', 'Carro'),
                    array('Pick up', 'Pick up'),
                    array('Motocicleta', 'Motocicleta')
                );
                break;
                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$vehiculo->setPlaca($_POST['placa'])) {
                    $result['exception'] = 'Placa incorrecta';
                } elseif (!$vehiculo->setTipoVehiuclo($_POST['tipovehiculo'])) {
                    $result['exception'] = 'Tipo de vehiculo incorrecta';
                } elseif (!$vehiculo->setId_modelo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo incorrecta';
                } elseif ($vehiculo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Vehiculo agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$vehiculo->setId($_POST['id'])) {
                    $result['exception'] = 'id de vehiculo incorrecta';
                } elseif (!$data = $vehiculo->readOne()) {
                    $result['exception'] = 'Vehiculo inexistente';
                } elseif (!$vehiculo->setPlaca($_POST['placa'])) {
                    $result['exception'] = 'Placa incorrecto';
                } elseif (!$vehiculo->setTipoVehiuclo($_POST['tipovehiculo'])) {
                    $result['exception'] = 'Tipo de vehiculo incorrecto';
                } elseif (!$vehiculo->setId_modelo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif ($vehiculo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Marca modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
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
