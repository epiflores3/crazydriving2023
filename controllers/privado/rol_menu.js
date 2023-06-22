const ROLMENU_API = 'business/privado/rol_menu.php';
const ROL_API = 'business/privado/roles.php';
const MENU_API = 'business/privado/menu.php';


const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregar'));
const SAVE_FORM = document.getElementById('save-form');
const MODAL_TITLE = document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

document.addEventListener('DOMContentLoaded', () => {
    
    fillTable();
    });

    SAVE_FORM.addEventListener('submit', async (event) => {
        event.preventDefault();
        (document.getElementById('id').value) ? action = 'update' : action = 'create';
        const FORM = new FormData(SAVE_FORM);
        const JSON = await dataFetch(ROLMENU_API, action, FORM);
        if (JSON.status) {
            SAVE_MODAL.hide();
            fillTable();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    });

    function openCreate() {

        SAVE_FORM.reset();
        MODAL_TITLE.textContent = 'Crear permisos para menus';
        fillSelect(ROL_API, 'readAll', 'rol');
        fillSelect(MENU_API, 'readAll', 'menu');
    }


    async function fillTable(form = null) {
        TBODY_ROWS.innerHTML = '';
        RECORDS.textContent = '';
        (form) ? action = 'search' : action = 'readAll';
        const JSON = await dataFetch(ROLMENU_API, action, form);
        if (JSON.status) {
        JSON.dataset.forEach(row => {
        TBODY_ROWS.innerHTML += `
        <tr>
        
        
            <td>${row.rol}</td>
            <td>${row.menu}</td>
            
            <td>
        
                <button onclick="openReport(${row.id_rol_menu})" type="button" class="btn ">
                    <img height="1px" width="1px" src="../../resource/img/imgtablas/ojo.png" alt="ver">
                </button>
        
        
                <button type="button" class="btn " onclick="openUpdate(${row.id_rol_menu})">
                    <img height="20px" width="20px" src="../../resource/img/imgtablas/update.png" alt="actualizar">
                </button>
        
                <button onclick="openDelete(${row.id_rol_menu})" class="btn"><img height="20px" width="20px"
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
            FORM.append('id_rol_menu', id);
            const JSON = await dataFetch(ROLMENU_API, 'readOne', FORM);
            if (JSON.status) {
                SAVE_MODAL.show();
                MODAL_TITLE.textContent = 'Actualizar Rol menu';
                document.getElementById('id').value = JSON.dataset.id_rol_menu;
                fillSelect(ROL_API, 'readAll', 'rol', JSON.dataset.id_rol);
                fillSelect(MENU_API, 'readAll', 'menu', JSON.dataset.id_menu);
                ;
            } else {
                sweetAlert(2, JSON.exception, false);
            }
        }


        async function openDelete(id) {
            const RESPONSE = await confirmAction('¿Desea eliminar el permiso de forma permanente?');
            if (RESPONSE) {
                const FORM = new FormData();
                FORM.append('id_rol_menu', id);
                const JSON = await dataFetch(ROLMENU_API, 'delete', FORM);
                if (JSON.status) {
                    fillTable();
                    sweetAlert(1, JSON.message, true);
                } else {
                    sweetAlert(2, JSON.exception, false);
                }
            }
        }