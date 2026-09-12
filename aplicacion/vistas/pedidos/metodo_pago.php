<!-- aplicacion/vistas/pedidos/metodo_pago.php -->
<?php include '../plantillas/cabecera.php'; ?>

<h1>Selecciona tu Método de Pago</h1>
<<<<<<< HEAD
<form method="POST" action="/tienda_ropa/publico/index.php?accion=procesar_pago">
    <?php echo csrf_field(); ?>
    <p>Los campos marcados con * son obligatorios.</p>
    <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8'); ?>">
    
    <label for="metodo_pago_yape">
        <input type="radio" id="metodo_pago_yape" name="metodo_pago" value="yape" required> Yape <span aria-hidden="true">*</span>
    </label>
    <br>
    <label for="metodo_pago_efectivo">
        <input type="radio" id="metodo_pago_efectivo" name="metodo_pago" value="efectivo"> Efectivo (contra entrega)
    </label>
    <br>
    <button type="submit">Continuar</button>
=======
<form method="POST" action="/tienda_ropa/publico/index.php?accion=procesar_pago" class="form-card">
    <input type="hidden" name="pedido_id" value="<?php echo $_GET['id']; ?>">
    
    <div class="form-group">
        <label>
            <input type="radio" name="metodo_pago" value="yape" required> Yape
        </label>
    </div>
    <div class="form-group">
        <label>
            <input type="radio" name="metodo_pago" value="efectivo"> Efectivo (contra entrega)
        </label>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn">Continuar</button>
    </div>
>>>>>>> agents/css-redesign-ecommerce-visual-update
</form>

<?php include '../plantillas/pie.php'; ?>