<?php
require_once('../../entities/dto/sesion.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $sesion = new Sesion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readAll':
                if ($result['dataset'] = $sesion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'readOne':
                if (!$sesion->setId($_POST['id_sesion'])) {
                    $result['exception'] = 'Sesion incorrecto';
                } elseif ($result['dataset'] = $sesion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Sesion inexistente';
                }
                break;
            case 'readTipoClase':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Práctica', 'Práctica'),
                    array('Teórica', 'Teórica'),
                    array('Mecánica', 'Mecánica')
                );
                break;

            case 'readEstadoSesion':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Pendiente', 'Pendiente'),
                    array('Incompleta', 'Incompleta'),
                    array('Finalizada', 'Finalizada')
                );
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$sesion->setInicio($_POST['inicio'])) {
                    $result['exception'] = 'Hora inicio incorrecto';
                } elseif (!$sesion->setFin($_POST['fin'])) {
                    $result['exception'] = 'Hora fin incorrecto';
                } elseif (!$sesion->setEstadoSesion($_POST['estado'])) {
                    $result['exception'] = 'Estado de la sesión incorrecta';
                } elseif (!$sesion->setTipoClase($_POST['tipoclase'])) {
                    $result['exception'] = 'Tipo de clase incorrecta';
                } elseif (!$sesion->setAsistencia($_POST['asistencia'])) {
                    $result['exception'] = 'Asistencia incorrecta';
                } elseif (!$sesion->setIdDetalleInscripcion($_POST['detalleinscripcion'])) {
                    $result['exception'] = 'Detalle inscripcion incorrecta';
                } elseif (!$sesion->setIdEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$sesion->setIdVehiculo($_POST['vehiculo'])) {
                    $result['exception'] = 'Vehículo incorrecto';
                } elseif ($sesion->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesion creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$sesion->setId($_POST['id'])) {
                    $result['exception'] = 'id de la sesión incorrecto';
                } elseif (!$data = $sesion->readOne()) {
                    $result['exception'] = 'Sesión inexistente';
                } elseif (!$sesion->setInicio($_POST['inicio'])) {
                    $result['exception'] = 'Hora de inicio incorrecta';
                } elseif (!$sesion->setFin($_POST['fin'])) {
                    $result['exception'] = 'Hora fin incorrecto';
                } elseif (!$sesion->setEstadoSesion($_POST['estado'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$sesion->setTipoClase($_POST['tipoclase'])) {
                    $result['exception'] = 'Tipo de clase incorrecta';
                } elseif (!$sesion->setAsistencia(isset($_POST['asistencia']) ? 1 : 0)) {
                    $result['exception'] = 'Estado de la sesión incorrecta';
                } elseif (!$sesion->setIdDetalleInscripcion($_POST['detalleinscripcion'])) {
                    $result['exception'] = 'Detalle inscripcion incorrecta';
                } elseif (!$sesion->setIdEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$sesion->setIdVehiculo($_POST['vehiculo'])) {
                    $result['exception'] = 'Vehículo incorrecto';
                } elseif ($sesion->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Modelo modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$sesion->setId($_POST['id_sesion'])) {
                    $result['exception'] = 'Sesión incorrecta';
                } elseif (!$data = $sesion->readOne()) {
                    $result['exception'] = 'Sesión inexistente';
                } elseif ($sesion->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminado correctamente';
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
