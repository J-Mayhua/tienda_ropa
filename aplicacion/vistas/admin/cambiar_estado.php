<?php
// aplicacion/vistas/admin/pedidos/cambiar_estado.php
require_once __DIR__ . '/../plantillas/cabecera.php';
?>
<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/cambiar_estado.css">

<div class="contenedor contenedor-principal contenedor--angosto">
    <h2>Cambiar Estado del Pedido #<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?></h2>

    <form action="/Tienda_ropa/publico/index.php?accion=cambiar_estado_pedido&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" class="form-card">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="estado"><i class="fas fa-truck"></i> Estado:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="pendiente" <?php echo ($pedido['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                
                <option value="completado" <?php echo ($pedido['estado'] == 'completado') ? 'selected' : ''; ?>>Completado</option>
                <option value="cancelado" <?php echo ($pedido['estado'] == 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Actualizar Estado</button>
            <a href="/Tienda_ropa/publico/index.php?accion=listar_pedidos" class="btn btn-secundario">Cancelar</a>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/../plantillas/pie.php';
?>
