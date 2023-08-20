<?php
require_once('../../entities/dto/inscripcion.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $inscripcion = new Inscripcion;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe hay una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
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
                //Se comprueba que los id estén correctos y que existen
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
                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'getTipoLicencia':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Liviana', 'Liviana'),
                    array('Particular', 'Particular'),
                    array('Motocicleta', 'Motocicleta'),
                    array('Juvenil motocicleta', 'Juvenil motocicleta'),
                    array('Juvenil particular', 'Juvenil particular'),
                    array('Pesada', 'Pesada'),
                    array('Pesada T', 'Pesada T')
                );
                break;
                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'getEstadoCliente':
                $result['status'] = 1;
                $result['dataset'] = $inscripcion::ESTADOS;
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $inscripcion->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $inscripcion->searchRows($_POST['search'])) {
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
                if (!$inscripcion->setAnticipo($_POST['anticipo'])) {
                    $result['exception'] = 'Anticipo incorrecto';
                } elseif (!$inscripcion->setFechar($_POST['fecharegistro'])) {
                    $result['exception'] = 'Fecha registro incorrecto';
                } elseif (!$inscripcion->setFechai($_POST['fechaini'])) {
                    $result['exception'] = 'Fecha inicio incorrecto';
                } elseif (!$inscripcion->setEvaluacion(isset($_POST['evaluacion']) ? 1 : 0)) {
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
                //Se comprueba lo que viene del input
                // case 'uniqueCustomerRegistration':
                //     if (!$inscripcion->setIdcliente($_POST['cliente'])) {
                //         $result['exception'] = 'Inscripcion incorrecto';
                //     } elseif ($result['dataset'] = $inscripcion->uniqueCustomerRegistration()) {
                //         $result['status'] = 1;
                //     } else {
                //         $result['exception'] = Database::getException();
                //     } 
                //     break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$inscripcion->setId($_POST['id'])) {
                    $result['exception'] = 'Inscripcion incorrecto';
                } elseif (!$inscripcion->setAnticipo($_POST['anticipo'])) {
                    $result['exception'] = 'Anticipo incorrecto';
                } elseif (!$inscripcion->setFechar($_POST['fecharegistro'])) {
                    $result['exception'] = 'Fecha registro incorrecto';
                } elseif (!$inscripcion->setFechai($_POST['fechaini'])) {
                    $result['exception'] = 'Fecha inicio incorrecto';
                } elseif (!$inscripcion->setEvaluacion(isset($_POST['evaluacion']) ? 1 : 0)) {
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
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
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
                //Se manda a llamar el método que trae los datos de la base de datos, que se convertran en gráfico lineal
            case 'cantidadDeFechasInicio':
                if ($_POST['fecha_inicial'] > $_POST['fecha_final']) {
                    $result['exception'] = 'No hay datos disponibles';
                } elseif ($result['dataset'] = $inscripcion->cantidadFechasInicio($_POST['fecha_inicial'], $_POST['fecha_final'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Top 5 encontrado correctamente';
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                //Se manda a llamar el método que trae los datos de la base de datos, que se convertran en gráfico 
            case 'cantidadHorariosMasSolicitados':
                if ($result['dataset'] = $inscripcion->cantidadHorariosMasSolicitados($_POST['hora_inicial'], $_POST['hora_final'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Top 5 encontrado correctamente';
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                //Se manda a llamar el método que trae los datos de la base de datos, que se convertran en gráfico 
            case 'inscripcionesMasFechas':
                if ($result['dataset'] = $inscripcion->inscripcionesMasFechas($_POST['inicial'], $_POST['final'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Top 5 encontrado correctamente';
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                // Se mandar a llamar a la consulta, para que se pueda mostrar futuramente la gráfica de pastel
            case 'CantidadEvaluacionInscripcion':
                if ($result['dataset'] = $inscripcion->cantidadEvaluacionInscripcion()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;
                // Se mandar a llamar a la consulta, para que se pueda mostrar futuramente el reporte parametrizado
            case 'reportTL':
                $_POST = Validator::validateForm($_POST);

                if (!$inscripcion->setTlicencia($_POST['tipodelicenciacmb'])) {
                    $result['exception'] = 'Tipo licencia incorrecta';
                } elseif ($result['dataset'] = $inscripcion->inscripcionLicencia()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                // Se mandar a llamar a la consulta, para que se pueda mostrar futuramente la gráfica de pastel
            case 'cantidadPaquetesMasVendidos':
                if ($result['dataset'] = $inscripcion->cantidadPaquetesMasVendidos()) {
                    $result['status'] = 1;
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
