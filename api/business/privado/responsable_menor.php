<?php
require_once('../../entities/dto/responsable_menor.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $Responsable = new Responsable;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
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
                //Se comprueba que los id estén correctos y que existen
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
                //Acción para poder buscar dentro de la interfaz
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
                //Se comprueba si existen registro de cliente para poder asignarle un responsable
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
                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
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
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
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
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
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
