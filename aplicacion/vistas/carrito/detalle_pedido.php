<?php
require_once __DIR__ . '/../plantillas/cabecera.php';

// Clase de color del badge según el estado del pedido
function clase_badge_estado(string $estado): string {
    $normalizado = mb_strtolower(trim($estado));
    $mapa = [
        'pendiente'  => 'badge-estado--pendiente',
        'procesando' => 'badge-estado--procesando',
        'enviado'    => 'badge-estado--enviado',
        'entregado'  => 'badge-estado--entregado',
        'cancelado'  => 'badge-estado--cancelado',
    ];
    return $mapa[$normalizado] ?? 'badge-estado--procesando';
}

$claseEstadoPedido = clase_badge_estado($pedido['estado']);
?>
<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/detalle_pedidos.css">

<div class="contenedor contenedor-principal contenedor--angosto">
    <a href="/Tienda_ropa/publico/index.php?accion=ver_pedidos" class="detalle-pedido__volver">
        <i class="fas fa-arrow-left"></i> Volver a mis pedidos
    </a>

    <h1>Detalles del Pedido #<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?></h1>

    <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

    <div class="info-pedido">
        <div class="info-pedido__item">
            <div class="info-pedido__icono"><i class="fas fa-calendar"></i></div>
            <div>
                <span class="info-pedido__label">Fecha</span>
                <span class="info-pedido__valor"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($pedido['fecha'])), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>

        <div class="info-pedido__item">
            <div class="info-pedido__icono"><i class="fas fa-truck"></i></div>
            <div>
                <span class="info-pedido__label">Estado</span>
                <span class="badge-estado <?php echo $claseEstadoPedido; ?>">
                    <?php echo htmlspecialchars($pedido['estado'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </div>
        </div>

        <div class="info-pedido__item">
            <div class="info-pedido__icono"><i class="fas fa-coins"></i></div>
            <div>
                <span class="info-pedido__label">Total</span>
                <span class="info-pedido__valor">S/ <?php echo htmlspecialchars(number_format((float) $pedido['total'], 2), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>

        <?php if (!empty($pedido['comprobante'])): ?>
            <div class="info-pedido__item">
                <div class="info-pedido__icono"><i class="fas fa-file-invoice"></i></div>
                <div>
                    <span class="info-pedido__label">Comprobante</span>
                    <span class="info-pedido__valor">
                        <a href="/Tienda_ropa/comprobantes/<?php echo htmlspecialchars($pedido['comprobante'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">
                            Ver comprobante <i class="fas fa-up-right-from-square"></i>
                        </a>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <h2>Productos</h2>
    <?php if (!empty($detallesPedido)): ?>
        <div class="tabla-responsive">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detallesPedido as $detalle): ?>
                        <tr>
                            <td data-label="Producto"><?php echo htmlspecialchars($detalle['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td data-label="Imagen">
                                <?php if (!empty($detalle['imagen'])): ?>
                                    <img src="<?php echo htmlspecialchars($detalle['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($detalle['nombre'], ENT_QUOTES, 'UTF-8'); ?>" class="imagen-miniatura">
                                <?php else: ?>
                                    <span class="sin-imagen"><i class="fas fa-image"></i></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Cantidad"><?php echo htmlspecialchars($detalle['cantidad'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td data-label="Precio unitario">S/ <?php echo htmlspecialchars(number_format((float) $detalle['precio_unitario'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td data-label="Subtotal">S/ <?php echo htmlspecialchars(number_format($detalle['cantidad'] * $detalle['precio_unitario'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td>S/ <?php echo htmlspecialchars(number_format((float) $pedido['total'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php else: ?>
        <p>No hay productos en este pedido.</p>
    <?php endif; ?>

    <div class="acciones">
        <?php if ($pedido['estado'] === 'pendiente'): ?>
            <a href="/Tienda_ropa/publico/index.php?accion=cancelar_pedido&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>"
               class="btn btn-cancelar"
               data-confirmar="¿Estás seguro de que deseas cancelar este pedido?">
                <i class="fas fa-xmark"></i> Cancelar pedido
            </a>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
