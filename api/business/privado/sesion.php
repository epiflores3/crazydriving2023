<?php
require_once('../../entities/dto/sesion.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $sesion = new Sesion;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
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
                //Se comprueba que los id estén correctos y que existen
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
                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'readTipoClase':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Práctica', 'Práctica'),
                    array('Teórica', 'Teórica'),
                    array('Mecánica', 'Mecánica')
                );
                break;
                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'readEstadoSesion':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Pendiente', 'Pendiente'),
                    array('Incompleta', 'Incompleta'),
                    array('Finalizada', 'Finalizada')
                );
                break;
                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
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
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $sesion->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $sesion->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
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
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
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

            case 'reportTL':
                    $_POST = Validator::validateForm($_POST);
    
                    if (!$sesion->setTipoClase($_POST['tipodeclasecmb'])) {
                        $result['exception'] = 'Tipo clase incorrecto';
                    } elseif ($result['dataset'] = $sesion->sesiontipoclase()) {
                        $result['status'] = 1;
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
