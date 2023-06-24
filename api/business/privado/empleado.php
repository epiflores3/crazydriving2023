<?php
require_once('../../entities/dto/empleado.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $empleado = new Empleado;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe hay una sesión, de lo contrario se muestra un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
        switch ($_GET['action']) {
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $empleado->readAll()) {
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
                if (!$empleado->setId($_POST['id_empleado'])) {
                    $result['exception'] = 'Empleado incorrecta';
                } elseif ($result['dataset'] = $empleado->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Empleado inexistente';
                }
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $empleado->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $empleado->searchRows($_POST['search'])) {
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
                if (!$empleado->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del empleado incorrecto';
                } elseif (!$empleado->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI del empleado incorrecto';
                } elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$empleado->setLicencia($_FILES['licencia'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$empleado->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono del empleado incorrecto';
                } elseif (!$empleado->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento del empleado incorrecto';
                } elseif (!$empleado->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección del empleado incorrecto';
                } elseif (!$empleado->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo del empleado incorrecto';
                } elseif (!$empleado->setAFP($_POST['afp'])) {
                    $result['exception'] = 'Nombre de afp del empleado incorrecto';
                } elseif (!$empleado->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado del empleado incorrecto';
                } elseif (!$empleado->setRol($_POST['rol'])) {
                    $result['exception'] = 'Rol del empleado incorrecto';
                } elseif (!$empleado->setSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal del empleado incorrecta';
                } elseif ($empleado->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['licencia'], $empleado->getRuta(), $empleado->getLicencia())) {
                        $result['message'] = 'Empleado creado correctamente';
                    } else {
                        $result['message'] = 'Empleado creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$empleado->setId($_POST['id'])) {
                    $result['exception'] = 'Empleado incorrecto';
                } elseif (!$data = $empleado->readOne()) {
                    $result['exception'] = 'Empleado inexistente';
                } elseif (!$empleado->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del empleado incorrecto';
                } elseif (!$empleado->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI del empleado incorrecto';
                } elseif (!$empleado->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono del empleado incorrecto';
                } elseif (!$empleado->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento del empleado incorrecto';
                } elseif (!$empleado->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección del empleado incorrecto';
                } elseif (!$empleado->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo del empleado incorrecto';
                } elseif (!$empleado->setAFP($_POST['afp'])) {
                    $result['exception'] = 'Nombre de afp del empleado incorrecto';
                } elseif (!$empleado->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado del empleado incorrecto';
                } elseif (!$empleado->setRol($_POST['rol'])) {
                    $result['exception'] = 'Rol del empleado incorrecto';
                } elseif (!$empleado->setSucursal($_POST['sucursal'])) {
                    $result['exception'] = 'Sucursal del empleado incorrecta';
                } elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    if ($empleado->updateRow($data['licencia'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Licencia modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$empleado->setLicencia($_FILES['licencia'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($empleado->updateRow($data['licencia'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['licencia'], $empleado->getRuta(), $empleado->getLicencia())) {
                        $result['message'] = 'Licencia modificado correctamente';
                    } else {
                        $result['message'] = 'Licencia modificado pero no se guardó la imagen';
                    }
                } elseif ($empleado->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.
            case 'delete':
                if (!$empleado->setId($_POST['id_empleado'])) {
                    $result['exception'] = 'Empleado incorrecta';
                } elseif (!$data = $empleado->readOne()) {
                    $result['exception'] = 'Empleado inexistente';
                } elseif ($empleado->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado eliminado correctamente';
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
