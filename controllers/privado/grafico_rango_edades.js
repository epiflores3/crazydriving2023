// Constante para acceder a la ruta de API.
const CLIENTE_API = 'business/privado/cliente.php';
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');



//Método que se ejecuta al cargar la página
document.addEventListener('DOMContentLoaded', () => {

});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    // Evita cargar la pagina despues de enviar el formulario
    event.preventDefault();
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
