// Constante para dirgirse a la ruta de API.
const CLIENTE_API = 'business/privado/cliente.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODELO_API = 'business/privado/modelo.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarCliente'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
const SEARCH_INPUT = document.getElementById('search');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTable();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(CLIENTE_API, action, FORM);
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
    MODAL_TITLE.textContent = 'Crear cliente';
    fillSelect(CLIENTE_API, 'getTipos', 'tipoestado');
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTable(FORM);
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

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
     // Verificación de la acción a hacer.
     const JSON = await dataFetch(CLIENTE_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
         // Se recorre el conjunto de registros fila por fila.
         JSON.dataset.forEach(row => {
             // Se crean y concatenan las filas de la tabla con los datos de cada registro.
             TBODY_ROWS.innerHTML += `
    <tr>
    <td>${row.nombre_com_cliente}</td>
    <td>${row.dui_cliente}</td>
    <td>${row.fecha_nac_cliente}</td>
    <td>${row.direccion_cliente}</td>
    <td>${row.correo_cliente}</td>
    <td>${row.estado_cliente}</td>
        <td>

            <button type="button" class="btn " onclick="openUpdate(${row.id_cliente})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDelete(${row.id_cliente})" class="btn"><img height="20px" width="20px"
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



async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_cliente', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CLIENTE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar cliente';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_cliente;
        document.getElementById('nombrec').value = JSON.dataset.nombre_com_cliente;
        document.getElementById('duic').value = JSON.dataset.dui_cliente;
        document.getElementById('fechanacc').value = JSON.dataset.fecha_nac_cliente; //No lee
        document.getElementById('direccionc').value = JSON.dataset.direccion_cliente;
        document.getElementById('correoc').value = JSON.dataset.correo_cliente;
        fillSelect(CLIENTE_API, 'getTipos', 'tipoestado', JSON.dataset.estado_cliente);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el cliente de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_cliente', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CLIENTE_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

function openReportInscripcionEstadoCliente() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}report/privado/inscripcion_estado_cliente.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}