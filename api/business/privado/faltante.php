<?php
require_once('../../entities/dto/faltante.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $faltante = new Faltante;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'dui_cliente' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $faltante->readAll()) {
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
                if (!$faltante->setId($_POST['id_faltante'])) {
                    $result['exception'] = 'Registro faltante incorrecto';
                } elseif ($result['dataset'] = $faltante->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Registro faltante inexistente';
                }
                break;
                //Acción para poder buscar dentro de un modal
            case 'searchModal':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['searchInput'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $faltante->searchModal($_POST['searchInput'])) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    $faltante->setDUI($_POST['searchInput']);
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                //Se comprueban que el campo DUI se encuentra registrado 
            case 'cargarSelect':
                $_POST = Validator::validateForm($_POST);
                if (!$faltante->setDUI($_POST['data'])) {
                    $result['exception'] = 'DUI no encontrado';
                } elseif ($result['dataset'] = $faltante->cargarSesion()) {
                    $result['status'] = 1;
                    // $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['sfaltante'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $faltante->searchRows($_POST['sfaltante'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$faltante->setCantidadMinuto($_POST['cantidad'])) {
                    $result['exception'] = ' Cantidad incorrecta';
                } elseif (!$faltante->setIdSesion($_POST['sesion'])) {
                    $result['exception'] = 'sesion incorrecta';
                } elseif ($faltante->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Registro faltante creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$faltante->setId($_POST['id'])) {
                    $result['exception'] = 'id de la Sesion incorrecta';
                } elseif (!$data = $faltante->readOne()) {
                    $result['exception'] = 'Sesion inexistente';
                } elseif (!$faltante->setCantidadMinuto($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecto';
                } elseif (!$faltante->setIdSesion($_POST['sesion'])) {
                    $result['exception'] = 'Sesion incorrecto';
                } elseif ($faltante->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesion modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.
            case 'delete':
                if (!$faltante->setId($_POST['id'])) {
                    $result['exception'] = 'Faltante incorrecta';
                } elseif (!$data = $faltante->readOne()) {
                    $result['exception'] = 'Faltante inexistente';
                } elseif ($faltante->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Faltante eliminado correctamente';
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
