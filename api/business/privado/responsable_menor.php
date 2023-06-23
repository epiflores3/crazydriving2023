<?php
require_once('../../entities/dto/responsable_menor.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $Responsable = new Responsable;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $Responsable->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'readOne':
                if (!$Responsable->setId($_POST['id_responsable_menor'])) {
                    $result['exception'] = 'Responsable incorrecto';
                } elseif ($result['dataset'] = $Responsable->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Responsable menor inexistente';
                }
                break;

            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $Responsable->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $Responsable->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

            case 'readCliente':
                if ($result['dataset'] = $Responsable->readCliente()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$Responsable->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$Responsable->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Telefono incorrecto';
                } elseif (!$Responsable->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$Responsable->setDui($_POST['dui'])) {
                    $result['exception'] = 'Dui incorrecto';
                } elseif (!$Responsable->setParentesco($_POST['parentesco'])) {
                    $result['exception'] = 'Parentesco incorrecto';
                } elseif (!isset($_POST['idcliente'])) {
                    $result['exception'] = 'Seleccione un cliente';
                } elseif (!$Responsable->setIdCliente($_POST['idcliente'])) {
                    $result['exception'] = 'Id Cliente incorrecto';
                } elseif ($Responsable->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Responsable agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$Responsable->setId($_POST['id'])) {
                    $result['exception'] = 'id del responsable menor incorrecto';
                } elseif (!$data = $Responsable->readOne()) {
                    $result['exception'] = 'Responsable menor inexistente';
                } elseif (!$Responsable->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$Responsable->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif (!$Responsable->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$Responsable->setDui($_POST['dui'])) {
                    $result['exception'] = 'Dui incorrecto';
                } elseif (!$Responsable->setParentesco($_POST['parentesco'])) {
                    $result['exception'] = 'Parentesco incorrecto';
                } elseif (!isset($_POST['idcliente'])) {
                    $result['exception'] = 'Seleccione un cliente';
                } elseif (!$Responsable->setIdCliente($_POST['idcliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($Responsable->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Responsable menor modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$Responsable->setId($_POST['id_responsable_menor'])) {
                    $result['exception'] = 'Responsable menor incorrecto';
                } elseif (!$data = $Responsable->readOne()) {
                    $result['exception'] = 'Responsable menor inexistente';
                } elseif ($Responsable->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Responsable menor eliminado correctamente';
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
