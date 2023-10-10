<?php
require_once('../../entities/dto/afp.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $Afp = new Afp;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $Afp->readAll()) {
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
                if (!$Afp->setId($_POST['id_afp'])) {
                    $result['exception'] = 'AFP incorrecto';
                } elseif ($result['dataset'] = $Afp->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Afp inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search-AFP'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $Afp->searchRows($_POST['search-AFP'])) {
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
                if (!$Afp->setAfp($_POST['nombre_afp'])) {
                    $result['exception'] = 'Afp incorrecto';
                } elseif ($Afp->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Afp creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$Afp->setId($_POST['id_afp'])) {
                    $result['exception'] = 'id de Afp incorrecto';
                } elseif (!$data = $Afp->readOne()) {
                    $result['exception'] = 'Afp inexistente';
                } elseif (!$Afp->setAfp($_POST['nombre_afp'])) {
                    $result['exception'] = 'Afp incorrecto';
                } elseif ($Afp->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Afp modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
            case 'delete':
                if (!$Afp->setId($_POST['id_afp'])) {
                    $result['exception'] = 'Afp incorrecto';
                } elseif (!$data = $Afp->readOne()) {
                    $result['exception'] = 'Afp inexistente';
                } elseif ($Afp->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Afp eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }

         // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
         header('content-type: application/json; charset=utf-8');

    } else {
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $Afp->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
