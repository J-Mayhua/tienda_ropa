<?php
// aplicacion/vistas/admin/productos/listar_productos.php
require_once __DIR__ . '/../../plantillas/cabecera.php';
?>

<div class="contenedor">
    <h2>Lista de Productos</h2>
    <a href="/Tienda_ropa/publico/index.php?accion=añadir_producto" class="btn">Añadir Producto</a>
    <div class="tabla-responsive">
    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>S/ <?php echo htmlspecialchars(number_format($producto['precio'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($producto['stock'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="/Tienda_ropa/publico/index.php?accion=editar_producto&id=<?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn">Editar</a>
                    <a href="/Tienda_ropa/publico/index.php?accion=eliminar_producto&id=<?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-peligro">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../../plantillas/pie.php';
?>