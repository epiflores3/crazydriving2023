
const USUARIO_API = 'business/privado/usuario.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const ROL1_API = 'business/privado/roles.php';
const SUCURSAL1_API = 'business/privado/sucursal.php';
const AFP1_API = 'business/privado/afp.php';

// Constante para establecer el formulario de registrar cliente.
const SIGNUP_FORM = document.getElementById('first-use');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async() => {

   const JSON = await dataFetch(USUARIO_API, 'readUsers');
   if (JSON.session) {
    location.href = 'pagina_principal.html';
   }else if (JSON.status){
    sweetAlert(3, 'Ya existe almenos un usuario registrado', false, 'index.html');
   }else{
    fillSelect(AFP1_API, 'readAll', 'afp_primer');
    fillSelect(ROL1_API, 'readAll', 'rol_primer');
    fillSelect(SUCURSAL1_API, 'readAll', 'sucursal_primer');
   }

    // fillSelect(AFP1_API, 'readAll', 'afp_primer');
    // fillSelect(ROL1_API, 'readAll', 'rol_primer');
    // fillSelect(SUCURSAL1_API, 'readAll', 'sucursal_primer');
   
});

// Método manejador de eventos para cuando se envía el formulario de registrar cliente.
SIGNUP_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar un cliente.
    const JSON = await dataFetch(USER_API, 'signup', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'index.html');
    } else if (JSON.recaptcha) {
        sweetAlert(2, JSON.exception, false, 'pagina_principal.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});





