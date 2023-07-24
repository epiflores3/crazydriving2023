// Constante para acceder a la ruta de API.
const CLIENTE_API = 'business/privado/cliente.php';

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    //Se manda a llamar al metodo, para cargarlo 
    graficoPastelEstadoCliente();
});

//Se crea la función de que hará que la gráfica funcione 
async function graficoPastelEstadoCliente() {
    // Solicitar la informarcion del gráfico.
    const JSON = await dataFetch(CLIENTE_API, 'cantidadEstadoCliente');
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let estado = [];
        let porcentaje = [];
        // Se recorre el conjunto de registro dato a dato a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            estado.push(row.estado_cliente);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chartestadocliente', estado, porcentaje, 'Porcentaje de clientes por estado');
    } else {
        document.getElementById('chartestadocliente').remove();
        console.log(JSON.exception);
    }
}


