const HEADER = document.querySelector('header');
const NAV = document.querySelector('nav');


HEADER.innerHTML = `
<a href="#" class="brand">
<i class='bx bxs-car-crash'></i>
<span class="text">Crazy driving</span>
</a>
<ul class="side-menu top">
<li class="active">

    <a href="pagina_principal.html">
        <i class='bx bxs-dashboard' ></i>
        <span class="text">Dashboard</span>
    </a>
</li>

<li>
    <a href="marca.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Marca</span>
    </a>
</li>

<li>
    <a href="responsable_menor.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Responsable Menor</span>
    </a>
</li>

<li>
    <a href="faltante.html">
        <i class='bx c-package' ></i>
        <span class="text">Faltante</span>
    </a>
</li>

<li>
    <a href="horario.html">
        <i class='bx bxs-user-circe' ></i>
        <span class="text">Horario</span>
    </a>
</li>

<li>
    <a href="cliente.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Cliente</span>
    </a>
</li>

<li>
    <a href="tipo_paquete.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Tipo paquete</span>
    </a>
</li>

<li>
    <a href="sucursal.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Sucursal</span>
    </a>
</li>
<li>
    <a href="rol.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Rol</span>
    </a>
</li>
<li>
    <a href="menu.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Menú</span>
    </a>
</li>
<li>
    <a href="modelo.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Modelo</span>
    </a>
</li>
<li>
    <a href="telefono.html">
        <i class='bx bxs-group' ></i>
        <span class="text">Telefono</span>
    </a>
</li>
<li>
    <a href="#">
        <i class='bx bxs-food-menu' ></i>
        <span class="text">Inscripción</span>
    </a>
</li>
<li>
    <a href="#">
        <i class='bx bxs-package' ></i>
        <span class="text">Paquete</span>
    </a>
</li>
<li>
    <a href="#">
        <i class='bx bxs-book-bookmark' ></i>
        <span class="text">Bitacora</span>
    </a>
</li>
<li>
    <a href="#">
        <i class='bx bxs-id-card' ></i>
        <span class="text">Empleado</span>
    </a>
</li>
<li>
    <a href="usuario.html">
        <i class='bx bxs-user-circle' ></i>
        <span class="text">Usuario</span>
    </a>
</li>
<li>
    <a href="vehiculo.html">
        <i class='bx bxs-user-circle' ></i>
        <span class="text">Vehiculo</span>
    </a>
</li>
</ul>
<ul class="side-menu">
<li>
    <a href="#">
        <i class='bx bxs-cog' ></i>
        <span class="text">Settings</span>
    </a>
</li>
<li>
    <a href="#" class="logout" onclick="logOut()">
        <i class='bx bxs-log-out-circle' ></i>
        <span class="text">Logout</span>
    </a>
</li>
</ul>
     
`;

NAV.innerHTML = `
<i class='bx bx-menu' ></i>
<a href="#" class="nav-link">Categories</a>
<form action="#">
    <div class="form-input">
        <input type="search" placeholder="Search...">
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




const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
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
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})