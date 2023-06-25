// Constante para dirgirse a la ruta de API.
const HORARIOINCRIPCION_API = 'business/privado/horario_inscripcion.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const HORARIO_API = 'business/privado/horario.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const DETALLEINSCRIPCION_API = 'business/privado/detalle_inscripcion.php';
//Constante para cambiar el título de los modals
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const CMB_DETALLE = document.getElementById('detalleinscripcion');
// Constante para poder hacer uso del formulario de buscar dentro de un modal.
const SEARCH_MODAL_FORM_DETALLE = document.getElementById('searchmodalDetalle');
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');


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

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(HORARIOINCRIPCION_API, action, FORM);
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

//Método para poder hacer uso del combobox requerido. 
CMB_DETALLE.addEventListener('change', async () => {
    const info = document.getElementById('result1');
    info.textContent = '';
    //Constante para obtener el valor selecionado del combobox
    var ValorOpcion = CMB_DETALLE.options[CMB_DETALLE.selectedIndex].value;
    const FORM = new FormData();
    FORM.append('idhorarioinscripcion', ValorOpcion);
    const JSON = await dataFetch(DETALLEINSCRIPCION_API, 'readOne', FORM);
    if (JSON.status) {
        info.textContent =
            'Detalle inscripcion: ' + JSON.dataset.id_detalle_inscripcion + ' ' + 'Fecha de inicio: ' + JSON.dataset.fecha_inicio + ' ' + 'Dia: ' + JSON.dataset.dia + ' ' + 'Descripcion: ' + JSON.dataset.descripcion + ' ' + 'Nombre de empleado :' + JSON.dataset.nombre_com_empleado
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}
);

//PARA EL BUSCADOR DEL MODAL
SEARCH_MODAL_FORM_DETALLE.addEventListener('submit', async (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_MODAL_FORM_DETALLE);
    //Llena la tabla con las respuestas de la búsqueda.
    const JSON = await dataFetch(HORARIOINCRIPCION_API, 'searchModalDetalle', FORM);
    if (JSON.status) {
        // console.log(JSON.dataset.dui_cliente);
        fillSelect2(HORARIOINCRIPCION_API, 'cargarSelectDetalle', 'detalleinscripcion', JSON.dataset.dui_cliente);
    } else {
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreate() {
    SAVE_FORM.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE.textContent = 'Crear horario inscripción';
    fillSelect2(DETALLEINSCRIPCION_API, 'readAll', 'detalleinscripcion');
    fillSelect2(HORARIO_API, 'readAll', 'horario');
}

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    const JSON = await dataFetch(HORARIOINCRIPCION_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
        <tr>       
            <td>${row.id_detalle_inscripcion}</td>
            <td>${row.id_horario}</td>
            <td>
                <button onclick="openReport(${row.id_horario_inscripcion})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
        
                <button type="button" class="btn " onclick="openUpdate(${row.id_horario_inscripcion})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDelete(${row.id_horario_inscripcion})" class="btn"><img height="20px" width="20px"
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
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(HORARIOINCRIPCION_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE.textContent = 'Actualizar horario inscripción';
        // Se escriben los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_horario_inscripcion;
        fillSelect2(HORARIOINCRIPCION_API, 'cargarSelectDetalle', 'detalleinscripcion', JSON.dataset.dui_cliente, JSON.dataset.id_detalle_inscripcion);
        const info = document.getElementById('result1');
        info.textContent = '';
        const FORM2 = new FormData();
        FORM2.append('idhorarioinscripcion', JSON.dataset.id_detalle_inscripcion);
        const JSON2 = await dataFetch(DETALLEINSCRIPCION_API, 'readOne', FORM2);
        if (JSON2.status) {
            info.textContent =
                'Detalle inscripcion: ' + JSON2.dataset.id_detalle_inscripcion + ' ' + 'Fecha de inicio: ' + JSON2.dataset.fecha_inicio + ' ' + 'Dia: ' + JSON2.dataset.dia + ' ' + 'Descripcion: ' + JSON2.dataset.descripcion + ' ' + 'Nombre de empleado :' + JSON2.dataset.nombre_com_empleado
        } else {
            sweetAlert(2, JSON2.exception, false);
        }
        fillSelect2(HORARIO_API, 'readAll', 'horario', JSON.dataset.id_horario);
    } else {
        sweetAlert(2, JSON.exception, false);
    }

}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el horario de la inscripción de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('idhorarioiincripcion', id);
        const JSON = await dataFetch(HORARIOINCRIPCION_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}



