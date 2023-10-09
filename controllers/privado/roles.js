// Constante para dirgirse a la ruta de API.
const ROLES_API= 'business/privado/rol.php';
//Constante para cambiar el título de los modals
const MODAL_TITLE_ROL = document.getElementById('modal-title-rol');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_ROL = new bootstrap.Modal(document.getElementById('agregarRol'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_ROL = document.getElementById('search-form-rol');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_ROL = document.getElementById('tbody-rows-rol');
const RECORDS_ROL = document.getElementById('records-rol');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_ROL= document.getElementById('save-form-rol-crud');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableRol();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_ROL.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_rol-id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_ROL);
    const JSON = await dataFetch(ROLES_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_ROL.hide();
        // Se carga la tabla para ver los cambios.
        fillTableRol();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateRol() {
    SAVE_FORM_ROL.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_ROL.textContent = 'Crear rol';
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_ROL.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_ROL);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTableRol(FORM);
});


//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableRol(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS_ROL.innerHTML = '';
    RECORDS_ROL.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'searchR' : action = 'readAll';
    const JSON = await dataFetch(ROLES_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_ROL.innerHTML += `
    <tr>
        <td>${row.rol}</td>
        <td>
  
            <button type="button" class="btn " onclick="openUpdateRol(${row.id_rol})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDeleteRol(${row.id_rol})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
        </td>
    </tr>
`;
        });
        RECORDS_ROL.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdateRol(id) {
    const FORM = new FormData();
    FORM.append('id_rol-id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(ROLES_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_ROL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_ROL.textContent = 'Actualizar rol';
        // Se escriben los campos del formulario.
        document.getElementById('id_rol-id').value = JSON.dataset.id_rol;
        document.getElementById('idrol').value = JSON.dataset.rol;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDeleteRol(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el rol de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_rol-id', id);
        const JSON = await dataFetch(ROLES_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableRol();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}