<!-- aplicacion/vistas/pedidos/metodo_pago.php -->
<?php include '../plantillas/cabecera.php'; ?>

<h1>Selecciona tu Método de Pago</h1>
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
</form>

<?php include '../plantillas/pie.php'; ?>