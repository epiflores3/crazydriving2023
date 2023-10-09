// Constante para completar la ruta de la API.
const MARCA_CRUD_API = 'business/privado/marca.php';
//Constante para cambiar el título de los modals
const MODAL_TITLE_MARCA = document.getElementById('modal-title-marca');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_MARCA = new bootstrap.Modal(document.getElementById('agregarmarca'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_MARCA = document.getElementById('search-form-marca');
const SEARCH_INPUT_MARCA = document.getElementById('search-marca');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_MARCA = document.getElementById('tbody-rows-Marca');
const RECORDS_MARCA = document.getElementById('recordsMarca');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_MARCA = document.getElementById('save-form-marca');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableMa();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_MARCA.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_marca').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_MARCA);
    const JSON = await dataFetch(MARCA_CRUD_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_MARCA.hide();
        // Se carga la tabla para ver los cambios.
        fillTableMa();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateMarca() {
    SAVE_FORM_MARCA.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_MARCA.textContent = 'Crear marca';
}

// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_MARCA.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_MARCA);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTableMa(FORM);
});

// Método que se utiliza para el formulario de buscar.
SEARCH_INPUT_MARCA.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        event.preventDefault();
        const FORM = new FormData(SEARCH_FORM_MARCA);
        //Llena la tabla con las respuestas de la búsqueda.
        fillTableMa(FORM);
    }
});

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableMa(form = null) {
    TBODY_ROWS_MARCA.innerHTML = '';
    RECORDS_MARCA.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MARCA_CRUD_API, action, form);
    /// Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_MARCA.innerHTML += `
    <tr>
        <td>${row.marca}</td>
        <td>
        
             <button type="button" class="btn " onclick="openUpdateMarca(${row.id_marca})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDeleteMarca(${row.id_marca})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
        </td>
    </tr>
`;
        });
        RECORDS_MARCA.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdateMarca(id) {
    const FORM = new FormData();
    FORM.append('id_marca', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(MARCA_CRUD_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_MARCA.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_MARCA.textContent = 'Actualizar marca';
        // Se escriben los campos del formulario.
        document.getElementById('id_marca').value = JSON.dataset.id_marca;
        document.getElementById('marca_M').value = JSON.dataset.marca;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDeleteMarca(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar la marca de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_marca', id);
        // Petición para realizar el proceso de eliminar del registro seleccionado.
        const JSON = await dataFetch(MARCA_CRUD_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableMa();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}