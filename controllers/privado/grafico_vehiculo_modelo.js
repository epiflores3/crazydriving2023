// Constante para acceder a la ruta de API.
const VEHICULO_API = 'business/privado/vehiculo.php';

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
  //Se manda a llamar al metodo, para cargarlo 
  graficoBarrasVehiculos();
});

//Se crea la función de que hará que la gráfica funcione 
async function graficoBarrasVehiculos() {
    // Solicitar la informarcion del gráfico.
    const JSON = await dataFetch(VEHICULO_API, 'Cantidadvehiculopormodelo');
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let modelo = [];
        let cantidad = [];
        // Se recorre el conjunto de registro dato a dato a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            modelo.push(row.modelo);
            cantidad.push(row.cantidad);
        });
        // Llamada a la función que genera gráfico de bsrrs. Se encuentra en el archivo components.js
        barGraph('chartVM', modelo, cantidad, 'Cantidad de vehiculo', 'Top 5 de modelos con más vehículos');
    } else {
        document.getElementById('chartVM').remove();
        console.log(JSON.exception);
    }
}