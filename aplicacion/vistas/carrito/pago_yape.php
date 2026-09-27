<!-- aplicacion/vistas/carrito/pago_yape.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/pago_yape.css">

<div class="contenedor contenedor--pago">

    <h1 class="titulo-pago">Pago con Yape</h1>

    <p class="total-pago">
        Total a pagar: <strong>S/ <?php echo htmlspecialchars(number_format($_SESSION['total_pedido'], 2), ENT_QUOTES, 'UTF-8'); ?></strong>
    </p>

    <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

    <!-- Datos de pago -->
    <div class="info-pago">
        <h2>Realiza el pago a:</h2>
        <p class="info-pago__numero">Número de Yape: <strong>999 888 777</strong></p>
        <p class="info-pago__ayuda">O escanea el siguiente código QR:</p>
        <img src="../publico/recursos/imagenes/qr_23.png" alt="Código QR de Yape" class="qr-yape">
    </div>

    <!-- Formulario para subir comprobante -->
    <form action="/Tienda_ropa/publico/index.php?accion=procesar_pago_yape" method="post" enctype="multipart/form-data" class="form-card">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="comprobante">Subir comprobante de pago:</label>
            <input type="file" id="comprobante" name="comprobante" accept="image/*" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Enviar comprobante</button>
        </div>
    </form>

</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
