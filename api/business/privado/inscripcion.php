<?php
require_once('../../entities/dto/inscripcion.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $inscripcion = new Inscripcion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $inscripcion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                case 'readOne':
                    if (!$inscripcion->setId($_POST['id_inscripcion'])) {
                        $result['exception'] = 'Inscripcion incorrecto';
                    } elseif ($result['dataset'] = $inscripcion->readOne()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Inscripcion inexistente';
                    }
                    break;  


                case 'getTipoLicencia':
                    $result ['status'] = 1;
                    $result ['dataset']=array(
                        array('Liviana','Liviana'),
                        array('Particular','Particular'),
                        array('Motocicleta','Motocicleta'),
                        array('Juvenil motocicleta','Juvenil motocicleta'),
                        array('Juvenil particular','Juvenil particular'),
                        array('Pesada','Pesada'),
                        array('Pesada T','Pesada T')
                       
                    );

                break;

                case 'getEstadoCliente':
                    $result ['status'] = 1;
                    $result ['dataset']=array(
                        array('En proceso','En proceso'),
                        array('Pendiente','Pendiente'),
                        array('Finalizado','Finalizado'),
                        array('Suspendido','Suspendido') 
                    );
                break;

                case 'create':
                    $_POST = Validator::validateForm($_POST);
                    if (!$inscripcion->setAnticipo($_POST['anticipo'])) {
                        $result['exception'] = 'Anticipo incorrecto';
                    } elseif (!$inscripcion->setFechar($_POST['fecharegistro'])) {
                        $result['exception'] = 'Fecha registro incorrecto';
                    }   elseif (!$inscripcion->setFechai($_POST['fechaini'])) {
                        $result['exception'] = 'Fecha inicio incorrecto';
                    }   elseif (!$inscripcion->setEvaluacion(isset($_POST['evaluacion']) ? 1 : 0)) {
                        $result['exception'] = 'Evaluacion incorrecto';
                    } elseif (!$inscripcion->setTlicencia($_POST['tipodelicencia'])) {
                        $result['exception'] = 'Tipo licencia incorrecta';
                    } elseif (!$inscripcion->setEstado($_POST['estadoc'])) {
                        $result['exception'] = 'Estado cliente incorrecta';
                    } elseif (!$inscripcion->setIdcliente($_POST['cliente'])) {
                        $result['exception'] = 'Cliente incorrecta';
                    } elseif (!$inscripcion->setIdempleado($_POST['asesor'])) {
                        $result['exception'] = 'Empleado incorrecta';
                    } elseif ($inscripcion->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Inscripcion creado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;

                    case 'update':
                        $_POST = Validator::validateForm($_POST);
                        if (!$inscripcion->setId($_POST['id'])) {
                            $result['exception'] = 'Inscripcion incorrecto';
                        }elseif (!$inscripcion->setAnticipo($_POST['anticipo'])) {
                                $result['exception'] = 'Anticipo incorrecto';
                            } elseif (!$inscripcion->setFechar($_POST['fecharegistro'])) {
                                $result['exception'] = 'Fecha registro incorrecto';
                            }   elseif (!$inscripcion->setFechai($_POST['fechaini'])) {
                                $result['exception'] = 'Fecha inicio incorrecto';
                            }   elseif (!$inscripcion->setEvaluacion(isset($_POST['evaluacion']) ? 1 : 0)) {
                                $result['exception'] = 'Evaluacion incorrecto';
                            } elseif (!$inscripcion->setTlicencia($_POST['tipodelicencia'])) {
                                $result['exception'] = 'Tipo licencia incorrecta';
                            } elseif (!$inscripcion->setEstado($_POST['estadoc'])) {
                                $result['exception'] = 'Estado cliente incorrecta';
                            } elseif (!$inscripcion->setIdcliente($_POST['cliente'])) {
                                $result['exception'] = 'Cliente incorrecta';
                            } elseif (!$inscripcion->setIdempleado($_POST['asesor'])) {
                                $result['exception'] = 'Empleado incorrecta';
                        } elseif ($inscripcion->updateRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Inscripcion modificado correctamente';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                     break;

                case 'delete':
                    if (!$inscripcion->setId($_POST['id_inscripcion'])) {
                        $result['exception'] = 'Inscripcion incorrecto';
                    } elseif (!$data = $inscripcion->readOne()) {
                        $result['exception'] = 'Inscripcion inexistente';
                    } elseif ($inscripcion->deleteRow()) {
                        $result['status'] = 1;
                            $result['message'] = 'Inscripcion eliminado correctamente';
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
