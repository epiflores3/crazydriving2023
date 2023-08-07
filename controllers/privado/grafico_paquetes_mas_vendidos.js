
const INSCRI_API = 'business/privado/inscripcion.php';

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    //Se manda a llamar al metodo, para cargarlo 
    graficoDonaPaquetesMasVendidos();
});

//Se crea la función de que hará que la gráfica funcione 
async function graficoDonaPaquetesMasVendidos() {
    // Solicitar la informarcion del gráfico.
    const JSON = await dataFetch(INSCRI_API, 'cantidadPaquetesMasVendidos');
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let valor = [];
        let porcentaje = [];
        // Se recorre el conjunto de registro dato a dato a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            valor.push(row.valor_paquete);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera gráfico de pastel. Se encuentra en el archivo components.js
        doughnutGraph('chartPaquetesMasVendidos', valor, porcentaje, 'Porcentaje de paquetes mas vendidos');
    } else {
        document.getElementById('chartPaquetesMasVendidos').remove();
        console.log(JSON.exception);
    }
}


