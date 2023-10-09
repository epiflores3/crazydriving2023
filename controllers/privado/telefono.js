// Constante para dirgirse a la ruta de API.
const TELEFONO_API = 'business/privado/telefono.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
// const CLIENTE_API = 'business/privado/cliente.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE_TELEFONO = document.getElementById('modal-title-telefono');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_TELEFONO = new bootstrap.Modal(document.getElementById('agregarTelefono'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_TELEFONO = document.getElementById('search-form-telefono');
const SEARCH_INPUT_TELEFONO = document.getElementById('search-telefono');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_TELEFONO = document.getElementById('tbody-rows-telefono');
const RECORDS_TELEFONO = document.getElementById('records-telefono');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_TELEFONO = document.getElementById('save-form-telefono');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableTelefono();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_TELEFONO.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_telefono').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_TELEFONO);
    const JSON = await dataFetch(TELEFONO_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_TELEFONO.hide();
        // Se carga la tabla para ver los cambios.
        fillTableTelefono();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateTelefono() {
    SAVE_FORM_TELEFONO.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_TELEFONO.textContent = 'Crear teléfono';
    fillSelect(CLIENTE_API, 'readAll', 'cliente');
    fillSelect(TELEFONO_API, 'getTipos', 'tipotelefono');
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_TELEFONO.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_TELEFONO);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTableTelefono(FORM);
});

// Método que se utiliza para el formulario de buscar.
SEARCH_INPUT_TELEFONO.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        event.preventDefault();
        const FORM = new FormData(SEARCH_FORM_TELEFONO);
        //Llena la tabla con las respuestas de la búsqueda.
        fillTableTelefono(FORM);
    }
});

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableTelefono(form = null) {
    TBODY_ROWS_TELEFONO.innerHTML = '';
    RECORDS_TELEFONO.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(TELEFONO_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_TELEFONO.innerHTML += `
    <tr>
        <td>${row.telefono}</td>
        <td>${row.tipo_telefono}</td>
        <td>${row.nombre_com_cliente}</td>
            <td>
                
                <button type="button" class="btn " onclick="openUpdateTelefono(${row.id_telefono})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>

                <button onclick="openDeleteTelefono(${row.id_telefono})" class="btn"><img height="20px" width="20px"
                        src="../../resource/img/imgtablas/delete.png" alt="eliminar">
                </button>
            </td>
    </tr>
`;
        });
        RECORDS_TELEFONO.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdateTelefono(id) {
    const FORM = new FormData();
    FORM.append('id_telefono', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(TELEFONO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_TELEFONO.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_TELEFONO.textContent = 'Actualizar teléfono';
        // Se escriben los campos del formulario.
        document.getElementById('id_telefono').value = JSON.dataset.id_telefono;
        document.getElementById('telefono').value = JSON.dataset.telefono;
        fillSelect(TELEFONO_API, 'getTipos', 'tipotelefono', JSON.dataset.tipo_telefono);
        fillSelect(CLIENTE_API, 'readAll', 'cliente', JSON.dataset.id_cliente);
        ;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDeleteTelefono(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el teléfono de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_telefono', id);
        const JSON = await dataFetch(TELEFONO_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableTelefono();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}