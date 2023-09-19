const NOTIFICACION_API = 'business/privado/notificacion.php';
const REGISTRTOS_FALLIDOS_API = 'business/privado/registros_intentos.php';

const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

const TBODY_ROWS_F= document.getElementById('tbodys-rows');
const RECORDS_F= document.getElementById('recordss');

document.addEventListener('DOMContentLoaded', () => {
    // Llena la tabla con los registros que existan.
    fillTable();
    fillTableFalliidos();
});

async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(NOTIFICACION_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
                    
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.accion}</td>
                <td>${row.fecha_registro}</td>
                <td>${row.hora}</td>
                <td>
            </tr>
            `;
        });
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

async function fillTableFalliidos(form = null) {
    TBODY_ROWS_F.innerHTML = '';
    RECORDS_F.textContent = '';
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(REGISTRTOS_FALLIDOS_API, action, form);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
                    
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_F.innerHTML += `
            <tr>
                <td>${row.usuario}</td>
                <td>${row.accion}</td>
                <td>${row.fecha_realizado}</td>
                <td>${row.estado_usuario}</td>
                <td>
            </tr>
            `;
        });
        RECORDS_F.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}