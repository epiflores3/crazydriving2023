
const NOTIFICACION_API = 'business/privado/notificacion.php';
    
document.addEventListener('DOMContentLoaded', async() => {
    const FORM = new FormData();
    FORM.append('accion', 'Se trato de acceder a archivos que no se encuentran');
    const JSON = await dataFetch(NOTIFICACION_API, 'notifi', FORM);
    // Se comprueba si la respuesta es correcta, sino muestra un mensaje de error.
    if (JSON.status) {
        console.log('creado');
    }

});
