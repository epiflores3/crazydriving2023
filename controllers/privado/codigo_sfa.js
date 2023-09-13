const SAVE_FORM_AUTENTIFICACION = document.getElementById("verificarcodigo-form");

document.addEventListener('DOMContentLoaded', async () => {
  // Petición para consultar los usuarios registrados.
  const JSON = await dataFetch(USER_API, 'readUsers');
  // const JSON2 = await dataFetch(USER_API, 'cheackSession');
  // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
  if (JSON.session) {
    // Se direcciona a la página web de bienvenida.
    location.href = 'pagina_principal.html';
  }
});

SAVE_FORM_AUTENTIFICACION.addEventListener('submit', async (event) => {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Constante tipo objeto con los datos del formulario.
  const FORM = new FormData(SAVE_FORM_AUTENTIFICACION);
  // Petición para guardar los datos del formulario.
  const JSON = await dataFetch(USER_API, 'sfa', FORM);
  //si no a inisiado sesion
  if (JSON.status) {
    //mensaje si todo fue correcto cambio de contraseña
    sweetAlert(1, JSON.message, true, 'pagina_principal.html');//aqui el html de cambiar contra
  } else {
    //problema mensaje 
    sweetAlert(2, JSON.exception, false);
  }
});
