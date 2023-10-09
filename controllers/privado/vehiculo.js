// Constante para dirgirse a la ruta de API.
const VEHICULO_API = 'business/privado/vehiculo.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODELO_CRUD_API = 'business/privado/modelo.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE_VEHICULO = document.getElementById('modal-title-vehiculo');
//Constante para poder guardar los datos del modal
const SAVE_MODAL_VEHICULO = new bootstrap.Modal(document.getElementById('agregavehiculo'));
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_VEHICULO = document.getElementById('search-form-vehiculo');
const SEARCH_INPUT_VEHICULO = document.getElementById('search-vehiculo');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_VEHICULO = document.getElementById('tbody-rows-vehiculo');
const RECORDS_VEHICULO = document.getElementById('recordsV');
//Constante para poder guardar los datos del formulario
const SAVE_FORM_VEHICULO= document.getElementById('save-form-vehiculo');





//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableVehiculo();
    fillSelect(MODELO_CRUD_API, 'readAll', 'modelocm');
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_VEHICULO.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_vehiculo').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_VEHICULO);
    const JSON = await dataFetch(VEHICULO_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_VEHICULO.hide();
        // Se carga la tabla para ver los cambios.
        fillTableVehiculo();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_VEHICULO.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_vehiculo').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_VEHICULO);
    const JSON = await dataFetch(MODELO_CRUD_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_VEHICULO.hide();
        // Se carga la tabla para ver los cambios.
        fillTableVehiculo();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


//Función de preparación para poder insertar un nuevo registro
function openCreateVehiculo() {
    SAVE_FORM_VEHICULO.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_VEHICULO.textContent = 'Crear vehículo';
    fillSelect(MODELO_CRUD_API, 'readAll', 'modelocm');
}


// Método que se utiliza para el formulario de buscar.
SEARCH_FORM_VEHICULO.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM_VEHICULO);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTableVehiculo(FORM);
});

// Método que se utiliza para el formulario de buscar.
SEARCH_INPUT.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        event.preventDefault();
        const FORM = new FormData(SEARCH_FORM_VEHICULO);
        //Llena la tabla con las respuestas de la búsqueda.
        fillTableVehiculo(FORM);
    }
});

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableVehiculo(form = null) {
    TBODY_ROWS_VEHICULO.innerHTML = '';
    RECORDS_VEHICULO.textContent = '';
    (form) ? action = 'search' : action = 'readAll';
    // Verificación de la acción a hacer.
    const JSON = await dataFetch(VEHICULO_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_VEHICULO.innerHTML += `
    <tr>
    <td>${row.placa}</td>
    <td>${row.modelo}</td>
        <td>
            
            <button type="button" class="btn " onclick="openUpdate(${row.id_vehiculo})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>

            <button onclick="openDelete(${row.id_vehiculo})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
        </td>
    </tr>
`;
        });

        RECORDS_VEHICULO.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}




async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_vehiculo', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(VEHICULO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL_VEHICULO.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar vehículo';
        // Se inicializan los campos del formulario.
        document.getElementById('id_vehiculo').value = JSON.dataset.id_vehiculo;
        document.getElementById('placa').value = JSON.dataset.placa;
        fillSelect(MODELO_CRUD_API, 'readAll', 'modelocm', JSON.dataset.id_modelo);
        ;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el vehículo de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_vehiculo', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(VEHICULO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTableVehiculo();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}