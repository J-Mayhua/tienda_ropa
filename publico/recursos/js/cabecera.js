// /Tienda_ropa/publico/recursos/js/cabecera.js
// Controla el menú hamburguesa de la cabecera en móvil.
(function () {
    var boton = document.getElementById('menuToggle');
    var menu = document.getElementById('navegacionPrincipal');
    if (!boton || !menu) return;

    function cerrarMenu() {
        menu.classList.remove('abierta');
        boton.setAttribute('aria-expanded', 'false');
        var icono = boton.querySelector('i');
        if (icono) icono.className = 'fas fa-bars';
    }

    boton.addEventListener('click', function () {
        var abierto = menu.classList.toggle('abierta');
        boton.setAttribute('aria-expanded', abierto ? 'true' : 'false');
        var icono = boton.querySelector('i');
        if (icono) icono.className = abierto ? 'fas fa-xmark' : 'fas fa-bars';
    });

    // Cerrar el menú al elegir una opción
    menu.querySelectorAll('a').forEach(function (enlace) {
        enlace.addEventListener('click', cerrarMenu);
    });

    // Cerrar el menú si la ventana vuelve a tamaño de escritorio
    window.addEventListener('resize', function () {
        if (window.innerWidth > 992) {
            cerrarMenu();
        }
    });
})();
