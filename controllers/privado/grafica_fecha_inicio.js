// Constante para acceder a la ruta de API.
const INSCRIPCION_API = 'business/privado/inscripcion.php';
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');



//Método que se ejecuta al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    desHabilitarBotonCamposEnBlanco();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    // Evita cargar la pagina despues de enviar el formulario
    event.preventDefault();
    // Se declara una constante de tipo FORM.
    const FORM = new FormData(SAVE_FORM);
    // Pide guardar los datos del formulario
    const JSON = await dataFetch(INSCRIPCION_API, 'cantidadDeFechasInicio', FORM);
    // Se comprueba si hay una respuesta a lo solicitado, sino se quita la etiqueta canvas.
    if (JSON.status) {
        // Se declaran los arreglos para guardar la información y luego graficarlos.
        let fechas = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila a fila a través row.
        JSON.dataset.forEach(row => {
            // Se agregan los datos a los arreglos, que tienen que ir como están en la base.
            fechas.push(row.fecha_inicio);
            cantidad.push(row.cantidad);
        });
        document.getElementById('grafico').innerHTML = '<canvas id="chart2"></canvas>';
        // Llamada a la función que genera gráfico linrsl. Se encuentra en el archivo components.js
        lineGraph('chart2', fechas, cantidad, 'Cantidad de estudiantes', 'Top 5 de fechas con más estudiantes iniciados');
        sweetAlert(1, JSON.message, true);

    } else {
        sweetAlert(2, JSON.exception, false);
        document.getElementById('chart2').remove();
    }
});




const fecha1 = document.getElementById("fecha_inicial");
const fecha2 = document.getElementById("fecha_final");




function desHabilitarBotonCamposEnBlanco(){
 text_1 = document.getElementById("fecha_inicial").value;
 text_2= document.getElementById("fecha_final").value;
 val = 0;
 if(text_1 == "" ){
    val++;
 }if(text_2 == ""){
    val++;
 }if(val == 0){
    document.getElementById("enviardatos").disabled = false;
 }else{
    document.getElementById("enviardatos").disabled = true;
}
};
// Trae el valor en tiempo real de los text que ya no estan vacios y hace que se habilite el boton
document.getElementById("fecha_inicial").addEventListener("keyup", desHabilitarBotonCamposEnBlanco);
document.getElementById("fecha_final").addEventListener("keyup", desHabilitarBotonCamposEnBlanco);

//Trae lo que escribiste en tiempo real todo junto
fecha1.addEventListener('keyup', (event)=>{
// console.log(event); Te muestra lo que se ha escrito dijito por dijito}
const texto1 = event.target.value;
// console.log(texto1); Muestra en consola el valor
mostrarValoresEnTiempoReal(texto1, fecha2.value);
});

//Trae lo que escribiste en tiempo real todo junto
fecha2.addEventListener('keyup', (event) =>{
    const texto2 = event.target.value;
    // console.log(text2);  Muestra en consola el valor
    mostrarValoresEnTiempoReal(fecha1.value, texto2);
});

  // Toma los valores de cada date y los manda a evaluar al metodo de
function mostrarValoresEnTiempoReal(texto1, texto2) {
    validarFechas(texto1, texto2);
};

// Valida que lo que se capture de los date sea en su formato correcto
function validarFechas(texto1, texto2) {
    if (texto1 >= texto2) { 
        console.log("La fecha inicial es mayor a la Fecha final");
        document.getElementById("enviardatos").disabled = true;
    }
    else{
    console.log("Texto agregado correctamente");
    }
};



