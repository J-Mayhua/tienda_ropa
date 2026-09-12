<?php
// aplicacion/vistas/carrito/ver.php
require_once __DIR__ . '/../plantillas/cabecera.php';
?>

<?php
// Verificar si el carrito está vacío
if (empty($productosCarrito)) {
    echo "<div class='contenedor'><p class='mensaje-carrito-vacio'>El carrito está vacío.</p></div>";
} else {
    echo "<div class='contenedor'>";
    echo "<h1 class='titulo-carrito'>Tu Carrito</h1>";
    echo "<div class='productos-carrito'>";

    foreach ($productosCarrito as $producto) {
        echo "<div class='producto-carrito'>";
        echo "<img src='" . htmlspecialchars($producto['imagen']) . "' alt='" . htmlspecialchars($producto['nombre']) . "' class='producto-img'>";
        echo "<div class='producto-info'>";
        echo "<h2>" . htmlspecialchars($producto['nombre']) . "</h2>";
        echo "<p>" . htmlspecialchars($producto['descripcion']) . "</p>";
        echo "<p>Cantidad: " . htmlspecialchars($producto['cantidad']) . "</p>";
        echo "<p>Precio unitario: $" . number_format($producto['precio'], 2) . "</p>";
        echo "<p>Subtotal: $" . number_format($producto['subtotal'], 2) . "</p>";
        echo "<a href='/Tienda_ropa/publico/index.php?accion=eliminar_del_carrito&id=" . $producto['id'] . "' class='btn btn-peligro'>Eliminar</a>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";

    $totalCarrito = array_sum(array_column($productosCarrito, 'subtotal'));
    echo "<div class='total-carrito'>";
    echo "<h3>Total del carrito: $" . number_format($totalCarrito, 2) . "</h3>";
    echo "<form action='/Tienda_ropa/publico/index.php?accion=finalizar_compra' method='post' class='form-card compact-form'>";
    echo "<div class='form-actions'>";
    echo "<input type='submit' value='Finalizar Pedido' class='btn-finalizar-compra'>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
}

require_once __DIR__ . '/../plantillas/pie.php';
?>