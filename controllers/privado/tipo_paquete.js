// Constante para dirgirse a la ruta de API.
const TIPO_PAQUETE_API = 'business/privado/tipo_paquete.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE_TIPO_PAQUETE = document.getElementById('modal-title-tipo-paquete');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_TIPO_PAQUETE = new bootstrap.Modal(document.getElementById('agregarTipoPaquete'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_TIPO_PAQUETE = document.getElementById('search-form-tp');
const SEARCH_INPUT_TIPO_PAQUETE = document.getElementById('search-tp');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_TIPO_PAQUETE = document.getElementById('tbody-rows-tp');
const RECORDS_TIPO_PAQUETE = document.getElementById('recordstp');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_TIPO_PAQUETE = document.getElementById('save-form-tp');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableTipoPaquete();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_TIPO_PAQUETE.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_tipo_paquete').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_TIPO_PAQUETE);
    const JSON = await dataFetch(TIPO_PAQUETE_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_TIPO_PAQUETE.hide();
        // Se carga la tabla para ver los cambios.
        fillTableTipoPaquete();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateTipoPaquete() {
    SAVE_FORM_TIPO_PAQUETE.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_TIPO_PAQUETE.textContent = 'Crear tipo paquete';
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_TIPO_PAQUETE.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_TIPO_PAQUETE);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTableTipoPaquete(FORM);
});

// Método que se utiliza para el formulario de buscar.
SEARCH_INPUT_TIPO_PAQUETE.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        event.preventDefault();
        const FORM = new FormData(SEARCH_FORM_TIPO_PAQUETE);
        //Llena la tabla con las respuestas de la búsqueda.
        fillTableTipoPaquete(FORM);
    }
});

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableTipoPaquete(form = null) {
    TBODY_ROWS_TIPO_PAQUETE.innerHTML = '';
    RECORDS_TIPO_PAQUETE.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(TIPO_PAQUETE_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_TIPO_PAQUETE.innerHTML += `
    <tr>
        <td>${row.tipo_paquete}</td>
        <td>
            <button onclick="openTipoPaquete(${row.id_tipo_paquete})" type="button" class="btn ">
                <img height="1px" width="1px" src="../../resource/img/imgtablas/reportAFP.png" alt="ver">
            </button>

            <button type="button" class="btn " onclick="openUpdate(${row.id_tipo_paquete})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDelete(${row.id_tipo_paquete})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
        </td>
    </tr>
`;
        });
        RECORDS_TIPO_PAQUETE.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_tipo_paquete', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(TIPO_PAQUETE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_TIPO_PAQUETE.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_TIPO_PAQUETE.textContent = 'Actualizar tipo paquete';
        // Se escriben los campos del formulario.
        document.getElementById('id_tipo_paquete').value = JSON.dataset.id_tipo_paquete;
        document.getElementById('tipo_paquete_tp').value = JSON.dataset.tipo_paquete;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    const RESPONSE = await confirmAction('¿Desea eliminar el tipo paquete de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_tipo_paquete', id);
        const JSON = await dataFetch(TIPO_PAQUETE_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableTipoPaquete();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

function openTipoPaquete(id) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}report/privado/tipo_paquete.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('id_tipo_paquete', id);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}