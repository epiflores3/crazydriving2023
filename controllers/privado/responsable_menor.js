// Constante para completar la ruta de la API.
const RESPONSABLE_API = 'business/privado/responsable_menor.php';
const MODAL_TITLE = document.getElementById('modal-title');

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarResponsable'));
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
const SAVE_FORM = document.getElementById('save-form');

document.addEventListener('DOMContentLoaded', () => {
// Llamada a la función para llenar la tabla con los registros disponibles.
fillTable();
});

SAVE_FORM.addEventListener('submit', async (event) => {
// Se evita recargar la página web después de enviar el formulario.
event.preventDefault();
// Se verifica la acción a realizar.
(document.getElementById('id').value) ? action = 'update' : action = 'create';
// Constante tipo objeto con los datos del formulario.
const FORM = new FormData(SAVE_FORM);
// Petición para guardar los datos del formulario.
const JSON = await dataFetch(RESPONSABLE_API, action, FORM);
// Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
if (JSON.status) {
SAVE_MODAL.hide();
// Se carga nuevamente la tabla para visualizar los cambios.
fillTable();
sweetAlert(1, JSON.message, true);
} else {
sweetAlert(2, JSON.exception, false);
}
});

function openCreate() {


SAVE_FORM.reset();

// Se asigna título a la caja de diálogo.
MODAL_TITLE.textContent = 'Crear Responsable';
fillSelect(RESPONSABLE_API, 'readCliente', 'idcliente');
}


// // Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
// Se evita recargar la página web después de enviar el formulario.
event.preventDefault();
// Constante tipo objeto con los datos del formulario.
const FORM = new FormData(SEARCH_FORM);
// Llamada a la función para llenar la tabla con los resultados de la búsqueda.
fillTable(FORM);
});


async function fillTable(form = null) {
// Se inicializa el contenido de la tabla.
TBODY_ROWS.innerHTML = '';
RECORDS.textContent = '';
// Se verifica la acción a realizar.
(form) ? action = 'search' : action = 'readAll';
// Petición para obtener los registros disponibles.
const JSON = await dataFetch(RESPONSABLE_API, action, form);
// Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
if (JSON.status) {
// Se recorre el conjunto de registros fila por fila.
JSON.dataset.forEach(row => {
// Se crean y concatenan las filas de la tabla con los datos de cada registro.
TBODY_ROWS.innerHTML += `
<tr>

    <td>${row.nombre_com_responsable}</td>
    <td>${row.telefono_responsable}</td>
    <td>${row.correo_responsable}</td>
    <td>${row.dui_responsable}</td>
    <td>${row.parentesco}</td>
    <td>${row.id_cliente}</td>
    <td>

        <button onclick="openReport(${row.id_responsable_menor})" type="button" class="btn ">
            <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
        </button>


        <button type="button" class="btn " onclick="openUpdate(${row.id_responsable_menor})">
            <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
        </button>

        <button onclick="openDelete(${row.id_responsable_menor})" class="btn"><img height="20px" width="20px"
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



async function openUpdate(id) {
// Se define una constante tipo objeto con los datos del registro seleccionado.
const FORM = new FormData();
FORM.append('id_responsable_menor', id);
// Petición para obtener los datos del registro solicitado.
const JSON = await dataFetch(RESPONSABLE_API, 'readOne', FORM);
// Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
if (JSON.status) {
SAVE_MODAL.show();
// Se asigna título para la caja de diálogo.
MODAL_TITLE.textContent = 'Actualizar Responsable';
// Se inicializan los campos del formulario.
document.getElementById('id').value = JSON.dataset.id_responsable_menor;
document.getElementById('nombre').value = JSON.dataset.nombre_com_responsable;
document.getElementById('telefono').value = JSON.dataset.telefono_responsable;
document.getElementById('correo').value = JSON.dataset.correo_responsable;
document.getElementById('dui').value = JSON.dataset.dui_responsable;
document.getElementById('parentesco').value = JSON.dataset.parentesco;
fillSelect(RESPONSABLE_API, 'readCliente', 'idcliente', JSON.dataset.id_cliente);
} else {
sweetAlert(2, JSON.exception, false);
}
}

async function openDelete(id) {
// Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
const RESPONSE = await confirmAction('¿Desea eliminar el Responsable de forma permanente?');
// Se verifica la respuesta del mensaje.
if (RESPONSE) {
// Se define una constante tipo objeto con los datos del registro seleccionado.
const FORM = new FormData();
FORM.append('id_responsable_menor', id);
// Petición para eliminar el registro seleccionado.
const JSON = await dataFetch(RESPONSABLE_API, 'delete', FORM);
// Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
if (JSON.status) {
// Se carga nuevamente la tabla para visualizar los cambios.
fillTable();
// Se muestra un mensaje de éxito.
sweetAlert(1, JSON.message, true);
} else {
sweetAlert(2, JSON.exception, false);
}
}
}