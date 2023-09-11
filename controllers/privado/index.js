const LOGIN = document.getElementById('login');

document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const JSON = await dataFetch(USER_API, 'readUsers');
    // const JSON2 = await dataFetch(USER_API, 'cheackSession');
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (JSON.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'pagina_principal.html';

        // if(JSON2.session){
        //     window.location.href = "editar_perfil.html#agregar";
        // }

    } else if (JSON.status) {
        // Se muestra el formulario para iniciar sesión.
        /*document.getElementById('login-container').classList.remove('hide');*/
        sweetAlert(4, JSON.message, true);
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        //document.getElementById('signup-container').classList.remove('hide');
        sweetAlert(4, JSON.exception, true);
    }
});

LOGIN.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(LOGIN);
    // Petición para iniciar sesión.
    const JSON = await dataFetch(USER_API, 'login', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'pagina_principal.html');
    } else {
        if (JSON.password) {
            sweetAlert(2, JSON.exception, false, 'cuchao.html');
        } else {
            sweetAlert(2, JSON.exception, false);
        }

    }
});