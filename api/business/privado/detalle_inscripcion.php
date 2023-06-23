<?php
require_once('../../entities/dto/detalle_inscripcion.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $detalleinscripcion = new DetalleInscripcion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readAll':
                if ($result['dataset'] = $detalleinscripcion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'readOne':
                if (!$detalleinscripcion->setId($_POST['id_detalle_inscripcion'])) {
                    $result['exception'] = 'Horario inscripcion incorrecto';
                } elseif ($result['dataset'] = $detalleinscripcion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Horario inscripcion inexistente';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $detalleinscripcion->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $detalleinscripcion->searchRows($_POST['search'])) {
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
                if (!$detalleinscripcion->setFechaInicio($_POST['fechaini'])) {
                    $result['exception'] = 'Fecha de inicio incorrecto';
                } elseif (!$detalleinscripcion->setDia($_POST['dia'])) {
                    $result['exception'] = 'Dia incorrecto';
                } elseif (!$detalleinscripcion->setIdPaquete($_POST['paquete'])) {
                    $result['exception'] = 'Paquete incorrecto';
                } elseif (!$detalleinscripcion->setIdInscripcion($_POST['inscripcion'])) {
                    $result['exception'] = 'Inscripcion incorrecta';
                } elseif (!$detalleinscripcion->setIdEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif ($detalleinscripcion->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle inscripcin creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$detalleinscripcion->setId($_POST['id'])) {
                    $result['exception'] = 'id de detalle inscripcion incorrecta';
                } elseif (!$data = $detalleinscripcion->readOne()) {
                    $result['exception'] = 'Horario inexistente';
                } elseif (!$detalleinscripcion->setFechaInicio($_POST['fechaini'])) {
                    $result['exception'] = 'Fecha de inicio incorrecto';
                } elseif (!$detalleinscripcion->setDia($_POST['dia'])) {
                    $result['exception'] = 'Dia incorrecto';
                } elseif (!$detalleinscripcion->setIdPaquete($_POST['paquete'])) {
                    $result['exception'] = 'Paquete incorrecto';
                } elseif (!$detalleinscripcion->setIdInscripcion($_POST['inscripcion'])) {
                    $result['exception'] = 'Inscripcion incorrecta';
                } elseif (!$detalleinscripcion->setIdEmpleado($_POST['empleado'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif ($detalleinscripcion->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Horario modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'delete':
                if (!$detalleinscripcion->setId($_POST['id_detalle_inscripcion'])) {
                    $result['exception'] = 'Detalle inscripcion incorrecta';
                } elseif (!$data = $detalleinscripcion->readOne()) {
                    $result['exception'] = 'Detalle inscripcion inexistente';
                } elseif ($detalleinscripcion->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Detalle inscripcion eliminado correctamente';
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
