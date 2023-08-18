<?php
require_once('../../entities/dto/detalle_inscripcion.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $detalleinscripcion = new DetalleInscripcion;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe hay una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
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
                //Se comprueba que los id estén correctos y que existen
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
                //Acción para poder buscar dentro de la interfaz
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
                //Acción para poder buscar dentro de la interfaz
            case 'BuscarInscripcion':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $detalleinscripcion->BuscarInscripcion($_POST['search'])) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    $detalleinscripcion->setDUI($_POST['search']);
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
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
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
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
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.
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
