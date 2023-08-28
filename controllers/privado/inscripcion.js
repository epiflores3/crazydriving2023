// Se comprueba si la respuesta es correcta, sino muestra con la excepción.
const INSCRIPCION_API = 'business/privado/inscripcion.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const CLIENTE_API = 'business/privado/cliente.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const HORARIO_API = 'business/privado/horario.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const PAQUETE_API = 'business/privado/paquete.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const EMPLEADO_API = 'business/privado/empleado.php';
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));
//Constante para poder guardar los datos del formulario
const SAVE_FORM = document.getElementById('save-form');
//Constante para cambiar el título de los modals
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
const SEARCH_INPUT = document.getElementById('search');


//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTable();
    fillSelect(INSCRIPCION_API, 'getTipoLicencia', 'tipodelicenciacmb');
});

SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

SEARCH_INPUT.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        // Se evita recargar la página web después de enviar el formulario.
        event.preventDefault();
        // Constante tipo objeto con los datos del formulario.
        const FORM = new FormData(SEARCH_FORM);
        // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
        fillTable(FORM);
    }
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(INSCRIPCION_API, action, FORM);
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


document.getElementById('tipodelicenciacmb').addEventListener('change', () => {
     
     const PATH = new URL(`${SERVER_URL}report/privado/inscripcion_tipo_licencia.php`);
     // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
     PATH.searchParams.append('tipo_licencia',  document.getElementById('tipodelicenciacmb').value);
     // Se abre el reporte en una nueva pestaña del navegador web.
     window.open(PATH.href);
});



// async function unicoRegistro(){
//     const FORM = new FormData();
//         FORM.append('cliente', row.id_cliente);
//         const JSON = await dataFetch(INSCRIPCION_API, 'uniqueCustomerRegistration', FORM);
//         if (JSON.dataset ===false) {

//         } else {

//         }
// }

//Función de preparación para poder insertar un nuevo registro
function openCreate() {
    SAVE_FORM.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE.textContent = 'Crear Inscripcion';
    fillSelect(INSCRIPCION_API, 'getTipoLicencia', 'tipodelicencia');
    fillSelect(INSCRIPCION_API, 'getEstadoCliente', 'estadoc');
    fillSelect(EMPLEADO_API, 'readAll', 'asesor');
    fillSelect(CLIENTE_API, 'readAll', 'cliente');
    fillSelect(PAQUETE_API, 'readAll', 'Paquete');
    fillSelect(HORARIO_API, 'readAll', 'horario');
}

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(INSCRIPCION_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            (row.evaluacion) ? icon = 'visibility' : icon = 'visibility_off';
            TBODY_ROWS.innerHTML += `
        <tr>
            <td>${row.anticipo_paquete}</td>
            <td>${row.fecha_registro}</td>
            <td>${row.fecha_inicio}</td>
            <td><i class="material-icons">${icon}</i></td>
            <td>${row.tipo_licencia}</td>
            <td>${row.estado_cliente}</td>
            <td>${row.nombre_com_cliente}</td>
            <td>${row.nombre_com_empleado}</td>
            <td>
        
                <button onclick="openReport(${row.id_inscripcion})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
        
                <button type="button" class="btn " onclick="openUpdate(${row.id_inscripcion})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDelete(${row.id_inscripcion})" class="btn"><img height="20px" width="20px"
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

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_inscripcion', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(INSCRIPCION_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE.textContent = 'Actualizar Paquete';
        // Se escriben los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_inscripcion;
        document.getElementById('anticipo').value = JSON.dataset.anticipo_paquete;
        document.getElementById('fechaini').value = JSON.dataset.fecha_inicio;
        document.getElementById('fecharegistro').value = JSON.dataset.fecha_registro;
        fillSelect(INSCRIPCION_API, 'getTipoLicencia', 'tipodelicencia', JSON.dataset.tipo_licencia);
        fillSelect(EMPLEADO_API, 'readAll', 'asesor', JSON.dataset.id_empleado);
        fillSelect(CLIENTE_API, 'readAll', 'cliente', JSON.dataset.id_cliente);
        fillSelect(INSCRIPCION_API, 'getEstadoCliente', 'estadoc', JSON.dataset.estado_cliente);
        if (JSON.dataset.evaluacion) {
            document.getElementById('evaluacion').checked = true;
        } else {
            document.getElementById('evaluacion').checked = false;
        }
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar la inscripción de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Petición para realizar el proceso de eliminar del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_inscripcion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(INSCRIPCION_API, 'delete', FORM);
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

// async function openTip1() {
//     // Muestra un mensaje de confirmación, capturando la respuesta.
//     const RESPONSE = await confirmAction('¿Desea geberar el reporte?');
//     // Se verifica la respuesta del mensaje.
//     if (RESPONSE) {
//         // Petición para eliminar el registro seleccionado.
//         const JSON = await dataFetch(INSCRIPCION_API, 'capTipoLicencia');
//         // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
//         if (JSON.status) {
//             openIns(JSON.dataset.tipo_licencia);
//             sweetAlert(1, JSON.message, true);
//         } else {
//             sweetAlert(2, JSON.exception, false);
//         }
//     }
// }

function openIns() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}report/privado/inscripcion_tipo_licencia.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('tipo_licencia', tipo_licencia);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}
