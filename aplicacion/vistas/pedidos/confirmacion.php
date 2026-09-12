<!-- aplicacion/vistas/pedidos/confirmacion.php -->
<?php include '../plantillas/cabecera.php'; ?>

<h1>Confirmación de Compra</h1>
<p>Gracias por tu compra. Tu pedido ha sido registrado con el número: <strong>#<?php echo htmlspecialchars($pedido_id, ENT_QUOTES, 'UTF-8'); ?></strong></p>

<h2>Detalles del Pedido</h2>
<table border="1">
    <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($detalles as $detalle): ?>
    <tr>
        <td><?php echo htmlspecialchars($detalle['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($detalle['cantidad'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td>$<?php echo htmlspecialchars($detalle['precio_unitario'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td>$<?php echo htmlspecialchars($detalle['cantidad'] * $detalle['precio_unitario'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td><strong>$<?php echo htmlspecialchars($total, ENT_QUOTES, 'UTF-8'); ?></strong></td>
    </tr>
</table>

<a href="/tienda_ropa/publico/index.php">Volver al catálogo</a>

<?php include '../plantillas/pie.php'; ?>