<?php
require_once('../../entities/dto/usuario.php');
require_once('../../entities/dto/empleado.php');

// Se comprueba si se cumplirá una acción, es decir, caso(case) a realizar, si no se llegará a cumplir ninguna acción se mostrará un mensaje de error.
if (isset($_GET['action'])) {
    // Se realiza una sesión o se sigue manejando la actual.
    session_start();
    // Se instancia una clase.
    $usuario = new Usuario;
    $empleado = new Empleado;
    // Se declara e inicializa un arreglo para guardar el resultado que se retorna.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null, 'password' => false);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acciones que el usuario puede realizar cuando ha iniciado sesión.
        switch ($_GET['action']) {

                //Se obtiene el alias del usuario y si existen, d elo contarrio mostrará un mensaje de error.
            case 'checkSessionTime':
                if (Validator::validateSessionTime()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión activa';
                } else {
                    $result['exception'] = 'Su sesión ha caducado';
                }
                break;

                //  case 'cheackSession':
                //    if (isset($_SESSION['id_usuario'])) {
                //         $result['status'] = 1;
                //        if($usuario->checkRenewPassword()){
                //            $result['status'] = 1;
                //            $result['message'] = 'Has llegado al límite, tienes que cambiar tu contraseña';
                //        }
                //          }else {
                //          $result['exception'] = 'id de usuario indefinido';
                //    }
                //      break;

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
                } elseif (!$usuario->setClave($_POST['nueva'], $_SESSION['alias_usuario'])) {
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

                // case 'sendmail':
                //     if (!$usuario->setCorreo($_POST['correo'])) {
                //         $result['exception'] = 'Correo incorrecto';
                //     }
                //     $mail = new PHPMailer(true);
                //     $mail->isSMTP();
                //     $mail->SMTPAuth = true;
                //     //to view proper logging details for success and error messages
                //     // $mail->SMTPDebug = 1;
                //     $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
                //     $mail->Username = 'enderchristianchiqui@gmail.com';   //email
                //     $mail->Password = 'upmuvkorsmjbqigr';   //16 character obtained from app password created
                //     $mail->Port = 465;                    //SMTP port
                //     $mail->SMTPSecure = "ssl";
                //     //sender information
                //     $mail->setFrom('enderchristianchiqui@gmail.com', 'Endernoob09');
                //     //receiver address and name
                //     $mail->addAddress($email, $recipient);
                //     $mail->isHTML(true);
                //     $mail->Subject = 'Codigo de recuperacion de contrasena';
                //     $mail->Body    = '<body style="background-color:#2B3547";>
                //             <br>
                //             <center><h3 style="color:white";>Su codigo para resetear su contraseña</h3></center>
                //             <div>
                //                 <b style = "color:white";>
                //                       Aqui se le presenta el codigode recuperacion de contraseña,
                //                     recuerde cambiarla cada cierto tiempo para evitar problemas de seguridad.
                //                 </b>
                //             </div>
                //             <br>
                //             <br>
                //             <center><h2 style="color:white">' . $code . '</h2></center>
                //             <br>
                //             <br>
                //             </body>
                //                 <p> De parte de Fencing a usted ' . $recipient . '</p>';
                //     // Send mail  
                //     if ($mail->send()) {
                //         if ($result['dataset'] = [$number, $armero->getCorreo()]) {
                //             $result['status'] = 1;
                //             $result['message'] = 'it worked!';
                //         }
                //     } else {
                //         $result['exception'] = 'it didnt work :(';
                //     }
                //     $mail->smtpClose();
                // break;

                //Se comprueba que todos los datos estén correcto, de lo contario mostrará mensajes de error, y si todo es correcto creará un nuevo registro.
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setClave($_POST['clave'], $_POST['alias'], $_POST['correo'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$usuario->setImagen($_FILES['imagen_usuario'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif (!$usuario->setFechaCracion($_POST['fechacreacion'])) {
                    $result['exception'] = 'Fecha creacion incorrecta';
                } elseif (!$usuario->setIntentos($_POST['intentos'])) {
                    $result['exception'] = 'Intentos incorrectos';
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
                //AGREGARLE EL POST DE CORREO Y DE LOS DATOS QUE NO QUEREMOS PARA QUE LA COTRASEÑA NO LO ACEPTE
                // case 'update':
                //     $_POST = Validator::validateForm($_POST);
                //     if (!$usuario->setId($_POST['id'])) {
                //         $result['exception'] = 'Usuario incorrecto';
                //     } elseif (!$data = $usuario->readOne()) {
                //         $result['exception'] = 'Usuario inexistente';
                //     }
                //     if (!$usuario->setCorreo($_POST['correo'])) {
                //         $result['exception'] = 'Correo incorrecto';
                //     } elseif (!$usuario->setAlias($_POST['alias'])) {
                //         $result['exception'] = 'Alias incorrecto';
                //     } elseif (!$usuario->setClave($_POST['clave'], $_POST['alias'])) {
                //         $result['exception'] = 'Clave incorrecta';
                //     } elseif (!$usuario->setFechaCracion($_POST['fechacreacion'])) {
                //         $result['exception'] = 'Fecha creacion incorrecta';
                //     } elseif (!$usuario->setIntentos($_POST['intentos'])) {
                //         $result['exception'] = Validator::getPasswordError();
                //     } elseif (!$usuario->setEstadousuario($_POST['estadousu'])) {
                //         $result['exception'] = 'Estado incorrecto';
                //     } elseif (!isset($_POST['idempleado'])) {
                //         $result['exception'] = 'Seleccione un empleado';
                //     } elseif (!$usuario->setEmpleado($_POST['idempleado'])) {
                //         $result['exception'] = 'empleado incorrecta';
                //     } elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
                //         $result['exception'] = 'Seleccione una imagen';
                //     } elseif (!is_uploaded_file($_FILES['imagen_usuario']['tmp_name'])) {
                //         if ($usuario->updateRow($data['imagen_usuario'])) {
                //             $result['status'] = 1;
                //             $result['message'] = 'Usuario modificado correctamente';
                //         } else {
                //             $result['exception'] = Database::getException();
                //         }
                //     } elseif (!$usuario->setImagen($_FILES['imagen_usuario'])) {
                //         $result['exception'] = Validator::getFileError();
                //     } elseif ($usuario->updateRow($data['imagen_usuario'])) {
                //         $result['status'] = 1;
                //         if (Validator::saveFile($_FILES['imagen_usuario'], $usuario->getRuta(), $usuario->getImagen())) {
                //             $result['message'] = 'Usuario modificado correctamente';
                //         } else {
                //             $result['message'] = 'Usuario modificado pero no se guardó la imagen';
                //         }
                //     } elseif ($usuario->updateRow()) {
                //         $result['status'] = 1;
                //         $result['message'] = 'Usuario modificado correctamente';
                //     } else {
                //         $result['exception'] = Database::getException();
                //     }
                //     break;

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

            case 'verificacioCodigoRecuperacion':
                // Se realiza una validación y limpieza de los datos del formulario POST
                $_POST = Validator::validateForm($_POST);
                if (!isset($_SESSION['id_usuario_logOut'])) {
                    // Si no existe una sesión de usuario, se establece un mensaje de excepción
                    $result['exception'] = 'Debe autenticarse para cambiar la contraseña';
                } elseif (!$usuario->setId($_SESSION['id_usuario_logOut'])) {
                    // Si no se puede establecer el ID de usuario basado en la sesión, se establece un mensaje de excepción
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($_SESSION['codigo_recuperacion'] == $_POST['verificarcodigo']) {
                    $result['status'] = 1;
                    $result['message'] = 'Codigo de verificacion correcto';
                    // $_SESSION['alias_usuario'] = $usuario->getCorreo_Usuario();
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Código incorrecto';
                    }
                }
                break;
            case 'checkRecovery':
                $_POST = Validator::validateForm($_POST);
                // Validar la dirección de correo electrónico
                if (!$usuario->setCorreo($_POST['correo_usuario'])) {
                    $result['exception'] = 'Correo incorrecto';
                }
                // Validar el alias de usuario
                // elseif (!$usuario->setAlias($_POST['alias'])) {
                //     $result['exception'] = 'Alias incorrecto';
                // }
                // Crear el primer usuario en la base de datos
                elseif ($usuario->checkRecovery($_POST['correo_usuario'])) {
                    // Si el cambio de contraseña es exitoso según el método changePasswordExpiracion, se establece el estado como exitoso y se muestra un mensaje de éxito
                    $result['status'] = 1;
                    $_SESSION['id_usuario_logOut'] = $usuario->getId();
                    $_SESSION['codigo_recuperacion'] = $usuario->getCodigoRecuperacion();
                    $result['exception'] = 'Código enviado correctamente';
                } else {
                    if (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Datos Incorrectos';
                    }
                }
                break;

            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$empleado->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre del empleado incorrecto';
                } elseif (!$empleado->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI del empleado incorrecto';
                } elseif (!$empleado->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono del empleado incorrecto';
                } elseif (!$empleado->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento del empleado incorrecto';
                } elseif (!$empleado->setDireccion($_POST['direccion'])) {
                    $result['exception'] = 'Dirección del empleado incorrecto';
                } elseif (!($empleado->setCorreo($_POST['correo']) and $usuario->setCorreo($_POST['correo']))) {
                    $result['exception'] = 'Correo del empleado incorrecto';
                } elseif (!$empleado->setAFP($_POST['afp_primer'])) {
                    $result['exception'] = 'Nombre de afp del empleado incorrecto';
                } elseif (!$empleado->setRol($_POST['rol_primer'])) {
                    $result['exception'] = 'Rol del empleado incorrecto';
                } elseif (!$empleado->setSucursal($_POST['sucursal_primer'])) {
                    $result['exception'] = 'Sucursal del empleado incorrecta';
                } elseif (!$usuario->setAlias($_POST['ali_primer'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setClave($_POST['contra_primer'], $_POST['ali_primer'], $_POST['correo'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($_POST['rescon_primer'] != $_POST['contra_primer']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$empleado->setEstado(1)) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$empleado->createRow()) {
                    $result['status'] = 1;
                } elseif ($usuario->createFirstUse()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                //Comprobar que los datos estén correctos para poder iniciar sesión
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['nombre'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->checkEstado($_POST['nombre'])) {
                    $result['exception'] = 'Estado bloqueado';
                } elseif (!$usuario->checkPassword($_POST['contra'])) {
                    $result['exception'] = 'Clave incorrecta';
                } elseif ($usuario->checkRenewPassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['tiempo_sesion'] = time();
                    $_SESSION['id_usuario'] = $usuario->getId();
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                } else {
                    $_SESSION['id_usuario_password'] = $usuario->getId();
                    $result['password'] = true;
                    $result['exception'] = 'Tu contraseña a caducado';
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
