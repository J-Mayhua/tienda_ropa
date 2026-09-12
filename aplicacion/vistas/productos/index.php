<!-- aplicacion/vistas/productos/index.php -->
<?php include '../plantillas/cabecera.php'; ?>

<h1>Lista de Productos</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Categoría</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto): ?>
    <tr>
        <td><?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($producto['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($producto['precio'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($producto['categoria'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <a href="/tienda_ropa/publico/index.php?accion=editar_producto&id=<?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?>">Editar</a>
            <a href="/tienda_ropa/publico/index.php?accion=eliminar_producto&id=<?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="/tienda_ropa/publico/index.php?accion=añadir_producto">Añadir Producto</a>

<?php include '../plantillas/pie.php'; ?>