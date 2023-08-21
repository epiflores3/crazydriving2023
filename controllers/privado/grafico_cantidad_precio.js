// Constante para acceder a la ruta de API.
const PAQUETE_API = 'business/privado/paquete.php';
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');
//Constante de textos para validaciones
const INCORRECT_TEXT = document.getElementById('alerta_incorrecto');
const CORRECT_TEXT = document.getElementById('alerta_correcto');
//Constantes para manejar los campos del gráfico
const PRECIO1 = document.getElementById("precio_incial");
const PRECIO2 = document.getElementById("precio_final");


//Método que se ejecuta al cargar la página
document.addEventListener('DOMContentLoaded', () => {
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    // Evita cargar la pagina despues de enviar el formulario
    event.preventDefault();
    validadoRangoDeDinero();
    // Se declara una constante de tipo FORM.
    const FORM = new FormData(SAVE_FORM);
    // Pide guardar los datos del formulario
    const JSON = await dataFetch(PAQUETE_API, 'cantidadPaquetePrecio', FORM);
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let valor = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            valor.push(row.valor_paquete);
            cantidad.push(row.cantidad);
        });
        document.getElementById('grafico').innerHTML = '<canvas id="chart2"></canvas>';
        // Llamada a la función que genera gráfico linrsl. Se encuentra en el archivo components.js
        barGraph('chart2', valor, cantidad, 'Cantidad de paquetes', 'Top 5 de paquetes más solicitados');
        sweetAlert(1, JSON.message, true);

    } else {
        sweetAlert(2, JSON.exception, false);
        document.getElementById('chart2').remove();
    }
});



// ----------------------------------------- VALIDACIONES ----------------------------------------------

function validadoRangoDeDinero(){
    var precio1 = parseInt(PRECIO1.value);
    var precio2 = parseInt(PRECIO2.value);
if (precio1>=precio2) {
    INCORRECT_TEXT.innerHTML = `<span class="alerta_incorrecto">Rango no valido, escribe correctamente, la fecha inicial no puede ser mayor o igual a la fecha final</span>`;
    CORRECT_TEXT.innerHTML = ``;
} else {
    INCORRECT_TEXT.innerHTML = ``;
    CORRECT_TEXT.innerHTML = `<span class="alerta_correcto">Texto agregado correctamente</span>`;
}
};

