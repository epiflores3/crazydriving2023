<?php
require_once('../../entities/dto/tipo_paquete.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $TipoPaquete = new TipoPaquete;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $TipoPaquete->readAll()) {
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
                if (!$TipoPaquete->setId($_POST['id_tipo_paquete'])) {
                    $result['exception'] = 'tipo paquete incorrecto';
                } elseif ($result['dataset'] = $TipoPaquete->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Tipo paquete inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search-tp'] == '') {
                    if ($result['dataset'] = $TipoPaquete->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search-tp'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $TipoPaquete->searchRows($_POST['search-tp'])) {
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
                if (!$TipoPaquete->setTipoPaquete($_POST['tipo_paquete_tp'])) {
                    $result['exception'] = 'Tipo paquete incorrecto';
                } elseif ($TipoPaquete->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo paquete creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$TipoPaquete->setId($_POST['id_tipo_paquete'])) {
                    $result['exception'] = 'id de tipo paquete incorrecto';
                } elseif (!$data = $TipoPaquete->readOne()) {
                    $result['exception'] = 'Tipo paquete inexistente';
                } elseif (!$TipoPaquete->setTipoPaquete($_POST['tipo_paquete_tp'])) {
                    $result['exception'] = 'Tipo paquete incorrecto';
                } elseif ($TipoPaquete->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo Paquete modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
            case 'delete':
                if (!$TipoPaquete->setId($_POST['id_tipo_paquete'])) {
                    $result['exception'] = 'Tipo Paquete incorrecto';
                } elseif (!$data = $TipoPaquete->readOne()) {
                    $result['exception'] = 'Tipo paquete inexistente';
                } elseif ($TipoPaquete->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tipo paquete eliminado correctamente';
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
