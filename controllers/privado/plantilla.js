const HEADER = document.querySelector('header');
const NAV = document.querySelector('nav');


// HEADER.innerHTML = `
// <a href="#" class="brand">
// <i class='bx bxs-car-crash'></i>
// <span class="text">Crazy driving</span>
// </a>
// <ul class="side-menu top">
// <li class="active">

//     <a href="pagina_principal.html">
//         <i class='bx bxs-dashboard' ></i>
//         <span class="text">Inicio</span>
//     </a>
// </li>

// <li>
//     <a href="cliente.html">
//         <i class='bx bxs-group' ></i>
//         <span class="text">Cliente</span>
//     </a>
// </li>

// <li>
//     <a href="telefono.html">
//         <i class='bx bxs-phone' ></i>
//         <span class="text">Teléfono</span>
//     </a>
// </li>

// <li>
//     <a href="responsable_menor.html">
//         <i class='bx bxs-user-pin' ></i>
//         <span class="text">Responsable menor</span>
//     </a>
// </li>

// <li>
//     <a href="inscripcion.html">
//         <i class='bx bxs-pencil' ></i>
//         <span class="text">Inscripción</span>
//     </a>
// </li>

// <li>
//     <a href="paquete.html">
//         <i class='bx bxs-package' ></i>
//         <span class="text">Paquete</span>
//     </a>
// </li>

// <li>
//     <a href="tipo_paquete.html">
//         <i class='bx bxs-copy-alt' ></i>
//         <span class="text">Tipo paquete</span>
//     </a>
// </li>

// <li>
//     <a href="horario.html">
//         <i class='bx bxs-time' ></i>
//         <span class="text">Horario</span>
//     </a>
// </li>

// <li>
//     <a href="sesion.html">
//         <i class='bx bxs-analyse' ></i>
//         <span class="text">Sesión</span>
//     </a>
// </li>

// <li>
//     <a href="faltante.html">
//         <i class='bx bxs-time-five' ></i>
//         <span class="text">Faltante</span>
//     </a>
// </li>

// <li>
//     <a href="marca.html">
//         <i class='bx bxs-car' ></i>
//         <span class="text">Marca</span>
//     </a>
// </li>

// <li>
//     <a href="modelo.html">
//         <i class='bx bxs-car' ></i>
//         <span class="text">Modelo</span>
//     </a>
// </li>

// <li>
//     <a href="vehiculo.html">
//         <i class='bx bxs-car' ></i>
//         <span class="text">Vehículo</span>
//     </a>
// </li>

// <li>
//     <a href="empleado.html">
//         <i class='bx bxs-user' ></i>
//         <span class="text">Empleado</span>
//     </a>
// </li>

// <li>
//     <a href="sucursal.html">
//         <i class='bx bxs-been-here' ></i>
//         <span class="text">Sucursal</span>
//     </a>
// </li>


// <li>
//     <a href="usuario.html">
//         <i class='bx bxs-user-circle' ></i>
//         <span class="text">Usuario</span>
//     </a>
// </li>

// <li>
//     <a href="rol.html">
//         <i class='bx bxs-calendar-edit' ></i>
//         <span class="text">Rol</span>
//     </a>
// </li>

// <li>
//     <a href="menu.html">
//         <i class='bx bxs-calendar-event' ></i>
//         <span class="text">Menú</span>
//     </a>
// </li>

// <li>
//     <a href="afp.html">
//         <i class='bx bxs-calendar-event' ></i>
//         <span class="text">AFP</span>
//     </a>
// </li>

// <li>
//     <a href="rol_menu.html">
//         <i class='bx bxs-food-menu' ></i>
//         <span class="text">Rol menú</span>
//     </a>
// </li>

// </ul>
// <ul class="side-menu">
// <li>
//     <a href="editar_perfil.html">
//         <i class='bx bxs-cog' ></i>
//         <span class="text">Ajustes</span>
//     </a>
// </li>
// <li>
//     <a href="#" class="logout" onclick="logOut()">
//         <i class='bx bxs-log-out-circle' ></i>
//         <span class="text">Cerrar sesión</span>
//     </a>
// </li>
// </ul>

// `;

// NAV.innerHTML = `
// <i class='bx bx-menu' ></i>
// <div class="invisible">
// <a href="#" class="nav-link" >Categories</a>
// </div>
// <form action="#" class="invisible">
//     <div class="form-input">
//         <input type="search" placeholder="Buscar...">
//         <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
//     </div>
// </form>
// <input type="checkbox" id="switch-mode" hidden>
// <label for="switch-mode" class="switch-mode"></label>
// <a href="#" class="notification">
//     <i class='bx bxs-bell' ></i>
//     <span class="num">8</span>
// </a>
// <a href="#" class="profile">
//     <img src="img/people.png">
// </a>
// `;

