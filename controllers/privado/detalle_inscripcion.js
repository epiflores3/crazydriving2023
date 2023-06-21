const DETALLEINSCRIPCION_API = 'business/privado/detalle_inscripcion.php';

const PAQUETE_API = 'business/privado/paquete.php';
const EMPLEADO_API = 'business/privado/empleado.php';
const INSCRIPCION_API = 'business/privado/inscripcion.php';

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));
const SAVE_FORM = document.getElementById('save-form');
const MODAL_TITLE = document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

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
        const JSON = await dataFetch(DETALLEINSCRIPCION_API, action, FORM);
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
        MODAL_TITLE.textContent = 'Crear detalle inscripcion';
        fillSelect(INSCRIPCION_API, 'readAll', 'inscripcion');
        fillSelect(PAQUETE_API, 'readAll', 'paquete');
        fillSelect(EMPLEADO_API, 'readAll', 'empleado');
    }


    async function fillTable(form = null) {
        // Se inicializa el contenido de la tabla.
        TBODY_ROWS.innerHTML = '';
        RECORDS.textContent = '';
        // Se verifica la acción a realizar.
        (form) ? action = 'search' : action = 'readAll';
        // Petición para obtener los registros disponibles.
        const JSON = await dataFetch(DETALLEINSCRIPCION_API, action, form);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        TBODY_ROWS.innerHTML += `
        <tr>
        
            <td>${row.fecha_inicio}</td>
            <td>${row.dia}</td>
            <td>${row.descripcion}</td>
            <td>${row.id_inscripcion}</td>
            <td>${row.nombre_com_empleado}</td>
            
            <td>
        
                <button onclick="openReport(${row.id_detalle_inscripcion})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
        
        
                <button type="button" class="btn " onclick="openUpdate(${row.id_detalle_inscripcion})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDelete(${row.id_detalle_inscripcion})" class="btn"><img height="20px" width="20px"
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
            FORM.append('id_paquete', id);
            // Petición para obtener los datos del registro solicitado.
            const JSON = await dataFetch(DETALLEINSCRIPCION_API, 'readOne', FORM);
            // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
            if (JSON.status) {
                SAVE_MODAL.show();
                // Se asigna título para la caja de diálogo.
                MODAL_TITLE.textContent = 'Actualizar Detalle inscripcion';
                // Se inicializan los campos del formulario.
                document.getElementById('id').value = JSON.dataset.id_vehiculo;
                document.getElementById('descripcion').value = JSON.dataset.descripcion;
                document.getElementById('valorpaquete').value = JSON.dataset.valor_paquete;
                document.getElementById('cantidadclases').value = JSON.dataset.cantidad_clase;
                fillSelect(PAQUETE_API, 'getTransmision', 'transmision', JSON.dataset.transmision);
                fillSelect(TIPOPAQUETE_API, 'readAll', 'tipopaquete', JSON.dataset.id_tipo_paquete);
                ;
            } else {
                sweetAlert(2, JSON.exception, false);
            }
        }


        async function openDelete(id) {
            // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
            const RESPONSE = await confirmAction('¿Desea eliminar el vehiculo de forma permanente?');
            // Se verifica la respuesta del mensaje.
            if (RESPONSE) {
                // Se define una constante tipo objeto con los datos del registro seleccionado.
                const FORM = new FormData();
                FORM.append('id_paquete', id);
                // Petición para eliminar el registro seleccionado.
                const JSON = await dataFetch(DETALLEINSCRIPCION_API, 'delete', FORM);
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