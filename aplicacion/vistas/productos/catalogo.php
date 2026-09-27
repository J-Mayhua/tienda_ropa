<?php
// aplicacion/vistas/productos/catalogo.php

require_once __DIR__ . '/../../../configuracion/config.php';
require_once __DIR__ . '/../plantillas/cabecera.php';

use Tienda\Modelos\ModeloProductos;

$modelo = new ModeloProductos();
$productos = $modelo->obtenerProductos();
?>

<link rel="stylesheet" href="../publico/recursos/css/catalogo.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../publico/recursos/js/catalogo.js" defer></script>

<!-- Banner hero -->
<section class="hero-banner" aria-label="Banner principal">
    <div class="hero-content">
        <h1>COLECCIÓN PREMIUM 2025</h1>
        <p>Descubre las prendas más exclusivas de la temporada</p>
    </div>
</section>

<!-- Filtros -->
<nav aria-label="Filtros de categoría" class="category-filters">
    <button class="boton-categoria activo" aria-current="true">Todos</button>
    <button class="boton-categoria">Hombre</button>
    <button class="boton-categoria">Mujer</button>
    <button class="boton-categoria">Niños</button>
</nav>

<!-- Productos -->
<div class="cuadricula-productos">
    <?php foreach ($productos as $producto): ?>
        <div class="tarjeta-producto">
            <?php if ($producto['descuento'] > 0): ?>
                <span class="product-badge">-<?php echo htmlspecialchars($producto['descuento'], ENT_QUOTES, 'UTF-8'); ?>% OFF</span>
            <?php endif; ?>

            <div class="product-media">
                <img src="<?php echo htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8'); ?>"
                     alt="Imagen de <?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>"
                     class="imagen-producto"
                     loading="lazy"
                     decoding="async">

                <div class="acciones-producto">
                    <button type="button" class="boton-accion" aria-label="Añadir a favoritos">
                        <i class="fas fa-heart" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="boton-accion" aria-label="Vista rápida">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="contenido-producto">
                <span class="categoria-producto" aria-label="Categoría: <?php echo htmlspecialchars($producto['categoria'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($producto['categoria'], ENT_QUOTES, 'UTF-8'); ?></span>
                <h3 class="titulo-producto"><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p class="descripcion-producto" aria-label="Descripción: <?php echo htmlspecialchars($producto['descripcion'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($producto['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>

                <div class="precio-producto">
                    <?php if ($producto['descuento'] > 0): ?>
                        <span class="precio-actual">$<?php echo htmlspecialchars(number_format($producto['precio'] * (1 - $producto['descuento'] / 100), 2), ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="precio-original">$<?php echo htmlspecialchars(number_format($producto['precio'], 2), ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php else: ?>
                        <span class="precio-actual">$<?php echo htmlspecialchars(number_format($producto['precio'], 2), ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php endif; ?>
                </div>

                <form method="POST" action="/Tienda_ropa/publico/index.php?accion=añadir_al_carrito">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="accion" value="añadir">
                    <button type="submit" class="anadir-carrito" aria-label="Añadir <?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?> al carrito">
                        <i class="fas fa-shopping-cart" aria-hidden="true"></i> Añadir al carrito
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
