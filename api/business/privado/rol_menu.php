<?php
require_once('../../entities/dto/rol_menu.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $rol_menu = new RolM;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
                case 'readAll':
                    if ($result['dataset'] = $rol_menu->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen '.count($result['dataset']).' registros';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay datos registrados';
                    }
                    break;
                //Se comprueba que los id estén correctos y que existen
            case 'readOneM':
                // print_r($_POST['id_rol-M']);
                if (!$rol_menu->setId($_POST['id_rol-M'])) {
                    $result['exception'] = 'Rol incorrecto';
                } elseif ($result['dataset'] = $rol_menu->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Rol inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'searchR':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search-rol'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $rol_menu->searchRows($_POST['search-rol'])) {
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
                if (!$rol_menu->setRol($_POST['rol'])) {
                    $result['exception'] = 'Rol incorrecto';
                }elseif(!$rol_menu->setOpciones($_POST['opciones'])){
                    $result['exception'] = 'Opciones incorrectas';
                }elseif(!$rol_menu->setAcciones($_POST['acciones'])){
                    $result['exception'] = 'Actividades incorrectas';
                } elseif ($rol_menu->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Rol creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$rol_menu->setId($_POST['id_rol-M'])) {
                    $result['exception'] = 'id de rol incorrecto';
                } elseif (!$rol_menu->setRol($_POST['rol'])) {
                    $result['exception'] = 'Rol incorrecto';
                }elseif(!$rol_menu->setOpciones($_POST['opciones'])){
                    $result['exception'] = 'Opciones incorrectas';
                }elseif(!$rol_menu->setAcciones($_POST['acciones'])){
                    $result['exception'] = 'Actividades incorrectas';
                } elseif ($rol_menu->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Rol modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
            case 'delete':
                if (!$rol_menu->setId($_POST['id_rol-M'])) {
                    $result['exception'] = 'Rol incorrecto';
                } elseif (!$data = $rol_menu->readOne()) {
                    $result['exception'] = 'Rol inexistente';
                } elseif ($rol_menu->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Rol eliminado correctamente';
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
    