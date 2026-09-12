<?php
// aplicacion/vistas/admin/pedidos/listar_pedidos.php
require_once __DIR__ . '/../plantillas/cabecera.php';
?>

<div class="contenedor">
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
            <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pedido['usuario_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pedido['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>S/ <?php echo htmlspecialchars(number_format($pedido['total'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pedido['estado'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="/Tienda_ropa/publico/index.php?accion=ver_pedido_admin&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn">Ver Detalles</a>
                    <a href="/Tienda_ropa/publico/index.php?accion=cambiar_estado_pedido&id=<?php echo htmlspecialchars($pedido['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn">Cambiar Estado</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../plantillas/pie.php';
?>