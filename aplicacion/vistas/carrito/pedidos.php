<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/pedidos.css">

<div class="contenedor contenedor--pedidos">
    <h1 class="titulo-pedidos">Mis Pedidos</h1>

    <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

    <?php if (!empty($pedidos)): ?>
        <div class="lista-pedidos">
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido-item">
                    <div class="pedido-info">
                        <div class="pedido-info__cabecera">
                            <h3>Pedido #<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <span class="badge-estado badge-estado--<?php echo htmlspecialchars($pedido['estado'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars(ucfirst($pedido['estado']), ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                        <p><strong>Fecha:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($pedido['fecha'])), ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Total:</strong> S/ <?php echo htmlspecialchars(number_format($pedido['total'], 2), ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <div class="pedido-acciones">
                        <a href="/Tienda_ropa/publico/index.php?accion=ver_detalles_pedido&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm">Ver detalles</a>

                        <?php if ($pedido['estado'] === 'pendiente'): ?>
                            <form action="/Tienda_ropa/publico/index.php?accion=cancelar_pedido" method="post" class="pedido-form-accion" onsubmit="return confirm('¿Estás seguro de que deseas cancelar este pedido?');">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <button type="submit" class="btn btn-peligro btn-sm">Cancelar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="pedidos-vacio">
            <p>No tienes pedidos realizados.</p>
            <a href="/Tienda_ropa/publico/index.php" class="btn">Ir a la tienda</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
