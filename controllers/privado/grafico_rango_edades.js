// Constante para acceder a la ruta de API.
const CLIENTE_API = 'business/privado/cliente.php';
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');
//Constante de textos para validaciones
const INCORRECT_TEXT = document.getElementById('alerta_incorrecto');
const CORRECT_TEXT = document.getElementById('alerta_correcto');
//Constantes para manejar los campos del gráfico
// const ANIO1 = document.getElementById("anios_inicial");
// const ANIO2 = document.getElementById("anios_final");


//Método que se ejecuta al cargar la página
document.addEventListener('DOMContentLoaded', () => {

});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    // Evita cargar la pagina despues de enviar el formulario
    event.preventDefault();
    validarFechas();
    // Se declara una constante de tipo FORM.
    const FORM = new FormData(SAVE_FORM);
    // Pide guardar los datos del formulario
    const JSON = await dataFetch(CLIENTE_API, 'cantidadClienteEdades', FORM);
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let anios = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            anios.push(row.nacimiento);
            cantidad.push(row.cantidad);
        });
        document.getElementById('grafico').innerHTML = '<canvas id="chart2"></canvas>';
        // Llamada a la función que genera gráfico linrsl. Se encuentra en el archivo components.js
        lineGraph('chart2', anios, cantidad, 'Cantidad de clientes', 'TOP 5 de años de nacimiento con más clientes');
        sweetAlert(1, JSON.message, true);

    } else {
        sweetAlert(2, JSON.exception, false);
        document.getElementById('chart2').remove();
    }
});


// ----------------------------------------- VALIDACIONES ----------------------------------------------

function validarFechas(){
    var anio1 = new Date(document.getElementById("anios_inicial").value);
    var anio2 = new Date(document.getElementById("anios_final").value);
      
    if (anio1.getFullYear()>anio2.getFullYear()) {
        INCORRECT_TEXT.innerHTML = `<span class="alerta_incorrecto">Rango no valido, escribe correctamente, la fecha inicial no puede ser mayor o igual a la fecha final</span>`;
        CORRECT_TEXT.innerHTML = ``;
    } else {
        INCORRECT_TEXT.innerHTML = ``;
        CORRECT_TEXT.innerHTML = `<span class="alerta_correcto">Texto agregado correctamente</span>`; 
    }

};



