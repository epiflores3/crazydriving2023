const HORARIOINCRIPCION_API = 'business/privado/horario_inscripcion.php';
const HORARIO_API = 'business/privado/horario.php';
const DETALLEINSCRIPCION_API = 'business/privado/detalle_inscripcion.php';

const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));

const SAVE_FORM = document.getElementById('save-form');

const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

const CMB_DETALLE = document.getElementById('detalleinscripcion');

const SEARCH_MODAL_FORM_DETALLE = document.getElementById('searchmodalDetalle');

const SEARCH_FORM = document.getElementById('search-form');


document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
    });

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
        const JSON = await dataFetch(HORARIOINCRIPCION_API, action, FORM);
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

    CMB_DETALLE.addEventListener('change', async () =>{
        const info = document.getElementById('result1');
       
        info.textContent = '';
       
        //constante para obtener el valor selecionado del combobux
        var ValorOpcion = CMB_DETALLE.options[CMB_DETALLE.selectedIndex].value;

        const FORM = new FormData();
        FORM.append('idhorarioinscripcion', ValorOpcion);

        const JSON = await dataFetch(DETALLEINSCRIPCION_API, 'readOne', FORM);

        if (JSON.status) {
            
            info.textContent = 
            'Detalle inscripcion: '+JSON.dataset.id_detalle_inscripcion+' '+'Fecha de inicio: '+JSON.dataset.fecha_inicio+' '+'Dia: '+JSON.dataset.dia+' '+'Descripcion: '+JSON.dataset.descripcion+' '+'Nombre de empleado :'+JSON.dataset.nombre_com_empleado
           
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
    );

    //PARA EL BUSCADOR DEL MODAL
    SEARCH_MODAL_FORM_DETALLE.addEventListener('submit', async(event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_MODAL_FORM_DETALLE);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    const JSON = await dataFetch(HORARIOINCRIPCION_API, 'searchModalDetalle', FORM);

    if (JSON.status) {
        // console.log(JSON.dataset.dui_cliente);
       fillSelect2(HORARIOINCRIPCION_API, 'cargarSelectDetalle', 'detalleinscripcion',JSON.dataset.dui_cliente);
    } else {
        
    }

});

    function openCreate() {

        SAVE_FORM.reset();
        // Se asigna título a la caja de diálogo.
        MODAL_TITLE.textContent = 'Crear horario inscripcion';
        fillSelect2(DETALLEINSCRIPCION_API, 'readAll', 'detalleinscripcion');
        fillSelect2(HORARIO_API, 'readAll', 'horario');
    
    }

    async function fillTable(form = null) {
        // Se inicializa el contenido de la tabla.
        TBODY_ROWS.innerHTML = '';
        RECORDS.textContent = '';
        // Se verifica la acción a realizar.
        (form) ? action = 'search' : action = 'readAll';
        // Petición para obtener los registros disponibles.
        const JSON = await dataFetch(HORARIOINCRIPCION_API, action, form);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        TBODY_ROWS.innerHTML += `
        <tr>
        
            <td>${row.id_detalle_inscripcion}</td>
            <td>${row.id_horario}</td>
    
            <td>
        
                <button onclick="openReport(${row.id_horario_inscripcion})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
        
        
                <button type="button" class="btn " onclick="openUpdate(${row.id_horario_inscripcion})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDelete(${row.id_horario_inscripcion})" class="btn"><img height="20px" width="20px"
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
        const FORM = new FormData();
        FORM.append('id', id);
        const JSON = await dataFetch(HORARIOINCRIPCION_API, 'readOne', FORM);
        if (JSON.status) {
            SAVE_MODAL.show();
            MODAL_TITLE.textContent = 'Actualizar horario inscripcion';
            document.getElementById('id').value = JSON.dataset.id_horario_inscripcion;
            fillSelect2(HORARIOINCRIPCION_API, 'cargarSelectDetalle', 'detalleinscripcion', JSON.dataset.dui_cliente, JSON.dataset.id_detalle_inscripcion);
            const info = document.getElementById('result1');
            info.textContent = '';
            const FORM2 = new FormData();
            FORM2.append('idhorarioinscripcion', JSON.dataset.id_detalle_inscripcion);
            const JSON2 = await dataFetch(DETALLEINSCRIPCION_API, 'readOne', FORM2);
           
            if (JSON2.status) {
                info.textContent = 
                'Detalle inscripcion: '+JSON2.dataset.id_detalle_inscripcion+' '+'Fecha de inicio: '+JSON2.dataset.fecha_inicio+' '+'Dia: '+JSON2.dataset.dia+' '+'Descripcion: '+JSON2.dataset.descripcion+' '+'Nombre de empleado :'+JSON2.dataset.nombre_com_empleado
            } else {
                sweetAlert(2, JSON2.exception, false);
            }
            fillSelect2(HORARIO_API, 'readAll', 'horario', JSON.dataset.id_horario);

        } else {
            sweetAlert(2, JSON.exception, false);
        }

    }


    async function openDelete(id) {
        // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
        const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
        // Se verifica la respuesta del mensaje.
        if (RESPONSE) {
            // Se define una constante tipo objeto con los datos del registro seleccionado.
            const FORM = new FormData();
            FORM.append('idhorarioiincripcion', id);
            // Petición para eliminar el registro seleccionado.
            const JSON = await dataFetch(HORARIOINCRIPCION_API, 'delete', FORM);
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
    


