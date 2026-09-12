// Efectos 3D para las tarjetas - más sutil
document.querySelectorAll('.tarjeta-producto').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        // Reducimos el efecto dividiendo por un número mayor (25 en lugar de 15)
        const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
        const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
        // Añadimos una transición más lenta para suavizar el movimiento
        card.style.transition = 'transform 0.3s ease';
        card.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
    });
    
    card.addEventListener('mouseleave', () => {
        // Aumentamos el tiempo de transición para un retorno más suave
        card.style.transition = 'transform 0.5s ease';
        card.style.transform = 'rotateY(0deg) rotateX(0deg)';
    });
});

// Filtros de categoría
document.querySelectorAll('.boton-categoria').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelector('.boton-categoria.activo').classList.remove('activo');
        this.classList.add('activo');
        
        // Aquí iría la lógica AJAX para filtrar
        console.log(`Filtrar por: ${this.textContent}`);
    });
});

// Nueva lógica para el botón de añadir al carrito - comprobar si está logueado
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const addButton = this.querySelector('.anadir-carrito');
            const isLoggedIn = addButton.getAttribute('data-logged-in') === 'true';
            
            if (isLoggedIn) {
                // Si está logueado, enviamos el formulario
                this.submit();
            } else {
                // Si no está logueado, redirigimos a la página de login
                window.location.href = "/Tienda_ropa/aplicacion/vistas/usuarios/login.php";
            }
        });
    });
});