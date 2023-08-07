// Constante para acceder a la ruta de API.
const PAQUETE_API = 'business/privado/paquete.php';

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    //Se manda a llamar al metodo, para cargarlo 
    graficoPastelPaqueteTransmision();
});

//Se crea la función de que hará que la gráfica funcione 
async function graficoPastelPaqueteTransmision() {
    // Solicitar la informarcion del gráfico.
    const JSON = await dataFetch(PAQUETE_API, 'CantidadPaquetesPorTransmision');
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let transmision = [];
        let porcentaje = [];
        // Se recorre el conjunto de registro dato a dato a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            transmision.push(row.transmision);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chartpaquetetransmision', transmision, porcentaje, 'Porcentaje de paquetes por transmisiones');
    } else {
        document.getElementById('chartpaquetetransmision').remove();
        console.log(JSON.exception);
    }
}


