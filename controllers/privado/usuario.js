// Constante para completar la ruta de la API.
const USUARIO_API = 'business/privado/usuario.php';
const MODAL_TITLE = document.getElementById('modal-title');

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarUsuario'));
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
const SAVE_FORM = document.getElementById('save-form');
const SEARCH_INPUT = document.getElementById('search');

document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

//Metodo para buscar//

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

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(USUARIO_API, action, FORM);
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
    MODAL_TITLE.textContent = 'Crear Usuario';
    fillSelect(USUARIO_API, 'readEmpleado', 'idempleado');
    fillSelect(USUARIO_API, 'readEstadousu', 'estadousu');
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
    const JSON = await dataFetch(USUARIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
<tr>

    <td>${row.correo_usuario}</td>
    <td>${row.alias_usuario}</td>
    <td>${row.clave_usuario}</td>
    <td><img src="${SERVER_URL}images/usuario/${row.imagen_usuario}" class="materialboxed" height="100"></td>
    <td>${row.fecha_creacion}</td>
    <td>${row.intento}</td>
    <td>${row.estado_usuario}</td>
    <td>${row.id_empleado}</td>
    <td>

        <button onclick="openReport(${row.id_usuario})" type="button" class="btn ">
            <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
        </button>


        <button type="button" class="btn " onclick="openUpdate(${row.id_usuario})">
            <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
        </button>

        <button onclick="openDelete(${row.id_usuario})" class="btn"><img height="20px" width="20px"
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
    FORM.append('id_usuario', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar Usuario';

        // Se establece el campo de archivo como opcional.

        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_usuario;
        document.getElementById('correo').value = JSON.dataset.correo_usuario;
        document.getElementById('alias').value = JSON.dataset.alias_usuario;
        document.getElementById('clave').value = JSON.dataset.clave_usuario;
        document.getElementById('fechacreacion').value = JSON.dataset.fecha_creacion;
        document.getElementById('imagen_usuario').value = JSON.dataset.imagen_usuario;
        document.getElementById('intentos').value = JSON.dataset.intento;
        fillSelect(USUARIO_API, 'readEstadousu', 'estadousu', JSON.dataset.estado_usuario);
        fillSelect(USUARIO_API, 'readEmpleado', 'idempleado', JSON.dataset.id_empleado);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el usuario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_usuario', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(USUARIO_API, 'delete', FORM);
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