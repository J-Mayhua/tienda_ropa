<?php
// aplicacion/vistas/carrito/ver.php
require_once __DIR__ . '/../plantillas/cabecera.php';
?>

<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/carrito.css">

<?php if (empty($productosCarrito)): ?>
    <p class="mensaje-carrito-vacio">El carrito está vacío.</p>
<?php else: ?>
    <h1 class="titulo-carrito">Tu Carrito</h1>

    <div class="productos-carrito">
        <?php foreach ($productosCarrito as $producto): ?>
            <div class="producto-carrito">
                <img
                    src="<?php echo htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8'); ?>"
                    alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>"
                    class="producto-img"
                >
                <div class="producto-info">
                    <h2><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars($producto['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Cantidad: <?php echo htmlspecialchars($producto['cantidad'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Precio unitario: $<?php echo htmlspecialchars(number_format($producto['precio'], 2), ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Subtotal: $<?php echo htmlspecialchars(number_format($producto['subtotal'], 2), ENT_QUOTES, 'UTF-8'); ?></p>

                    <form action="/Tienda_ropa/publico/index.php?accion=eliminar_del_carrito" method="post">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="submit" class="btn btn-peligro">Eliminar</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php $totalCarrito = array_sum(array_column($productosCarrito, 'subtotal')); ?>
    <div class="total-carrito">
        <h3>Total del carrito: $<?php echo htmlspecialchars(number_format($totalCarrito, 2), ENT_QUOTES, 'UTF-8'); ?></h3>

        <form action="/Tienda_ropa/publico/index.php?accion=vaciar_carrito" method="post">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-peligro">Vaciar carrito</button>
        </form>

        <form action="/Tienda_ropa/publico/index.php?accion=finalizar_compra" method="post">
            <?php echo csrf_field(); ?>
            <input type="submit" value="Finalizar Pedido" class="btn">
        </form>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
