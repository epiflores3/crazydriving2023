// Constante para dirgirse a la ruta de API.
const DETALLEINSCRIPCION_API = 'business/privado/detalle_inscripcion.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const PAQUETE_API = 'business/privado/paquete.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const EMPLEADO_API = 'business/privado/empleado.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const INSCRIPCION_API = 'business/privado/inscripcion.php';
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');
//Constante para cambiar el título de los modals
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
const SEARCH_INPUT = document.getElementById('search');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTable();
});

// Método que se utiliza para el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);

    //Llena la tabla con las respuestas de la búsqueda.
    fillTable(FORM);

});

// async function validarInscripcion(){
//     const JSONVALIDAR = await dataFetch(DETALLEINSCRIPCION_API, 'BuscarInscripcion', FORM);

// }

// Método que se utiliza para el formulario de buscar.
SEARCH_INPUT.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        event.preventDefault();
        const FORM = new FormData(SEARCH_FORM);
        //Llena la tabla con las respuestas de la búsqueda.
        fillTable(FORM);
    }
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(DETALLEINSCRIPCION_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.hide();
        // Se carga la tabla para ver los cambios.
        fillTable();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreate() {
    SAVE_FORM.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE.textContent = 'Crear detalle inscripción';
    fillSelect2(INSCRIPCION_API, 'readAll', 'inscripcion');
    fillSelect(PAQUETE_API, 'readAll', 'paquete');
    fillSelect(EMPLEADO_API, 'readAll', 'empleado');
}


//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    /// Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(DETALLEINSCRIPCION_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
        <tr>
            <td>${row.fecha_inicio}</td>
            <td>${row.dia}</td>
            <td>${row.descripcion}</td>
            <td>${row.id_inscripcion}</td>
            <td>${row.nombre_com_empleado}</td>
            <td>
                <button onclick="openReport(${row.id_detalle_inscripcion})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
                <button type="button" class="btn " onclick="openUpdate(${row.id_detalle_inscripcion})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
                <button onclick="openDelete(${row.id_detalle_inscripcion})" class="btn"><img height="20px" width="20px"
                        src="../../resource/img/imgtablas/delete.png" alt="eliminar">
                </button>
            </td>
        </tr>
        `;
        });
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_detalle_inscripcion', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(DETALLEINSCRIPCION_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se escriben los campos del formulario.
        MODAL_TITLE.textContent = 'Actualizar detalle inscripción';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_detalle_inscripcion;
        document.getElementById('fechaini').value = JSON.dataset.fecha_inicio;
        document.getElementById('dia').value = JSON.dataset.dia;
        fillSelect2(INSCRIPCION_API, 'readAll', 'inscripcion', JSON.dataset.id_inscripcion);
        fillSelect(PAQUETE_API, 'readAll', 'paquete', JSON.dataset.id_paquete);
        fillSelect(EMPLEADO_API, 'readAll', 'empleado', JSON.dataset.id_empleado);

        ;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}


//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el detalle de la inscripción de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_detalle_inscripcion', id);
        // Petición para realizar el proceso de eliminar del registro seleccionado.
        const JSON = await dataFetch(DETALLEINSCRIPCION_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTable();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}