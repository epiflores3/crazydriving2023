<?php
require_once('../../entities/dto/usuario.php');
//require_once('../../entities/dto/usuario.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
             /*AUN NO */
            case 'getUser':
                if (isset($_SESSION['alias_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
                
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;


                 /*AUN NO */
            // case 'readProfile':
            //     if ($result['dataset'] = $usuario->readProfile()) {
            //         $result['status'] = 1;
            //     } elseif (Database::getException()) {
            //         $result['exception'] = Database::getException();
            //     } else {
            //         $result['exception'] = 'Usuario inexistente';
            //     }
            //     break;
                 /*AUN NO */
            // case 'editProfile':
            //     $_POST = Validator::validateForm($_POST);
            //     if (!$usuario->setNombres($_POST['nombres'])) {
            //         $result['exception'] = 'Nombres incorrectos';
            //     } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
            //         $result['exception'] = 'Apellidos incorrectos';
            //     } elseif (!$usuario->setCorreo($_POST['correo'])) {
            //         $result['exception'] = 'Correo incorrecto';
            //     } elseif (!$usuario->setAlias($_POST['alias'])) {
            //         $result['exception'] = 'Alias incorrecto';
            //     } elseif ($usuario->editProfile()) {
            //         $result['status'] = 1;
            //         $_SESSION['alias_usuario'] = $usuario->getAlias();
            //         $result['message'] = 'Perfil modificado correctamente';
            //     } else {
            //         $result['exception'] = Database::getException();
            //     }
            //     break;
                 /*AUN NO */
            // case 'changePassword':
            //     $_POST = Validator::validateForm($_POST);
            //     if (!$usuario->setId($_SESSION['id_usuario'])) {
            //         $result['exception'] = 'Usuario incorrecto';
            //     } elseif (!$usuario->checkPassword($_POST['actual'])) {
            //         $result['exception'] = 'Clave actual incorrecta';
            //     } elseif ($_POST['nueva'] != $_POST['confirmar']) {
            //         $result['exception'] = 'Claves nuevas diferentes';
            //     } elseif (!$usuario->setClave($_POST['nueva'])) {
            //         $result['exception'] = Validator::getPasswordError();
            //     } elseif ($usuario->changePassword()) {
            //         $result['status'] = 1;
            //         $result['message'] = 'Contraseña cambiada correctamente';
            //     } else {
            //         $result['exception'] = Database::getException();
            //     }
            // break;

                
            
            
                case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
             break;
        
             case 'readOne':
                    if (!$usuario->setId($_POST['id_usuario'])) {
                        $result['exception'] = 'Usuario incorrecto';
                    } elseif ($result['dataset'] = $usuario->readOne()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Usuario inexistente';
                    }
            break;

            case 'readEmpleado':
                if ($result['dataset'] = $usuario->readEmpleado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            
                case 'readEstadousu':
                       $result['status'] =1;
                       $result['dataset'] =array (
                       array ('Activo', 'Activo'), 
                       array ('Inactivo', 'Inactivo'), 
                       array ('Bloqueado', 'Bloqueado') 
                       );
                    break;

            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
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
                if (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';

                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';

                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecta';

                } elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';

                } elseif (!$usuario->setImagen($_FILES['imagen_usuario'])) {
                    $result['exception'] = Validator::getFileError();

                } elseif (!$usuario->setFechaCracion($_POST['fechacreacion'])) {
                    $result['exception'] = 'Fecha creacion incorrecta';

                } elseif (!$usuario->setIntentos($_POST['intentos'])) {
                    $result['exception'] = Validator::getPasswordError();

                } elseif (!$usuario->setEstadousuario($_POST['estadousu'])) {
                    $result['exception'] = 'Estado incorrecto';

                }elseif (!isset($_POST['idempleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$usuario->setEmpleado($_POST['idempleado'])) {
                    $result['exception'] = 'empleado incorrecta';
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imagen_usuario'], $usuario->getRuta(), $usuario->getImagen())) {
                        $result['message'] = 'Usuario creado correctamente';
                    } else {
                        $result['message'] = 'Usuario creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                 
                 
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';

                } elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';

                }if (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';

                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';

                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecta';

                } elseif (!$usuario->setFechaCracion($_POST['fechacreacion'])) {
                    $result['exception'] = 'Fecha creacion incorrecta';


                }  elseif (!$usuario->setIntentos($_POST['intentos'])) {
                    $result['exception'] = Validator::getPasswordError();

                } elseif (!$usuario->setEstadousuario($_POST['estadousu'])) {
                    $result['exception'] = 'Estado incorrecto';

                }elseif (!isset($_POST['idempleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$usuario->setEmpleado($_POST['idempleado'])) {
                    $result['exception'] = 'empleado incorrecta';

                } elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } 

                elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
                    if ($usuario->updateRow($data['imagen_usuario'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$usuario->setImagen($_FILES['imagen_usuario'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($usuario->updateRow($data['imagen_usuario'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imagen_usuario'], $usuario->getRuta(), $usuario->getImagen())) {
                        $result['message'] = 'Usuario modificado correctamente';
                    } else {
                        $result['message'] = 'Usuario modificado pero no se guardó la imagen';
                    } 
                }
                elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;


                 /*AUN NO */
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
                
                 /*AUN NO */
            // case 'signup':
            //     $_POST = Validator::validateForm($_POST);
            //     if (!$usuario->setNombres($_POST['nombres'])) {
            //         $result['exception'] = 'Nombres incorrectos';
            //     } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
            //         $result['exception'] = 'Apellidos incorrectos';
            //     } elseif (!$usuario->setCorreo($_POST['correo'])) {
            //         $result['exception'] = 'Correo incorrecto';
            //     } elseif (!$usuario->setAlias($_POST['usuario'])) {
            //         $result['exception'] = 'Alias incorrecto';
            //     } elseif ($_POST['codigo'] != $_POST['confirmar']) {
            //         $result['exception'] = 'Claves diferentes';
            //     } elseif (!$usuario->setClave($_POST['codigo'])) {
            //         $result['exception'] = Validator::getPasswordError();
            //     } elseif ($usuario->createRow()) {
            //         $result['status'] = 1;
            //         $result['message'] = 'Usuario registrado correctamente';
            //     } else {
            //         $result['exception'] = Database::getException();
            //     }
            //     break;
                
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['nombre'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->checkPassword($_POST['contra'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_usuario'] = $usuario->getId();
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                } else {
                    $result['exception'] = 'Clave incorrecta';
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