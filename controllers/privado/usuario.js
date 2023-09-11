// Constante para dirgirse a la ruta de API.
const USUARIO_API = 'business/privado/usuario.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarUsuario'));
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

//Función de preparación para poder insertar un nuevo registro
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

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(USUARIO_API, action, FORM);
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

//Función de preparación para poder insertar un nuevo registro
function openCreate() {
    SAVE_FORM.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE.textContent = 'Crear usuario';
    fillSelect(USUARIO_API, 'readEmpleado', 'idempleado');
    fillSelect(USUARIO_API, 'readEstadousu', 'estadousu');
}


//Función de preparación para poder insertar un nuevo registro
SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    //Llena la tabla con las respuestas de la búsqueda.
    fillTable(FORM);
});

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(USUARIO_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
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

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_usuario', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE.textContent = 'Actualizar usuario';
        // Se escriben los campos del formulario.
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

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el usuario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_usuario', id);
        const JSON = await dataFetch(USUARIO_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTable();
            //Carga la tabla para ver los cambios.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}
