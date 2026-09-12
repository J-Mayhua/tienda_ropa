<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<div class="contenedor">
    <h1>Mis Pedidos</h1>

    <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

    <?php if (!empty($pedidos)): ?>
        <div class="lista-pedidos">
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido-item">
                    <div class="pedido-info">
                        <h3>Pedido #<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><strong>Fecha:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($pedido['fecha'])), ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($pedido['estado'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Total:</strong> S/ <?php echo htmlspecialchars(number_format($pedido['total'], 2), ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <div class="pedido-acciones">
                        <a href="/Tienda_ropa/publico/index.php?accion=ver_detalles_pedido&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn">Ver detalles</a>
                        <?php if ($pedido['estado'] === 'pendiente'): ?>
                            <a href="/Tienda_ropa/publico/index.php?accion=cancelar_pedido&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-cancelar" onclick="return confirm('¿Estás seguro de que deseas cancelar este pedido?');">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No tienes pedidos realizados.</p>
        <a href="/Tienda_ropa/publico/index.php" class="btn">Ir a la tienda</a>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>