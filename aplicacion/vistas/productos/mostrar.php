<!-- aplicacion/vistas/productos/mostrar.php -->
<?php include '../plantillas/cabecera.php'; ?>

<h1><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h1>
<img src="<?php echo htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen de <?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>" width="300">
<p><?php echo htmlspecialchars($producto['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Precio:</strong> $<?php echo htmlspecialchars($producto['precio'], ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria'], ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Stock:</strong> <?php echo htmlspecialchars($producto['stock'], ENT_QUOTES, 'UTF-8'); ?></p>

<a href="/tienda_ropa/publico/index.php?accion=catalogo">Volver al catálogo</a>

<?php include '../plantillas/pie.php'; ?>