// Constante para dirgirse a la ruta de API.
const SUCURSAL_API = 'business/privado/sucursal.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE_SUCURSAL = document.getElementById('modal-title-sucursal');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_SUCURSAL = new bootstrap.Modal(document.getElementById('agregarSucursal'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_SUCURSAL = document.getElementById('search-form-sucursal');
const SEARCH_INPUT_SUCURSAL = document.getElementById('search-sucursal');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_SUCURSAL = document.getElementById('tbody-rows-sucursal');
const RECORDS_SUCURSAL = document.getElementById('recordsS');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_SUCURSAL = document.getElementById('save-form-sucursal');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableS();
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_SUCURSAL.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_sucursal').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_SUCURSAL);
    const JSON = await dataFetch(SUCURSAL_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_SUCURSAL.hide();
        // Se carga la tabla para ver los cambios.
        fillTableS();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateSucursal() {
    SAVE_FORM_SUCURSAL.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_SUCURSAL.textContent = 'Crear sucursal';
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_SUCURSAL.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_SUCURSAL);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTableS(FORM);
});

//Llena la tabla con las respuestas de la búsqueda.
SEARCH_INPUT_SUCURSAL.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        event.preventDefault();
        const FORM = new FormData(SEARCH_FORM_SUCURSAL);
        //Llena la tabla con las respuestas de la búsqueda.
        fillTableS(FORM);
    }
});

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableS(form = null) {
    TBODY_ROWS_SUCURSAL.innerHTML = '';
    RECORDS_SUCURSAL.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(SUCURSAL_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_SUCURSAL.innerHTML += `
    <tr>
        <td>${row.nombre_sucursal}</td>
        <td>${row.direccion_sucursal}</td>
        <td>

           <button onclick="openEmpleadoSucuEspecifico(${row.id_sucursal})" type="button" class="btn ">
                <img height="1px" width="1px" src="../../resource/img/imgtablas/reportAFP.png" alt="ver">
                </button>

            <button type="button" class="btn " onclick="openUpdate(${row.id_sucursal})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDelete(${row.id_sucursal})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
        </td>
    </tr>
`;
        });
        RECORDS_SUCURSAL.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_sucursal', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(SUCURSAL_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_SUCURSAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_SUCURSAL.textContent = 'Actualizar sucursal';
        // Se escriben los campos del formulario.
        document.getElementById('id_sucursal').value = JSON.dataset.id_sucursal;
        document.getElementById('nombre_sucursal').value = JSON.dataset.nombre_sucursal;
        document.getElementById('direccion_sucursal').value = JSON.dataset.direccion_sucursal;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar la sucursal de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_sucursal', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(SUCURSAL_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableS();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}


function openEmpleadoSucuEspecifico(id) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}report/privado/empleado_sucu_especifico.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('id_sucursal', id);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}

