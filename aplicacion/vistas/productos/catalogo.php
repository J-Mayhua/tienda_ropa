<?php
// aplicacion/vistas/productos/catalogo.php

use Tienda\Modelos\ModeloProductos;

require_once __DIR__ . '/../../../configuracion/config.php';
require_once __DIR__ . '/../plantillas/cabecera.php';

$modelo = new ModeloProductos();
$productos = $modelo->obtenerProductos();
?>

<link
    rel="stylesheet"
    href="<?= htmlspecialchars(ASSET_BASE_URL, ENT_QUOTES, 'UTF-8') ?>/css/catalogo.css"
>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script
    src="<?= htmlspecialchars(ASSET_BASE_URL, ENT_QUOTES, 'UTF-8') ?>/js/catalogo.js"
    defer
></script>

<!-- Banner principal -->
<section class="hero-banner" aria-label="Banner principal">
    <div class="hero-content">
        <h1>COLECCIÓN PREMIUM 2025</h1>
        <p>Descubre las prendas más exclusivas de la temporada</p>
    </div>
</section>

<!-- Filtros de categoría -->
<nav aria-label="Filtros de categoría" class="category-filters">
    <button class="boton-categoria activo" aria-current="true">
        Todos
    </button>

    <button class="boton-categoria">
        Hombre
    </button>

    <button class="boton-categoria">
        Mujer
    </button>

    <button class="boton-categoria">
        Niños
    </button>
</nav>

<!-- Productos -->
<div class="cuadricula-productos">
    <?php foreach ($productos as $producto): ?>
        <?php
        /*
         * Acepta una URL externa o una ruta/nombre guardado en la base de datos.
         * Para rutas locales, utiliza el nombre del archivo dentro de
         * recursos/imagenes.
         */
        $rutaImagenOriginal = trim((string) ($producto['imagen'] ?? ''));

        if (
            filter_var($rutaImagenOriginal, FILTER_VALIDATE_URL) &&
            preg_match('/^https?:\/\//i', $rutaImagenOriginal)
        ) {
            $urlImagen = $rutaImagenOriginal;
        } else {
            $nombreArchivo = basename(
                str_replace('\\', '/', $rutaImagenOriginal)
            );

            $urlImagen = ASSET_BASE_URL
                . '/imagenes/'
                . rawurlencode($nombreArchivo);
        }

        $descuento = (float) ($producto['descuento'] ?? 0);
        $precio = (float) ($producto['precio'] ?? 0);
        ?>

        <div class="tarjeta-producto">
            <?php if ($descuento > 0): ?>
                <span class="product-badge">
                    -<?= htmlspecialchars(
                        (string) $descuento,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>% OFF
                </span>
            <?php endif; ?>

            <div class="product-media">
                <img
                    src="<?= htmlspecialchars($urlImagen, ENT_QUOTES, 'UTF-8') ?>"
                    alt="Imagen de <?= htmlspecialchars(
                        (string) ($producto['nombre'] ?? ''),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    class="imagen-producto"
                    loading="lazy"
                    decoding="async"
                >

                <div class="acciones-producto">
                    <button
                        type="button"
                        class="boton-accion"
                        aria-label="Añadir a favoritos"
                    >
                        <i class="fas fa-heart" aria-hidden="true"></i>
                    </button>

                    <button
                        type="button"
                        class="boton-accion"
                        aria-label="Vista rápida"
                    >
                        <i class="fas fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="contenido-producto">
                <span
                    class="categoria-producto"
                    aria-label="Categoría: <?= htmlspecialchars(
                        (string) ($producto['categoria'] ?? ''),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >
                    <?= htmlspecialchars(
                        (string) ($producto['categoria'] ?? ''),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </span>

                <h3 class="titulo-producto">
                    <?= htmlspecialchars(
                        (string) ($producto['nombre'] ?? ''),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </h3>

                <p class="descripcion-producto">
                    <?= htmlspecialchars(
                        (string) ($producto['descripcion'] ?? ''),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </p>

                <div class="precio-producto">
                    <?php if ($descuento > 0): ?>
                        <?php $precioConDescuento = $precio * (1 - $descuento / 100); ?>

                        <span class="precio-actual">
                            $<?= htmlspecialchars(
                                number_format($precioConDescuento, 2),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>

                        <span class="precio-original">
                            $<?= htmlspecialchars(
                                number_format($precio, 2),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>
                    <?php else: ?>
                        <span class="precio-actual">
                            $<?= htmlspecialchars(
                                number_format($precio, 2),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <form
                    method="POST"
                    action="<?= htmlspecialchars(
                        APP_ENTRY_URL,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>?accion=añadir_al_carrito"
                >
                    <?= csrf_field() ?>

                    <input
                        type="hidden"
                        name="id_producto"
                        value="<?= htmlspecialchars(
                            (string) ($producto['id'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= htmlspecialchars(
                            (string) ($producto['id'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <input
                        type="hidden"
                        name="accion"
                        value="añadir"
                    >

                    <button
                        type="submit"
                        class="anadir-carrito"
                        aria-label="Añadir <?= htmlspecialchars(
                            (string) ($producto['nombre'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?> al carrito"
                    >
                        <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                        Añadir al carrito
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
