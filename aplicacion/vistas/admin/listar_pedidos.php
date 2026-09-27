<?php
// aplicacion/vistas/admin/pedidos/listar_pedidos.php
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
?>
<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/listar_pedidos.css">

<div class="contenedor contenedor-principal contenedor--angosto">
    <h2>Lista de Pedidos</h2>

    <div class="tabla-responsive">
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pedidos)): ?>
                <tr>
                    <td colspan="6" class="tabla__vacio">Aún no hay pedidos registrados.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($pedidos as $pedido): ?>
                    <?php $claseEstado = clase_badge_estado($pedido['estado']); ?>
                    <tr>
                        <td data-label="ID">#<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td data-label="Usuario">
                            <?php echo htmlspecialchars($pedido['usuario_id'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td data-label="Fecha">
                            <?php echo htmlspecialchars($pedido['fecha'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td data-label="Total" class="tabla__total">
                            S/ <?php echo htmlspecialchars(number_format((float) $pedido['total'], 2), ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td data-label="Estado">
                            <span class="badge-estado <?php echo $claseEstado; ?>">
                                <?php echo htmlspecialchars($pedido['estado'], ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>
                        <td data-label="Acciones" class="tabla__acciones">
                            <a href="/Tienda_ropa/publico/index.php?accion=ver_pedido_admin&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn">Ver Detalles</a>
                            <a href="/Tienda_ropa/publico/index.php?accion=cambiar_estado_pedido&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secundario">Cambiar Estado</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../plantillas/pie.php';
?>
