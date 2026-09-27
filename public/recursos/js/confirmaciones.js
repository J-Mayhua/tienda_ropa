// /Tienda_ropa/publico/recursos/js/confirmaciones.js
// Intercepta clicks en cualquier enlace/botón con [data-confirmar] y
// pide confirmación antes de dejarlo continuar. Reemplaza el patrón
// onclick="return confirm(...)" que la CSP bloquea por ser inline.
document.addEventListener('click', function (evento) {
    var elemento = evento.target.closest('[data-confirmar]');
    if (!elemento) return;

    var mensaje = elemento.getAttribute('data-confirmar');
    if (!window.confirm(mensaje)) {
        evento.preventDefault();
    }
});
