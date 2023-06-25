// Constante para dirgirse a la ruta de API.
const EMPLEADO_API = 'business/privado/empleado.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const ROL_API = 'business/privado/roles.php';
// Constante para obtener los datos del archivo a utilizar y poder realizar el combobox
const SUCURSAL_API = 'business/privado/sucursal.php';
//Constante para cambiar el título de los modals
const MODAL_TITLE = document.getElementById('modal-title');
//Constante para poder guardar los datos del modal
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarEmpleado'));
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
    const JSON = await dataFetch(EMPLEADO_API, action, FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
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
    // Verificación de la acción a hacer.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(EMPLEADO_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            (row.estado_empleado) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.nombre_com_empleado}</td>
                <td>${row.dui_empleado}</td>
                 <td><img src="${SERVER_URL}img/licencia_empleado/${row.licencia_empleado}" class="materialboxed" height="100"></td>
                <td>${row.telefono_empleado}</td>
                <td>${row.fecha_nac_empleado}</td>
                <td>${row.direccion_empleado}</td>
                <td>${row.correo_empleado}</td>
                <td>${row.nombre_afp}</td>
                <td><i class="material-icons">${icon}</i></td>
                <td>${row.rol}</td>
                <td>${row.nombre_sucursal}</td>
                <td>
                <button onclick="openReport(${row.id_empleado})" type="button" class="btn ">
                <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>

                 <button type="button" class="btn " onclick="openUpdate(${row.id_empleado})">
                <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                 </button>

                <button onclick="openDelete(${row.id_empleado})" class="btn"><img height="20px" width="20px"
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
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear empleado';
    fillSelect(ROL_API, 'readAll', 'rol');
    fillSelect(SUCURSAL_API, 'readAll', 'sucursal');
}

//Función de preparación para poder actualizar cualquier campo, de cualquier registro
async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_empleado', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(EMPLEADO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se da un título que se mostrará en el modal.
        MODAL_TITLE.textContent = 'Actualizar empleado';
        // Se escriben los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_empleado;
        document.getElementById('nombre').value = JSON.dataset.nombre_com_empleado;
        document.getElementById('dui').value = JSON.dataset.dui_empleado;

        document.getElementById('telefono').value = JSON.dataset.telefono_empleado;
        document.getElementById('nacimiento').value = JSON.dataset.fecha_nac_empleado;
        document.getElementById('direccion').value = JSON.dataset.direccion_empleado;
        document.getElementById('correo').value = JSON.dataset.correo_empleado;
        document.getElementById('afp').value = JSON.dataset.nombre_afp;
        if (JSON.dataset.estado_empleado) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
        fillSelect(ROL_API, 'readAll', 'rol', JSON.dataset.id_rol);
        fillSelect(SUCURSAL_API, 'readAll', 'sucursal', JSON.dataset.id_sucursal);
        document.getElementById('licencia').value = JSON.dataset.licencia_empleado;

    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//Función de preparación para poder eliminar cualquier registro
async function openDelete(id) {
    // Muestra un mensaje de confirmación, capturando la respuesta.
    const RESPONSE = await confirmAction('¿Desea eliminar el empleado de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_empleado', id);
        // Petición para realizar el proceso de eliminar del registro seleccionado.
        const JSON = await dataFetch(EMPLEADO_API, 'delete', FORM);
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