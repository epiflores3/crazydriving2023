const SAVE_FORM = document.getElementById("recu-form");
// Guardar el código generado en una variable

// Verificar el código generado
SAVE_FORM.addEventListener('submit', async (event) => {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Constante tipo objeto con los datos del formulario.
  const FORM = new FormData(SAVE_FORM);
  // Petición para guardar los datos del formulario.
  const JSON = await dataFetch(USER_API, 'checkRecovery', FORM);
  if (JSON.session) {
    // Crear un objeto XMLHttpRequest para enviar la solicitud al servidor
    location.href = 'index.html';
    // Definir la función de callback para manejar la respuesta del servidor
  } else {
    if(JSON.status){
      //mensaje si todo fue correcto
      sweetAlert(1, JSON.exception, true);
      
    }else{
      //problema mensaje 
      sweetAlert(2, JSON.exception, false);
    }
  }

  // // Enviar los datos del formulario al servidor
  // var params = 'alias=' + encodeURIComponent(alias) + 'correo_usuario=' + encodeURIComponent(correo);
  // xhr.send(params);
});

// // Asociar la función sendEmail al evento submit del formulario
// document.getElementById('recu-form').addEventListener('submit', function (event) {
//   event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
//   sendEmail();
// });