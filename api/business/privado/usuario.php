<?php
require_once('../../entities/dto/usuario.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {
                //Se obtiene el alias del usuario y si existen, d elo contarrio mostrará un mensaje de error.
            case 'getUser':
                if (isset($_SESSION['alias_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
                //Acción de cerrar la sesión, contrario no se puede realizar dicha acción mostrará un mensaje de error.
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión cerrada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setFechaCracion($_POST['fechacreacion'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setEmpleado($_POST['idempleado'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->editProfile()) {
                    $result['status'] = 1;
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$usuario->setClave($_POST['nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se lee todos los datos que están almacenandos y lo que se agregarán posteriormente
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
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
                //Compruebo si existen empleados registrados anteriormente
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
                //Se simula los datos ocupandos en type en la base de datos, por medio de un array.
            case 'readEstadousu':
                $result['status'] = 1;
                $result['dataset'] = array(
                    array('Activo', 'Activo'),
                    array('Inactivo', 'Inactivo'),
                    array('Bloqueado', 'Bloqueado')
                );
                break;
                //Acción para poder buscar dentro de la interfaz
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    if ($result['dataset'] = $usuario->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    }
                } elseif ($_POST['search'] == 'alias') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
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
                } elseif (!isset($_POST['idempleado'])) {
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
                //Se comprueba que todos los datos estén correctos, de lo contarrio se mostrará mensaje de error, y si todo está correcto se pondrá realizar la acción de actualizar.
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                }
                if (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setClave($_POST['clave'])) {
                    $result['exception'] = 'Clave incorrecta';
                } elseif (!$usuario->setFechaCracion($_POST['fechacreacion'])) {
                    $result['exception'] = 'Fecha creacion incorrecta';
                } elseif (!$usuario->setIntentos($_POST['intentos'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif (!$usuario->setEstadousuario($_POST['estadousu'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!isset($_POST['idempleado'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$usuario->setEmpleado($_POST['idempleado'])) {
                    $result['exception'] = 'empleado incorrecta';
                } elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
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
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Se comprueba que el registro existe y si esta correcto, si todo es correcto se podrán eliminar el registro.    
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
                //Notificación para informar al usuario para poder ingresar debe iniciar sesión
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
                //Comprobar que los datos estén correctos para poder iniciar sesión
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
