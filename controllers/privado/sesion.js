// Constante para dirgirse a la ruta de API.
const SESION_API = 'business/privado/sesion.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const DETALLE_INSCRIPCION_API = 'business/privado/detalle_inscripcion.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const EMPLEADO_API = 'business/privado/empleado.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const VEHICULO_API = 'business/privado/vehiculo.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarSesion'));
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
const SEARCH_INPUT = document.getElementById('search');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTable();
    fillSelect(SESION_API, 'readTipoClase', 'tipodeclasecmb');
});

// Método que se utiliza para el formulario de buscar.
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



document.getElementById('tipodeclasecmb').addEventListener('change', () => {
     
    const PATH = new URL(`${SERVER_URL}report/privado/sesion_tipo_clase.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('tipo_clase',  document.getElementById('tipodeclasecmb').value);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(SESION_API, action, FORM);
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

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(SESION_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            (row.asistencia) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.hora_inicio}</td>
                <td>${row.hora_fin}</td>
                <td><i class="material-icons">${icon}</i></td>
                <td>${row.tipo_clase}</td>
                <td>${row.estado_sesion}</td>
                <td>${row.id_detalle_inscripcion}</td>
                <td>${row.nombre_com_empleado}</td>
                <td>${row.placa}</td>
                <td>
                <button onclick="openReport(${row.id_sesion})" type="button" class="btn ">
                <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
    
                 <button type="button" class="btn " onclick="openUpdate(${row.id_sesion})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                 </button>
    
                <button onclick="openDelete(${row.id_sesion})" class="btn"><img height="20px" width="20px"
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
    MODAL_TITLE.textContent = 'Crear sesión';
    fillSelect(SESION_API, 'readTipoClase', 'tipoclase');
    fillSelect(SESION_API, 'readEstadoSesion', 'estado');
    fillSelect(DETALLE_INSCRIPCION_API, 'readAll', 'detalleinscripcion');
    fillSelect(EMPLEADO_API, 'readAll', 'empleado');
    fillSelect(VEHICULO_API, 'readAll', 'vehiculo');
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    // Petición para obtener los datos del registro solicitado.
    const FORM = new FormData();
    FORM.append('id_sesion', id);
    const JSON = await dataFetch(SESION_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE.textContent = 'Actualizar sesión';
        // Se escriben los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_sesion;
        document.getElementById('inicio').value = JSON.dataset.hora_inicio;
        document.getElementById('fin').value = JSON.dataset.hora_fin;
        if (JSON.dataset.asistencia) {
            document.getElementById('asistencia').checked = true;
        } else {
            document.getElementById('asistencia').checked = false;
        }
        fillSelect(SESION_API, 'readTipoClase', 'tipoclase', JSON.dataset.tipo_clase);
        fillSelect(SESION_API, 'readEstadoSesion', 'estado', JSON.dataset.estado_sesion);
        fillSelect(DETALLE_INSCRIPCION_API, 'readAll', 'detalleinscripcion', JSON.dataset.id_detalle_inscripcion);
        fillSelect(EMPLEADO_API, 'readAll', 'empleado', JSON.dataset.id_empleado);
        fillSelect(VEHICULO_API, 'readAll', 'vehiculo', JSON.dataset.id_vehiculo);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar la sesión de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_sesion', id);
        const JSON = await dataFetch(SESION_API, 'delete', FORM);
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



function openIns() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}report/privado/sesion_tipo_clase.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('tipo_clase', tipo_clase);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}
