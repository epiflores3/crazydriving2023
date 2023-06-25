// Constante para dirgirse a la ruta de API.
const FALTANTE_API = 'business/privado/faltante.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const SESION_API = 'business/privado/sesion.php';
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const CMB_SESION = document.getElementById('sesion');
// Constante para poder hacer uso del formulario de buscar dentro de un modal.
const SEARCH_MODAL_FORM = document.getElementById('searchmodal2');
//Constante para cambiar el título de los modals
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTable();
});

// Método que se utiliza para el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTable(FORM);
});


// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(FALTANTE_API, action, FORM);
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

//Método para realizar el combobox de sesión
CMB_SESION.addEventListener('change', async () => {
    const info = document.getElementById('result');
    info.textContent = '';
    //Constante para obtener el valor selecionado del combobux
    var ValorOpcion = CMB_SESION.options[CMB_SESION.selectedIndex].value;
    console.log(ValorOpcion);
    const FORM = new FormData();
    FORM.append('id_sesion', ValorOpcion);
    const JSON = await dataFetch(SESION_API, 'readOne', FORM);
    if (JSON.status) {
        info.textContent =
            'Sesion: ' + JSON.dataset.id_sesion + ' ' + 'Hora de inicio estipulada: ' + JSON.dataset.hora_inicio + ' ' + 'Hora de fin estipulada: ' + JSON.dataset.hora_fin + ' ' + 'Asistencia: ' + JSON.dataset.asistencia + ' ' + 'Tipo de clase :' + JSON.dataset.tipo_clase + ' ' + 'Día: ' + JSON.dataset.dia + ' ' + 'Asesor: ' + JSON.dataset.nombre_com_empleado + '  ' + 'Placa del vehiculo: ' + JSON.dataset.placa
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}
);

//Método para el buscador del modal A
SEARCH_MODAL_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_MODAL_FORM);
    //Llena la tabla con las respuestas de la búsqueda.
    const JSON = await dataFetch(FALTANTE_API, 'searchModal', FORM);

    if (JSON.status) {
        // console.log(JSON.dataset.dui_cliente);
        fillSelect2(FALTANTE_API, 'cargarSelect', 'sesion', JSON.dataset.dui_cliente);
    } else {

    }

});

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(FALTANTE_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
        <tr>
            <td>${row.cantidad_minuto}</td>
            <td>${row.id_sesion}</td>
            <td>
                <button onclick="openReport(${row.id_faltante})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
                
                <button type="button" class="btn " onclick="openUpdate(${row.id_faltante})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDelete(${row.id_faltante})" class="btn"><img height="20px" width="20px"
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

//Función de preparación para poder insertar un nuevo registro
function openCreate() {
    SAVE_FORM.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE.textContent = 'Crear faltante';
    fillSelect2(SESION_API, 'readAll', 'sesion');
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_faltante', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(FALTANTE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE.textContent = 'Actualizar faltante';
        // Se escriben los campos del formulario 
        document.getElementById('id').value = JSON.dataset.id_faltante;
        document.getElementById('cantidad').value = JSON.dataset.cantidad_minuto;
        fillSelect2(FALTANTE_API, 'cargarSelect', 'sesion', JSON.dataset.dui_cliente, JSON.dataset.id_sesion);
        const info = document.getElementById('result');
        info.textContent = '';
        const FORM2 = new FormData();
        FORM2.append('id_sesion', JSON.dataset.id_sesion);
        const JSON2 = await dataFetch(SESION_API, 'readOne', FORM2);
        if (JSON2.status) {
            info.textContent =
                'Sesion: ' + JSON2.dataset.id_sesion + ' ' + 'Hora de inicio estipulada: ' + JSON2.dataset.hora_inicio + ' ' + 'Hora de fin estipulada: ' + JSON2.dataset.hora_fin + ' ' + 'Asistencia: ' + JSON2.dataset.asistencia + ' ' + 'Tipo de clase :' + JSON2.dataset.tipo_clase + ' ' + 'Día: ' + JSON2.dataset.dia + ' ' + 'Asesor: ' + JSON2.dataset.nombre_com_empleado + '  ' + 'Placa del vehiculo: ' + JSON2.dataset.placa
        } else {
            sweetAlert(2, JSON2.exception, false);
        }
    } else {
        sweetAlert(2, JSON.exception, false);
    }

}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id', id);
        // Petición para realizar el proceso de eliminar del registro seleccionado.
        const JSON = await dataFetch(FALTANTE_API, 'delete', FORM);
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



