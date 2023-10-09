<?php
require_once('../../entities/dto/paquete.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $paquete = new Paquete;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $paquete->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'getTransmision':
                $result['status'] = 1;
                $result['dataset'] = $paquete::TRANSMISION;
                break;
                
                //Se comprueba que los id estén correctos y que existen
            case 'readOne':
                if (!$paquete->setId($_POST['id_paquete'])) {
                    $result['exception'] = 'Paquete incorrecto';
                } elseif ($result['dataset'] = $paquete->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Paquete inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $paquete->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $paquete->searchRows($_POST['search'])) {
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
                if (!$paquete->setDescripcion($_POST['descripcion_paquete'])) {
                    $result['exception'] = 'Descripción incorrecto';
                } elseif (!$paquete->setValorPaquete($_POST['valorpaquete_paquete'])) {
                    $result['exception'] = 'Valor paquete incorrecto';
                } elseif (!$paquete->setTranmision($_POST['transmision_paquete'])) {
                    $result['exception'] = 'Transmisión incorrecto';
                } elseif (!$paquete->setCantidadClase($_POST['cantidadclases_paquete'])) {
                    $result['exception'] = 'Cantidad de clases incorrecto';
                } elseif (!$paquete->setTipoPaquete($_POST['tipo_paquete_tp'])) {
                    $result['exception'] = 'Tipo paquete incorrecta';
                } elseif ($paquete->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Paquete creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$paquete->setId($_POST['id_paquete'])) {
                    $result['exception'] = 'Paquete incorrecto';
                } elseif (!$paquete->setDescripcion($_POST['descripcion_paquete'])) {
                    $result['exception'] = 'Decsripción incorrecto';
                } elseif (!$paquete->setValorPaquete($_POST['valorpaquete_paquete'])) {
                    $result['exception'] = 'Valor paquete incorrecto';
                } elseif (!$paquete->setTranmision($_POST['transmision_paquete'])) {
                    $result['exception'] = 'Transmisicion incorrecto';
                } elseif (!$paquete->setCantidadClase($_POST['cantidadclases_paquete'])) {
                    $result['exception'] = 'Cantidad de clases incorrecto';
                } elseif (!$paquete->setTipoPaquete($_POST['tipo_paquete_tp'])) {
                    $result['exception'] = 'Tipo paquete incorrecta';
                } elseif ($paquete->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
            case 'delete':
                if (!$paquete->setId($_POST['id_paquete'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif (!$data = $paquete->readOne()) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($paquete->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Se mandar a llamar a la consulta, para que se pueda mostrar futuramente la gráfica 
            case 'CantidadPaquetesPorTransmision':
                if ($result['dataset'] = $paquete->cantidadPaquetesPorTransmision()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                // Se mandar a llamar a la consulta, para que se pueda mostrar futuramente la gráfica 
            case 'cantidadPaquetePrecio':
                if ($_POST['precio_incial'] >= $_POST['precio_final']) {
                    $result['exception'] = 'Rango no valido, escribe correctamente, la precio inicial no puede ser mayor o igual a la precio final';
                }elseif ($result['dataset'] = $paquete->cantidadPaquetePrecio($_POST['precio_incial'], $_POST['precio_final'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Top 5 encontrado correctamente';
                } else {
                    $result['exception'] = 'No hay datos disponibles';
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
