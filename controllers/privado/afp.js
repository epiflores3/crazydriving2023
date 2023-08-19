// Constante para dirgirse a la ruta de API.
const AFP_API = 'business/privado/afp.php';
//Constante para cambiar el título de los modals
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarAFP'));
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

// // Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(AFP_API, action, FORM);
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

// //Función de preparación para poder insertar un nuevo registro
function openCreate() {
    SAVE_FORM.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE.textContent = 'Crear AFP';
}


// // Método que se utiliza para el formulario de buscar.
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
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(AFP_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.nombre_afp}</td>
                    <td>
                        <button type="button" class="btn " onclick="openUpdate(${row.id_afp})">
                            <img height="15px" width="15px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                        </button>

                        <button onclick="openDelete(${row.id_afp})" class="btn"><img height="15px" width="15px"
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

// //Método para abrir el reporte 
// function openReportEmpleadoPorAfp() {
//     // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
//     const PATH = new URL(`${SERVER_URL}report/privado/empleado_afp.php`);
//     // Se abre el reporte en una nueva pestaña del navegador web.
//     window.open(PATH.href);
// }

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_afp', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(AFP_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE.textContent = 'Actualizar AFP';
        // Se escriben los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_afp;
        document.getElementById('afp').value = JSON.dataset.nombre_afp;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

// //Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar la AFP de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_afp', id);
        const JSON = await dataFetch(AFP_API, 'delete', FORM);
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