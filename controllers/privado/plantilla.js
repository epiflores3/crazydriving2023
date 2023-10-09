
const HEADER = document.querySelector('header');
const NAV = document.querySelector('nav');



document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (JSON.session) {
        setInterval(() => {
            checkSessionTime();
        }, 300000);// <-- Cada 2 segundos verifica si aun hay sesión
        // 300000

        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            HEADER.innerHTML = `
            <a href="#" class="material-symbols-outlined">
            <i class='fa-solid fa-car-burst fa-2xl'></i>
            <span class="text">Crazy driving</span>
            </a>
            <ul class="side-menu top">
            <li class="active">
            
                <a href="pagina_principal.html">
                <i class="fa-solid fa-house"></i>
                    <span class="text">Inicio</span>
                </a>
            </li>
            
            <li>
                <a href="cliente.html">
                    <i class="fa-solid fa-user-plus"></i>
                    <span class="">Cliente</span>
                </a>
            </li>
 
            <li>
                <a href="inscripcion.html">
                <i class="fa-solid fa-id-card"></i>
                    <span class="text">Inscripción</span>
                </a>
            </li>
            
            <li>
                <a href="paquete.html">
                <i class="fa-solid fa-box-open"></i>
                    <span class="text">Paquete</span>
                </a>
            </li>

            <li>
                <a href="sesion.html">
                <i class="fa-solid fa-book-bookmark"></i>
                    <span class="text">Sesión</span>
                </a>
            </li>
            
            <li>
                <a href="modelo.html">
                <i class="fa-solid fa-car-on"></i>
                    <span class="text">Modelo</span>
                </a>
            </li>
            
            <li>
                <a href="empleado.html">
                <i class="fa-solid fa-users-gear"></i>
                    <span class="text">Empleado</span>
                </a>
            </li>
            
            <li>
                <a href="usuario.html">
                <i class="fa-solid fa-id-card-clip"></i>
                    <span class="text">Usuario</span>
                </a>
            </li>
            
            </ul>
            <ul class="side-menu">
            <li>
                <a href="editar_perfil.html">
                <i class="fa-solid fa-user-pen"></i>
                    <span class="text">Ajustes</span>
                </a>
            </li>

            <li>
                <a href="#" class="logout" onclick="logOut()">
                <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="text">Cerrar sesión</span>
                </a>
            </li>
            </ul>
                 
            `;

            NAV.innerHTML = `
            <i class="fa-solid fa-bars"></i>
            <div class="invisible">
            <a href="#" class="nav-link" >Categories</a>
            </div>
            <form action="#" class="invisible">
                <div class="form-input">
                    <input type="search" placeholder="Buscar...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell' ></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="img/people.png">
            </a>
            `;

        } else {
            sweetAlert(3, JSON.exception, false, 'index.html');
        }
    } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname != '/crazydriving2023/view/privado/index.html') {
            location.href = 'index.html';
        }
    }
});

async function checkSessionTime() {
    //Solo un ejémplo de un ajax
    const DATA = await dataFetch(USER_API, 'checkSessionTime');
    if (DATA.status) {
        console.log(DATA.message);// <-- Aquí sabemos que no es válida
    } else {
        clearInterval();
        sweetAlert(3, DATA.exception, false, 'index.html');
    }
}


// const heartbeat = setInterval(() => {
//     checkSessionTime();
// }, 300000);// <-- Cada 2 segundos verifica si aun hay sesión





// const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

// allSideMenu.forEach(item => {
//     const li = item.parentElement;

//     item.addEventListener('click', function () {
//         allSideMenu.forEach(i => {
//             i.parentElement.classList.remove('active');
//         })
//         li.classList.add('active');
//     })
// });




// // TOGGLE SIDEBAR
// const menuBar = document.querySelector('#content nav .fa-solid fa-bars');
// const sidebar = document.getElementById('sidebar');

// menuBar.addEventListener('click', function () {
//     sidebar.classList.toggle('hide');
// })




// const searchButton = document.querySelector('#content nav form .form-input button');
// const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
// const searchForm = document.querySelector('#content nav form');

// searchButton.addEventListener('click', function (e) {
//     if (window.innerWidth < 576) {
//         e.preventDefault();
//         searchForm.classList.toggle('show');
//         if (searchForm.classList.contains('show')) {
//             searchButtonIcon.classList.replace('bx-search', 'bx-x');
//         } else {
//             searchButtonIcon.classList.replace('bx-x', 'bx-search');
//         }
//     }
// })





// if (window.innerWidth < 768) {
//     sidebar.classList.add('hide');
// } else if (window.innerWidth > 576) {
//     searchButtonIcon.classList.replace('bx-x', 'bx-search');
//     searchForm.classList.remove('show');
// }


// window.addEventListener('resize', function () {
//     if (this.innerWidth > 576) {
//         searchButtonIcon.classList.replace('bx-x', 'bx-search');
//         searchForm.classList.remove('show');
//     }
// })



// const switchMode = document.getElementById('switch-mode');

// switchMode.addEventListener('change', function () {
//     if (this.checked) {
//         document.body.classList.add('dark');
//     } else {
//         document.body.classList.remove('dark');
//     }
// })