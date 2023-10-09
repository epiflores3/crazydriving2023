// Constante para dirgirse a la ruta de API.
const PAQUETE_API = 'business/privado/paquete.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const TIPOPAQUETE_API = 'business/privado/tipo_paquete.php'
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarPaquete'));
//Constante para poder guardar los datos del formulario
const SAVE_FORM_PAQUETE= document.getElementById('save-form-paquete');
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
    fillSelect(PAQUETE_API, 'getTransmision', 'transmisionr');
});

// Método que se utiliza para el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTable(FORM);
});

document.getElementById('transmisionr').addEventListener('change', () => {
     
    const PATH = new URL(`${SERVER_URL}report/privado/transmision_paquete.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('transmision',  document.getElementById('transmisionr').value);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
});

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
SAVE_FORM_PAQUETE.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_paquete').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_PAQUETE);
    const JSON = await dataFetch(PAQUETE_API, action, FORM);
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
    SAVE_FORM_PAQUETE.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE.textContent = 'Crear paquete';
    fillSelect(TIPOPAQUETE_API, 'readAll', 'tipo_paquete_tp');
    fillSelect(PAQUETE_API, 'getTransmision', 'transmision_paquete');
}


//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(PAQUETE_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
        <tr>
            <td>${row.descripcion}</td>
            <td>${row.valor_paquete}</td>
            <td>${row.cantidad_clase}</td>
            <td>${row.transmision}</td>
            <td>${row.tipo_paquete}</td>
            <td>    

               <button type="button" class="btn " onclick="openUpdate(${row.id_paquete})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDeletePaquete(${row.id_paquete})" class="btn"><img height="20px" width="20px"
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
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_paquete', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PAQUETE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar Paquete';
        // Se inicializan los campos del formulario.
        document.getElementById('id_paquete').value = JSON.dataset.id_paquete;
        document.getElementById('descripcion_paquete').value = JSON.dataset.descripcion;
        document.getElementById('valorpaquete_paquete').value = JSON.dataset.valor_paquete;
        document.getElementById('cantidadclases_paquete').value = JSON.dataset.cantidad_clase;
        fillSelect(PAQUETE_API, 'getTransmision', 'transmision_paquete', JSON.dataset.transmision);
        fillSelect(TIPOPAQUETE_API, 'readAll', 'tipo_paquete_tp', JSON.dataset.id_tipo_paquete);
        ;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDeletePaquete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el paquete de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_paquete', id);
        const JSON = await dataFetch(PAQUETE_API, 'delete', FORM);
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

function openTipoPaqueteG(id) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}report/privado/tipo_paqueteg.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('id_tipo_paquete', id);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}


function openTransmision() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}report/privado/tansmision_paquete.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('transmision', transmision);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}
