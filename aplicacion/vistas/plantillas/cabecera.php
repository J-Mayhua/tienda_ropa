<?php
// aplicacion/vistas/plantillas/cabecera.php

require_once __DIR__ . '/../../../configuracion/config.php';

// config.php inicia la sesión. Este bloque es una protección adicional.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuarioSesion = $_SESSION['usuario'] ?? null;
$usuarioAutenticado = is_array($usuarioSesion);

$is_admin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
$is_cliente = isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente';

$rol_label = $is_admin
    ? 'Admin'
    : ($is_cliente ? 'Cliente' : '');

if (!function_exists('iniciales_usuario')) {
    function iniciales_usuario(?string $nombre): string
    {
        $nombre = trim((string) $nombre);

        if ($nombre === '') {
            return '?';
        }

        $partes = preg_split('/\s+/', $nombre);
        $iniciales = '';

        foreach (array_slice($partes ?: [], 0, 2) as $parte) {
            if (function_exists('mb_substr') && function_exists('mb_strtoupper')) {
                $iniciales .= mb_strtoupper(mb_substr($parte, 0, 1));
            } else {
                $iniciales .= strtoupper(substr($parte, 0, 1));
            }
        }

        return $iniciales !== '' ? $iniciales : '?';
    }
}

$assetBase = rtrim(ASSET_BASE_URL, '/');
$appEntry = APP_ENTRY_URL;

$urlAsset = static function (string $ruta) use ($assetBase): string {
    return $assetBase . '/' . ltrim($ruta, '/');
};

$urlAccion = static function (string $accion) use ($appEntry): string {
    return $appEntry . '?accion=' . rawurlencode($accion);
};

$urlInicio = $appEntry;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tienda Ropa</title>

    <link
        rel="stylesheet"
        href="<?= htmlspecialchars($urlAsset('css/variables.css'), ENT_QUOTES, 'UTF-8') ?>"
    >

    <link
        rel="stylesheet"
        href="<?= htmlspecialchars($urlAsset('css/estilos.css'), ENT_QUOTES, 'UTF-8') ?>"
    >

    <link
        rel="stylesheet"
        href="<?= htmlspecialchars($urlAsset('css/pie.css'), ENT_QUOTES, 'UTF-8') ?>"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >
</head>

<body>
    <header class="cabecera">
        <div class="contenedor-cabecera">
            <div class="logo-section">
                <div class="logo-image-container">
                    <img
                        src="<?= htmlspecialchars($urlAsset('imagenes/logo.jpg'), ENT_QUOTES, 'UTF-8') ?>"
                        alt="Logo de Tienda Ropa"
                        class="logo-image"
                    >
                </div>

                <h1 class="logo">Tienda Ropa</h1>

                <?php if ($rol_label !== ''): ?>
                    <span class="badge-rol badge-rol--<?= $is_admin ? 'admin' : 'cliente' ?>">
                        <?= htmlspecialchars($rol_label, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                <?php endif; ?>
            </div>

            <button
                type="button"
                class="menu-toggle"
                id="menuToggle"
                aria-label="Abrir menú"
                aria-expanded="false"
                aria-controls="navegacionPrincipal"
            >
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>

            <nav class="navegacion" id="navegacionPrincipal">
                <?php if ($usuarioAutenticado): ?>
                    <div class="nav-button">
                        <a
                            href="<?= htmlspecialchars($urlInicio, ENT_QUOTES, 'UTF-8') ?>"
                            class="nav-link"
                        >
                            <span>Inicio</span>
                        </a>
                    </div>

                    <?php if ($is_cliente): ?>
                        <div class="nav-button cart-btn">
                            <a
                                href="<?= htmlspecialchars($urlAccion('ver_carrito'), ENT_QUOTES, 'UTF-8') ?>"
                                class="nav-link"
                            >
                                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                                <span>Carrito</span>
                            </a>
                        </div>

                        <div class="nav-button">
                            <a
                                href="<?= htmlspecialchars($urlAccion('ver_pedidos'), ENT_QUOTES, 'UTF-8') ?>"
                                class="nav-link"
                            >
                                <i class="fas fa-box" aria-hidden="true"></i>
                                <span>Mis pedidos</span>
                            </a>
                        </div>

                        <div class="nav-button">
                            <a
                                href="<?= htmlspecialchars($urlAccion('ver_perfil'), ENT_QUOTES, 'UTF-8') ?>"
                                class="nav-link"
                            >
                                <i class="fas fa-user" aria-hidden="true"></i>
                                <span>Mi perfil</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($is_admin): ?>
                        <div class="nav-button">
                            <a
                                href="<?= htmlspecialchars($urlAccion('panel_admin'), ENT_QUOTES, 'UTF-8') ?>"
                                class="nav-link"
                            >
                                <i class="fas fa-gauge-high" aria-hidden="true"></i>
                                <span>Panel principal</span>
                            </a>
                        </div>

                        <div class="nav-button">
                            <a
                                href="<?= htmlspecialchars($urlAccion('listar_productos'), ENT_QUOTES, 'UTF-8') ?>"
                                class="nav-link"
                            >
                                <i class="fas fa-shirt" aria-hidden="true"></i>
                                <span>Productos</span>
                            </a>
                        </div>

                        <div class="nav-button">
                            <a
                                href="<?= htmlspecialchars($urlAccion('gestionar_usuarios'), ENT_QUOTES, 'UTF-8') ?>"
                                class="nav-link"
                            >
                                <i class="fas fa-users" aria-hidden="true"></i>
                                <span>Usuarios</span>
                            </a>
                        </div>

                        <div class="nav-button">
                            <a
                                href="<?= htmlspecialchars($urlAccion('listar_pedidos'), ENT_QUOTES, 'UTF-8') ?>"
                                class="nav-link"
                            >
                                <i class="fas fa-box" aria-hidden="true"></i>
                                <span>Ver pedidos</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="nav-button nav-destacado">
                        <a
                            href="<?= htmlspecialchars($urlAccion('cerrar_sesion'), ENT_QUOTES, 'UTF-8') ?>"
                            class="nav-link"
                        >
                            <span>Cerrar sesión</span>
                        </a>
                    </div>

                <?php else: ?>
                    <div class="nav-button">
                        <a
                            href="<?= htmlspecialchars($urlInicio, ENT_QUOTES, 'UTF-8') ?>"
                            class="nav-link"
                        >
                            <span>Inicio</span>
                        </a>
                    </div>

                    <div class="nav-button">
                        <a
                            href="<?= htmlspecialchars($urlAccion('nosotros'), ENT_QUOTES, 'UTF-8') ?>"
                            class="nav-link"
                        >
                            <span>Nosotros</span>
                        </a>
                    </div>

                    <div class="nav-button">
                        <a
                            href="<?= htmlspecialchars($urlAccion('iniciar_sesion'), ENT_QUOTES, 'UTF-8') ?>"
                            class="nav-link"
                        >
                            <span>Iniciar sesión</span>
                        </a>
                    </div>

                    <div class="nav-button nav-destacado">
                        <a
                            href="<?= htmlspecialchars($urlAccion('registrarse'), ENT_QUOTES, 'UTF-8') ?>"
                            class="nav-link"
                        >
                            <span>Registrarse</span>
                        </a>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <script
        src="<?= htmlspecialchars($urlAsset('js/cabecera.js'), ENT_QUOTES, 'UTF-8') ?>"
        defer
    ></script>

    <script
        src="<?= htmlspecialchars($urlAsset('js/confirmaciones.js'), ENT_QUOTES, 'UTF-8') ?>"
        defer
    ></script>
