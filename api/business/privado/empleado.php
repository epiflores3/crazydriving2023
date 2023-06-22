<?php
require_once('../../entities/dto/empleado.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $empleado = new Empleado;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
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
                case 'search':
                    $_POST = Validator::validateForm($_POST);
                    if ($_POST['search'] == '') {
                        if ($result['dataset'] = $empleado->readAll()) {
                            $result['status'] = 1;
                            $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                        }
                    }
                    elseif ($_POST['search'] == 'alias') {
                        $result['exception'] = 'Ingrese un valor para buscar';
                    } elseif ($result['dataset'] = $empleado->searchRows($_POST['search'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'No hay coincidencias';
                    }
                    break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$empleado->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del empleado incorrecto';
                } elseif (!$empleado->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI del empleado incorrecto';
                } 
                
                
                elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';

                } elseif (!$empleado->setLicencia($_FILES['licencia'])) {
                    $result['exception'] = Validator::getFileError();

                }
                
                
                
                
                
                
                elseif (!$empleado->setTelefono($_POST['telefono'])) {
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
                } 

                elseif (!$empleado->setTelefono($_POST['telefono'])) {
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
                } 
                elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } 

                elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } 

                elseif (!is_uploaded_file($_FILES['licencia']['tmp_name'])) {
                    if ($empleado->updateRow($data['licencia'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Licencia modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$licencia->setLicencia($_FILES['licencia'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($licencia->updateRow($data['licencia'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['licencia'], $empleado->getRuta(), $empleado->getLicencia())) {
                        $result['message'] = 'Licencia modificado correctamente';
                    } else {
                        $result['message'] = 'Licencia modificado pero no se guardó la imagen';
                    } 
                }
                
                elseif ($empleado->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
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