document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (JSON.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            HEADER.innerHTML = `
            <a href="#" class="brand">
            <i class='bx bxs-car-crash'></i>
            <span class="text">Crazy driving</span>
            </a>
            <ul class="side-menu top">
            <li class="active">
            
                <a href="pagina_principal.html">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Inicio</span>
                </a>
            </li>
            
            <li>
                <a href="cliente.html">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Cliente</span>
                </a>
            </li>
            
            <li>
                <a href="telefono.html">
                    <i class='bx bxs-phone' ></i>
                    <span class="text">Teléfono</span>
                </a>
            </li>
            
            <li>
                <a href="responsable_menor.html">
                    <i class='bx bxs-user-pin' ></i>
                    <span class="text">Responsable menor</span>
                </a>
            </li>
            
            <li>
                <a href="inscripcion.html">
                    <i class='bx bxs-pencil' ></i>
                    <span class="text">Inscripción</span>
                </a>
            </li>
            
            <li>
                <a href="paquete.html">
                    <i class='bx bxs-package' ></i>
                    <span class="text">Paquete</span>
                </a>
            </li>
            
            <li>
                <a href="tipo_paquete.html">
                    <i class='bx bxs-copy-alt' ></i>
                    <span class="text">Tipo paquete</span>
                </a>
            </li>
            
            <li>
                <a href="horario.html">
                    <i class='bx bxs-time' ></i>
                    <span class="text">Horario</span>
                </a>
            </li>
            
            <li>
                <a href="sesion.html">
                    <i class='bx bxs-analyse' ></i>
                    <span class="text">Sesión</span>
                </a>
            </li>
            
            <li>
                <a href="faltante.html">
                    <i class='bx bxs-time-five' ></i>
                    <span class="text">Faltante</span>
                </a>
            </li>
            
            <li>
                <a href="marca.html">
                    <i class='bx bxs-car' ></i>
                    <span class="text">Marca</span>
                </a>
            </li>
            
            <li>
                <a href="modelo.html">
                    <i class='bx bxs-car' ></i>
                    <span class="text">Modelo</span>
                </a>
            </li>
            
            <li>
                <a href="vehiculo.html">
                    <i class='bx bxs-car' ></i>
                    <span class="text">Vehículo</span>
                </a>
            </li>
            
            <li>
                <a href="empleado.html">
                    <i class='bx bxs-user' ></i>
                    <span class="text">Empleado</span>
                </a>
            </li>
            
            <li>
                <a href="sucursal.html">
                    <i class='bx bxs-been-here' ></i>
                    <span class="text">Sucursal</span>
                </a>
            </li>
            
            
            <li>
                <a href="usuario.html">
                    <i class='bx bxs-user-circle' ></i>
                    <span class="text">Usuario</span>
                </a>
            </li>
            
            <li>
                <a href="rol.html">
                    <i class='bx bxs-calendar-edit' ></i>
                    <span class="text">Rol</span>
                </a>
            </li>
            
            <li>
                <a href="menu.html">
                    <i class='bx bxs-calendar-event' ></i>
                    <span class="text">Menú</span>
                </a>
            </li>
            
            <li>
                <a href="afp.html">
                    <i class='bx bxs-calendar-event' ></i>
                    <span class="text">AFP</span>
                </a>
            </li>
            
            <li>
                <a href="rol_menu.html">
                    <i class='bx bxs-food-menu' ></i>
                    <span class="text">Rol menú</span>
                </a>
            </li>
            
            </ul>
            <ul class="side-menu">
            <li>
                <a href="editar_perfil.html">
                    <i class='bx bxs-cog' ></i>
                    <span class="text">Ajustes</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout" onclick="logOut()">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Cerrar sesión</span>
                </a>
            </li>---
            </ul>
                 
            `;

            NAV.innerHTML = `
            <i class='bx bx-menu' ></i>
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
        clearInterval(heartbeat);
        sweetAlert(3, DATA.exception, false, 'index.html');
    }
}


const heartbeat = setInterval(() => {
    checkSessionTime();
}, 300000);// <-- Cada 2 segundos verifica si aun hay sesión





const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item => {
    const li = item.parentElement;

    item.addEventListener('click', function () {
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        })
        li.classList.add('active');
    })
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
})




const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
})





if (window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if (window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
    if (this.checked) {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
})