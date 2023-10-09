// Constante para dirgirse a la ruta de API.
const RESPONSABLE_API = 'business/privado/responsable_menor.php';
const CLIENTE_CRUD_API = 'business/privado/cliente.php';
//Constante para cambiar el título de los modals
const MODAL_TITLE_RESPONSABLE = document.getElementById('modal-title-responsable');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_RESPONSABLE = new bootstrap.Modal(document.getElementById('agregarResponsable'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_RESPONSABLE= document.getElementById('search-form-responsable');
const SEARCH_INPUT_RESPONSABLE = document.getElementById('search-responsable');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_RESPONSABLE = document.getElementById('tbody-rows-responsable');
const RECORDS_RESPONSABLE = document.getElementById('recordsRe');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_RESPONSABLE = document.getElementById('save-form-responsable');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableResponsableM();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_RESPONSABLE.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_responsable_menor').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_RESPONSABLE);
    const JSON = await dataFetch(RESPONSABLE_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_RESPONSABLE.hide();
        // Se carga la tabla para ver los cambios.
        fillTableResponsableM();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateResponsable() {
    SAVE_FORM_RESPONSABLE.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_RESPONSABLE.textContent = 'Crear responsable menor';
    fillSelect(CLIENTE_CRUD_API, 'readAll', 'cliente_cmb');
    fillSelect(RESPONSABLE_API, 'getParentesco', 'parentesco_re');
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_RESPONSABLE.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_RESPONSABLE);
    ///Llena la tabla con las respuestas de la búsqueda.
    fillTableResponsableM(FORM);
});

// Método que se utiliza para el formulario de buscar.
SEARCH_INPUT_RESPONSABLE.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        event.preventDefault();
        const FORM = new FormData(SEARCH_FORM_RESPONSABLE);
        //Llena la tabla con las respuestas de la búsqueda.
        fillTableResponsableM(FORM);
    }
});


//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableResponsableM(form = null) {
    TBODY_ROWS_RESPONSABLE.innerHTML = '';
    RECORDS_RESPONSABLE.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(RESPONSABLE_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_RESPONSABLE.innerHTML += `
    <tr>
        <td>${row.nombre_com_responsable}</td>
        <td>${row.telefono_responsable}</td>
        <td>${row.correo_responsable}</td>
        <td>${row.dui_responsable}</td>
        <td>${row.parentesco}</td>
        <td>${row.nombre_com_cliente}</td>
        <td>
            <button onclick="openReport(${row.id_responsable_menor})" type="button" class="btn ">
                <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
            </button>

            <button type="button" class="btn " onclick="openUpdateR(${row.id_responsable_menor})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDeleteR(${row.id_responsable_menor})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
        </td>
    </tr>
`;
        });

        RECORDS_RESPONSABLE.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdateR(id) {
    const FORM = new FormData();
    FORM.append('id_responsable_menor', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(RESPONSABLE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_RESPONSABLE.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_RESPONSABLE.textContent = 'Actualizar responsable menor';
        // Se escriben los campos del formulario.
        document.getElementById('id_responsable_menor').value = JSON.dataset.id_responsable_menor;
        document.getElementById('nombre').value = JSON.dataset.nombre_com_responsable;
        document.getElementById('telefono_re').value = JSON.dataset.telefono_responsable;
        document.getElementById('correo').value = JSON.dataset.correo_responsable;
        document.getElementById('dui').value = JSON.dataset.dui_responsable;
        fillSelect(CLIENTE_CRUD_API, 'readAll', 'cliente_cmb', JSON.dataset.id_cliente);
        fillSelect(RESPONSABLE_API, 'getParentesco', 'parentesco_re', JSON.dataset.parentesco);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDeleteR(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el responsable menor de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_responsable_menor', id);
        const JSON = await dataFetch(RESPONSABLE_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableResponsableM();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}