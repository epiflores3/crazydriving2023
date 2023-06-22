const EMPLEADO_API = 'business/privado/empleado.php';
const ROL_API = 'business/privado/roles.php';
const SUCURSAL_API = 'business/privado/sucursal.php';


//Constante para cambiarle el titulo a el modal
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarEmpleado'));
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
const SEARCH_INPUT = document.getElementById('search');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
const SAVE_FORM = document.getElementById('save-form');

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


// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(EMPLEADO_API, action, FORM);
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

async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(EMPLEADO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
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

function openCreate() {

    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear empleado';
    fillSelect(ROL_API, 'readAll', 'rol');
    fillSelect(SUCURSAL_API, 'readAll', 'sucursal');

}

async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_empleado', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(EMPLEADO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar empleado';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_empleado;
        document.getElementById('nombre').value = JSON.dataset.nombre_com_empleado;
        document.getElementById('dui').value = JSON.dataset.dui_empleado;
        // document.getElementById('licencia').value = JSON.dataset.licencia_empleado;
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

    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el empleado de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_empleado', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(EMPLEADO_API, 'delete', FORM);
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