<?php
require_once('../../entities/dto/cliente.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $cliente = new Cliente;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $cliente->readAll()) {
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
                if (!$cliente->setId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecta';
                } elseif ($result['dataset'] = $cliente->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $cliente->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $cliente->searchRows($_POST['search'])) {
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
                    array('En proceso', 'En proceso'),
                    array('Pendiente', 'Pendiente'),
                    array('Finalizado', 'Finalizado'),
                    array('Suspendido', 'Suspendido')
                );
                break;
                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setNombre($_POST['nombrec'])) {
                    $result['exception'] = 'Nombre del cliente incorrecto';
                } elseif (!$cliente->setDUI($_POST['duic'])) {
                    $result['exception'] = 'DUI del cliente incorrecto';
                } elseif (!$cliente->setNacimiento($_POST['fechanacc'])) {
                    $result['exception'] = 'Fecha de nacimiento del cliente incorrecto';
                } elseif (!$cliente->setDireccion($_POST['direccionc'])) {
                    $result['exception'] = 'Dirección del cliente incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correoc'])) {
                    $result['exception'] = 'Correo del cliente incorrecto';
                }  elseif (!$cliente->setEstado($_POST['tipoestado'])) {
                    $result['exception'] = 'Estado del cliente incorrecto';
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setId($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$data = $cliente->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif (!$cliente->setNombre($_POST['nombrec'])) {
                    $result['exception'] = 'Nombre del cliente incorrecto';
                } elseif (!$cliente->setDUI($_POST['duic'])) {
                    $result['exception'] = 'DUI del cliente incorrecto';
                } elseif (!$cliente->setNacimiento($_POST['fechanacc'])) {
                    $result['exception'] = 'Fecha de nacimiento del cliente incorrecto';
                } elseif (!$cliente->setDireccion($_POST['direccionc'])) {
                    $result['exception'] = 'Dirección del cliente incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correoc'])) {
                    $result['exception'] = 'Correo del cliente incorrecto';
                }  elseif (!$cliente->setEstado($_POST['tipoestado'])) {
                    $result['exception'] = 'Estado del cliente incorrecto';
                } elseif ($cliente->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
            case 'delete':
                if (!$cliente->setId($_POST['id_vehiculo'])) {
                    $result['exception'] = 'Vehiculo incorrecta';
                } elseif (!$data = $cliente->readOne()) {
                    $result['exception'] = 'Vehiculo inexistente';
                } elseif ($cliente->deleteRow()) {
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
