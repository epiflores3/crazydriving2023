const SAVE_FORM = document.getElementById("recu-form");
const SAVE_FORM_VALIDARDATOS = document.getElementById("verificarcodigo-form");
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
    if (JSON.status) {
      //mensaje si todo fue correcto
      sweetAlert(1, JSON.exception, true);

    } else {
      //problema mensaje 
      sweetAlert(2, JSON.exception, false);
    }
  }

  // // Enviar los datos del formulario al servidor
  // var params = 'alias=' + encodeURIComponent(alias) + 'correo_usuario=' + encodeURIComponent(correo);
  // xhr.send(params);
});


// Obtener el campo de teléfono por su ID
var codigo = document.getElementById('verificarcodigo');
// Obtener todos los elementos de entrada con la clase "input-fields"
var inputFields = document.querySelectorAll('.input-code');
// Agregar un evento de escucha al último campo de entrada para actualizar el campo de teléfono
inputFields[inputFields.length - 1].addEventListener('input', function () {
  // Crear una cadena vacía para almacenar el número de teléfono completo
  var codigocompleto = '';

  // Recorrer los campos de entrada y concatenar sus valores
  inputFields.forEach(function (input) {
    codigocompleto += input.value;
  });

  // Insertar el número de teléfono completo en el campo "telefono_usuario"
  codigo.value = codigocompleto;
});


SAVE_FORM_VALIDARDATOS.addEventListener('submit', async (event) => {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  // Constante tipo objeto con los datos del formulario.
  const FORM = new FormData(SAVE_FORM_VALIDARDATOS);
  // Petición para guardar los datos del formulario.
  const JSON = await dataFetch(USER_API, 'verificacioCodigoRecuperacion', FORM);
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
      sweetAlert(1, JSON.message, true, 'restaurar_contra_codigo.html');//aqui el html de cambiar contra

    } else {
      //problema mensaje 
      sweetAlert(2, JSON.exception, false);
    }
  }
});


// // Asociar la función sendEmail al evento submit del formulario
// document.getElementById('recu-form').addEventListener('submit', function (event) {
//   event.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
//   sendEmail();
// });