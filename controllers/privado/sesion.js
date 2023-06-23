const SESION_API = 'business/privado/sesion.php';
const DETALLE_INSCRIPCION_API = 'business/privado/detalle_inscripcion.php';
const EMPLEADO_API = 'business/privado/empleado.php';
const VEHICULO_API = 'business/privado/vehiculo.php';

//Constante para cambiarle el titulo a el modal
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarSesion'));
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
    const JSON = await dataFetch(SESION_API, action, FORM);
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
    const JSON = await dataFetch(SESION_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
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

function openCreate() {

    SAVE_FORM.reset();
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear sesión';
    fillSelect(SESION_API, 'readTipoClase', 'tipoclase');
    fillSelect(SESION_API, 'readEstadoSesion', 'estado');


    fillSelect(DETALLE_INSCRIPCION_API, 'readAll', 'detalleinscripcion');
    fillSelect(EMPLEADO_API, 'readAll', 'empleado');
    fillSelect(VEHICULO_API, 'readAll', 'vehiculo');
}

async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_sesion', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(SESION_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar sesión';
        // Se inicializan los campos del formulario.
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

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la sesión de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_sesion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(SESION_API, 'delete', FORM);
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