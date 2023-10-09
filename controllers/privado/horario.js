// Se muestra un mensaje con el proceso completado.
const HORARIO_API = 'business/privado/horario.php';
//Constante para poder guardar los datos del modal
const SAVE_MODAL_HORARIO = new bootstrap.Modal(document.getElementById('agregarhorario'));
//Constante para poder guardar los datos del formulario
const SAVE_FORM_HORARIO = document.getElementById('save-form-horario');
//Constante para cambiar el título de los modals
const MODAL_TITLE_HORARIO= document.getElementById('modal-title-horario');
// Constantes para cuerpo de la tabla
const TBODY_ROWS_HORARIO = document.getElementById('tbody-rows-horario');
const RECORDS_HORARIO = document.getElementById('recordshorario');
// Constante para poder hacer uso del formulario de buscar.
const SEARCH_FORM_HORARIO = document.getElementById('search-form-horario');
const SEARCH_INPUT_HORARIO = document.getElementById('search-horario');

//Método que se utiliza cuando el mantenimiento leer ha cargado
document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTableHorario();
});

SEARCH_FORM_HORARIO.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM_HORARIO);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTableHorario(FORM);
});

SEARCH_INPUT_HORARIO.addEventListener("keyup", (event) => {
    let texto = event.target.value;
    console.log(texto);
    if (texto.value != "") {
        // Se evita recargar la página web después de enviar el formulario.
        event.preventDefault();
        // Constante tipo objeto con los datos del formulario.
        const FORM = new FormData(SEARCH_FORM_HORARIO);
        // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
        fillTableHorario(FORM);
    }
});

// Método que sirve para el formulario se envía para ser guardado
SAVE_FORM_HORARIO.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id_horario').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM_HORARIO);
    const JSON = await dataFetch(HORARIO_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL_HORARIO.hide();
        // Se carga la tabla para ver los cambios.
        fillTableHorario();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

//Función de preparación para poder insertar un nuevo registro
function openCreateHorario() {
    SAVE_FORM_HORARIO.reset();
    // Se da un título que se mostrará en el modal.
    MODAL_TITLE_HORARIO.textContent = 'Crear horario';

}

//Función que llena la tabla con todos los registros que se necuentran en la base
async function fillTableHorario(form = null) {
    TBODY_ROWS_HORARIO.innerHTML = '';
    RECORDS_HORARIO.textContent = '';
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(HORARIO_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_HORARIO.innerHTML += `
    <tr>
        <td>${row.inicio}</td>
        <td>${row.fin}</td>
        <td>

            <button type="button" class="btn " onclick="openUpdateH(${row.id_horario})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
            </button>
    
            <button onclick="openDeleteH(${row.id_horario})" class="btn"><img height="20px" width="20px"
                    src="../../resource/img/imgtablas/delete.png" alt="eliminar">
            </button>
    
        </td>
    </tr>
    `;
        });

        RECORDS_HORARIO.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdateH(id) {
    const FORM = new FormData();
    FORM.append('id_horario', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(HORARIO_API, 'readOne', FORM);
    if (JSON.status) {
        SAVE_MODAL_HORARIO.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE_HORARIO.textContent = 'Actualizar horario';
        // Se escriben los campos del formulario.
        document.getElementById('id_horario').value = JSON.dataset.id_horario;
        document.getElementById('inicio_horario').value = JSON.dataset.inicio;
        document.getElementById('final_horario').value = JSON.dataset.fin;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDeleteH(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el horario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_horario', id);
        // Petición para realizar el proceso de eliminar del registro seleccionado.
        const JSON = await dataFetch(HORARIO_API, 'delete', FORM);
        // Se comprueba si la respuesta es correcta, sino muestra con la excepción.
        if (JSON.status) {
            //Carga la tabla para ver los cambios.
            fillTableHorario();
            // Se muestra un mensaje con el proceso completado.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}
