const FALTANTE_API = 'business/privado/faltante.php';
const SESION_API = 'business/privado/sesion.php';

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));

const CMB_SESION = document.getElementById('sesion');

const SEARCH_MODAL_FORM = document.getElementById('searchmodal2');

const MODAL_TITLE = document.getElementById('modal-title');

const SAVE_FORM = document.getElementById('save-form');

const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');


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
        const JSON = await dataFetch(FALTANTE_API, action, FORM);
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


    CMB_SESION.addEventListener('change', async () =>{
        const info = document.getElementById('result');
       
        info.textContent = '';
       
        //constante para obtener el valor selecionado del combobux
        var ValorOpcion = CMB_SESION.options[CMB_SESION.selectedIndex].value;
        console.log(ValorOpcion);

        const FORM = new FormData();
        FORM.append('id_sesion', ValorOpcion);

        const JSON = await dataFetch(SESION_API, 'readOne', FORM);

        if (JSON.status) {
            
            info.textContent = 
            'Sesion: '+JSON.dataset.id_sesion+' '+'Hora de inicio estipulada: '+JSON.dataset.hora_inicio+' '+'Hora de fin estipulada: '+JSON.dataset.hora_fin+' '+'Asistencia: '+JSON.dataset.asistencia+' '+'Tipo de clase :'+JSON.dataset.tipo_clase+' '+'Día: '+JSON.dataset.dia+' '+'Asesor: '+JSON.dataset.nombre_com_empleado+'  '+'Placa del vehiculo: '+JSON.dataset.placa
           
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
    );
    
//PARA EL BUSCADOR DEL MODAL
SEARCH_MODAL_FORM.addEventListener('submit', async(event) => {
        // Se evita recargar la página web después de enviar el formulario.
        event.preventDefault();
        // Constante tipo objeto con los datos del formulario.
        const FORM = new FormData(SEARCH_MODAL_FORM);
        // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
        const JSON = await dataFetch(FALTANTE_API, 'searchModal', FORM);

        if (JSON.status) {
            // console.log(JSON.dataset.dui_cliente);
           fillSelect2(FALTANTE_API, 'cargarSelect', 'sesion',JSON.dataset.dui_cliente);
        } else {
            
        }

    });

//   async function buscadormodal (id){

//     const FORM = new FormData();
//     FORM.append('id_cliente', id);
//     const JSON = await dataFetch(CLIENTE_API, 'readOne', FORM);
//   }

    

    async function fillTable(form = null) {
        // Se inicializa el contenido de la tabla.
        TBODY_ROWS.innerHTML = '';
        RECORDS.textContent = '';
        // Se verifica la acción a realizar.
        (form) ? action = 'search' : action = 'readAll';
        // Petición para obtener los registros disponibles.
        const JSON = await dataFetch(FALTANTE_API, action, form);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
        // Se crean y concatenan las filas de la tabla con los datos de cada registro.
        TBODY_ROWS.innerHTML += `
        <tr>
        
            <td>${row.cantidad_minuto}</td>
            <td>${row.id_sesion}</td>
    
            <td>
        
                <button onclick="openReport(${row.id_faltante})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
        
        
                <button type="button" class="btn " onclick="openUpdate(${row.id_faltante})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDelete(${row.id_faltante})" class="btn"><img height="20px" width="20px"
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
        MODAL_TITLE.textContent = 'Crear faltante';
        fillSelect2(SESION_API, 'readAll', 'sesion');
    
    }

    
    async function openUpdate(id) {
        const FORM = new FormData();
        FORM.append('id_faltante', id);
        const JSON = await dataFetch(FALTANTE_API, 'readOne', FORM);
        if (JSON.status) {
            SAVE_MODAL.show();
            MODAL_TITLE.textContent = 'Actualizar faltante';
            document.getElementById('id').value = JSON.dataset.id_faltante;
            document.getElementById('cantidad').value = JSON.dataset.cantidad_minuto;
            fillSelect2(FALTANTE_API, 'cargarSelect', 'sesion',JSON.dataset.dui_cliente, JSON.dataset.id_sesion);
            const info = document.getElementById('result');
            info.textContent = '';
            const FORM2 = new FormData();
            FORM2.append('id_sesion', JSON.dataset.id_sesion);
            const JSON2 = await dataFetch(SESION_API, 'readOne', FORM2);
            if (JSON2.status) {
                info.textContent = 
                'Sesion: '+JSON2.dataset.id_sesion+' '+'Hora de inicio estipulada: '+JSON2.dataset.hora_inicio+' '+'Hora de fin estipulada: '+JSON2.dataset.hora_fin+' '+'Asistencia: '+JSON2.dataset.asistencia+' '+'Tipo de clase :'+JSON2.dataset.tipo_clase+' '+'Día: '+JSON2.dataset.dia+' '+'Asesor: '+JSON2.dataset.nombre_com_empleado+'  '+'Placa del vehiculo: '+JSON2.dataset.placa
            } else {
                sweetAlert(2, JSON2.exception, false);
            }
       

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
            FORM.append('id', id);
            // Petición para eliminar el registro seleccionado.
            const JSON = await dataFetch(FALTANTE_API, 'delete', FORM);
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
    


      