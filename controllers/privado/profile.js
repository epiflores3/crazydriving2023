 const EMPLEADO_API = 'business/privado/empleado.php';

const PROFILE_FORM = document.getElementById('profile-form');

const PASSWORD_FORM = document.getElementById('password-form')

const PASSWORD_MODAL = new bootstrap.Modal(document.getElementById('agregar'));


document.addEventListener('DOMContentLoaded', async () => {
   
    const JSON = await dataFetch(USER_API, 'readProfile');
   
    if (JSON.status) {
      
        document.getElementById('fechacreacion').value = JSON.dataset.fecha_creacion;
        document.getElementById('fechacreacion').disabled = true;
        document.getElementById('correo').value = JSON.dataset.correo_usuario;
        document.getElementById('alias').value = JSON.dataset.alias_usuario;
        fillSelect(EMPLEADO_API, 'readAll', 'idempleado', JSON.dataset.id_empleado);
        document.getElementById('idempleado').disabled = true;
    
       
    } else {
        sweetAlert(2, JSON.exception, null);
    }
});

PROFILE_FORM.addEventListener('submit', async (event) => {
   
    event.preventDefault();
    
    const FORM = new FormData(PROFILE_FORM);

    const JSON = await dataFetch(USER_API, 'editProfile', FORM);
    
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'pagina_principal.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


PASSWORD_FORM.addEventListener('submit', async (event) => {
   
    event.preventDefault();
  
    const FORM = new FormData(PASSWORD_FORM);

    const JSON = await dataFetch(USER_API, 'changePassword', FORM);

    if (JSON.status) {
      
        PASSWORD_MODAL.hide();
    
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


function openPassword() {

    PASSWORD_MODAL.show();
  
     PASSWORD_MODAL.hide();
}