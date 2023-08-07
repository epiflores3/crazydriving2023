// Constante para acceder a la ruta de API.
const INSCRIPCION_API = 'business/privado/inscripcion.php';

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    //Se manda a llamar al metodo, para cargarlo 
    graficoPastelEvaluacionInscripcion();
});

//Se crea la función de que hará que la gráfica funcione 
async function graficoPastelEvaluacionInscripcion() {
    // Solicitar la informarcion del gráfico.
    const JSON = await dataFetch(INSCRIPCION_API, 'CantidadEvaluacionInscripcion');
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let evaluacion = [];
        let porcentaje = [];
        // Se recorre el conjunto de registro dato a dato a través row.
        JSON.dataset.forEach(row => {
            (row.evaluacion) ? eva = 'Evaluado' : eva = 'No evaluado';
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            evaluacion.push(eva);
            porcentaje.push(row.porcentaje);
        });
        // Llamada a la función que genera gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chartinscripcionevaluacion', evaluacion, porcentaje, 'Porcentaje de inscripciones por evaluación');
    } else {
        document.getElementById('chartinscripcionevaluacion').remove();
        console.log(JSON.exception);
    }
}


