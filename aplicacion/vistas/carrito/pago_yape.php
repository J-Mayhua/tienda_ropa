<!-- aplicacion/vistas/carrito/pago_yape.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<h1>Pago con Yape</h1>
<p>Total a pagar: S/ <?php echo htmlspecialchars(number_format($_SESSION['total_pedido'], 2), ENT_QUOTES, 'UTF-8'); ?></p>

<?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

<!-- Mostrar número de Yape o código QR -->
<div class="info-pago">
    <h2>Realiza el pago a:</h2>
    <p>Número de Yape: <strong>999 888 777</strong></p>
    <p>O escanea el siguiente código QR:</p>
    <img src="../publico/recursos/imagenes/qr_23.png" alt="Código QR de Yape" class="qr-yape">
</div>

<!-- Formulario para subir comprobante -->
<<<<<<< HEAD
<form action="/Tienda_ropa/publico/index.php?accion=procesar_pago_yape" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <label for="comprobante">Subir comprobante de pago:</label>
    <input type="file" id="comprobante" name="comprobante" accept="image/*" required>
=======
<form action="/Tienda_ropa/publico/index.php?accion=procesar_pago_yape" method="post" enctype="multipart/form-data" class="form-card">
    <div class="form-group">
        <label for="comprobante">Subir comprobante de pago:</label>
        <input type="file" id="comprobante" name="comprobante" accept="image/*" required>
    </div>
>>>>>>> agents/css-redesign-ecommerce-visual-update

    <div class="form-actions">
        <button type="submit" class="btn">Enviar comprobante</button>
    </div>
</form>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>