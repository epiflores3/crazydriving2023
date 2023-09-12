const SAVE_FORM_AUTENTIFICACION = document.getElementById("verificarcodigo-form");

SAVE_FORM_AUTENTIFICACION.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM_AUTENTIFICACION);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(USER_API, 'sfa', FORM);
    //si a iniciado secion se va al login
    if (JSON.session) {
      // Crear un objeto XMLHttpRequest para enviar la solicitud al servidor
      location.href = 'index.html';//ENVIAR AL dashobard 
      // sweetAlert(1, 'Sesion Inisiada redireccion al dashboard', true);
      // Definir la función de callback para manejar la respuesta del servidor
    } else {
      //si no a inisiado sesion
      if (JSON.status) {
        //mensaje si todo fue correcto cambio de contraseña
        sweetAlert(1, JSON.message, true, 'pagina_principal.html');//aqui el html de cambiar contra
      } else {
        //problema mensaje 
        sweetAlert(2, JSON.exception, false);
      }
    }
  });
  