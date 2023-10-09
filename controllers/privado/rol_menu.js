// Constante para dirgirse a la ruta de API.
const ROLES_MENU_API= 'business/privado/rol_menu.php';

const ROL_CRUD_API = 'business/privado/rol.php';
//Constante para cambiar el título de los modals
const MODAL_TITLE_ROLM = document.getElementById('modal-title-rolM');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_ROLM = new bootstrap.Modal(document.getElementById('agregarRolMenu'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_ROLM = document.getElementById('search-form-rolM');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_ROLM = document.getElementById('tbody-rows-rolM');
const RECORDS_ROLM = document.getElementById('records-rolM');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_ROLM= document.getElementById('save-form-rolM-crud');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableRolM();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_ROLM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_rol-M').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_ROLM);
    const JSON = await dataFetch(ROLES_MENU_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_ROLM.hide();
        // Se carga la tabla para ver los cambios.
        fillTableRolM();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateRolM() {
    SAVE_FORM_ROLM.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_ROLM.textContent = 'Crear rol';
    fillSelect(ROL_CRUD_API, 'readAll', 'rol');
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_ROLM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_ROLM);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTableRolM(FORM);
});


//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableRolM(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS_ROLM.innerHTML = '';
    RECORDS_ROLM.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'searchR' : action = 'readAll';
    const JSON = await dataFetch(ROLES_MENU_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_ROLM.innerHTML += `
    <tr>
        <td>${row.rol}</td>
        <td>${row.opciones}</td>
        <td>${row.acciones}</td>

        <td>
            
            <button type="button" class="btn " onclick="openUpdateRolMenu(${row.id_rol_menu})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDelete(${row.id_rol_menu})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
        </td>
    </tr>
`;
        });
        RECORDS_ROLM.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

// //Función de preparación para poder actualizar cualquier campo, de cualquier registro

async function openUpdateRolMenu(id) {
    console.log(id);
    const FORM = new FormData();
    FORM.append('id_rol-M', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(ROLES_MENU_API, 'readOneM', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_ROLM.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_ROLM.textContent = 'Actualizar rol';
        // Se escriben los campos del formulario.
        document.getElementById('id_rol-M').value = JSON.dataset.id_rol_menu;
        document.getElementById('opciones').value = JSON.dataset.opciones;
        document.getElementById('acciones').value = JSON.dataset.acciones;
        fillSelect(ROL_CRUD_API, 'readAll', 'rol', JSON.dataset.id_rol);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el rol de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_rol-M', id);
        const JSON = await dataFetch(ROLES_MENU_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableRolM();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}