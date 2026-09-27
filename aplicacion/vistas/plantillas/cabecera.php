<?php
require_once __DIR__ . '/../../../configuracion/config.php';

// Verificar el estado de la sesión
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Verificar el rol del usuario
$is_admin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
$is_cliente = isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente';
$usuario_autenticado = isset($_SESSION['usuario']);

// Iniciales del nombre para el avatar (ej. "Ana Díaz" -> "AD")
if (!function_exists('iniciales_usuario')) {
    function iniciales_usuario(?string $nombre): string {
        $nombre = trim((string) $nombre);
        if ($nombre === '') {
            return '?';
        }
        $partes = preg_split('/\s+/', $nombre);
        $iniciales = '';
        foreach (array_slice($partes, 0, 2) as $parte) {
            $iniciales .= mb_strtoupper(mb_substr($parte, 0, 1));
        }
        return $iniciales !== '' ? $iniciales : '?';
    }
}

$nombre_usuario = $usuario_autenticado ? ($_SESSION['usuario']['nombre'] ?? '') : '';
$rol_label = $is_admin ? 'Admin' : ($is_cliente ? 'Cliente' : '');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Ropa</title>
    <link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/variables.css">
    <link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <header class="cabecera">
        <div class="contenedor-cabecera">
            <!-- Logo e imagen a la izquierda -->
            <div class="logo-section">
                <div class="logo-image-container">
                    <img src="/Tienda_ropa/publico/recursos/imagenes/logo.jpg" alt="Logo" class="logo-image">
                </div>
                <h1 class="logo">Tienda Ropa</h1>
                <?php if ($rol_label): ?>
                    <span class="badge-rol badge-rol--<?php echo $is_admin ? 'admin' : 'cliente'; ?>">
                        <?php echo htmlspecialchars($rol_label, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Botón hamburguesa (solo visible en móvil) -->
            <button type="button" class="menu-toggle" id="menuToggle" aria-label="Abrir menú" aria-expanded="false" aria-controls="navegacionPrincipal">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navegación a la derecha -->
            <nav class="navegacion" id="navegacionPrincipal">
                <?php if ($usuario_autenticado): ?>
                    <!-- Enlace de Inicio (común para todos) -->
                    <div class="nav-button">
                        <a href="/Tienda_ropa/publico/index.php" class="nav-link">
                            <span>Inicio</span>
                        </a>
                    </div>

                    <!-- Enlaces exclusivos para clientes -->
                    <?php if ($is_cliente): ?>
                        <div class="nav-button cart-btn">
                            <a href="/Tienda_ropa/publico/index.php?accion=ver_carrito" class="nav-link">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Carrito</span>
                            </a>
                        </div>
                        <div class="nav-button">
                            <a href="/Tienda_ropa/publico/index.php?accion=ver_pedidos" class="nav-link">
                                <i class="fas fa-box"></i>
                                <span>Mis Pedidos</span>
                            </a>
                        </div>
                        <div class="nav-button">
                            <a href="/Tienda_ropa/publico/index.php?accion=ver_perfil" class="nav-link">
                                <i class="fas fa-user"></i>
                                <span>Mi Perfil</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Enlaces exclusivos para administradores -->
                    <?php if ($is_admin): ?>
                        <div class="nav-button">
                            <a href="/Tienda_ropa/publico/index.php?accion=panel_admin" class="nav-link">
                                <i class="fas fa-gauge-high"></i>
                                <span>Panel Principal</span>
                            </a>
                        </div>
                        <div class="nav-button">
                            <a href="/Tienda_ropa/publico/index.php?accion=listar_productos" class="nav-link">
                                <i class="fas fa-tshirt"></i>
                                <span>Productos</span>
                            </a>
                        </div>
                        <div class="nav-button">
                            <a href="/Tienda_ropa/publico/index.php?accion=gestionar_usuarios" class="nav-link">
                                <i class="fas fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </div>
                        <div class="nav-button">
                            <a href="/Tienda_ropa/publico/index.php?accion=listar_pedidos" class="nav-link">
                                <i class="fas fa-box"></i>
                                <span>Ver Pedidos</span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Enlace para cerrar sesión -->
                    <div class="nav-button nav-destacado">
                        <a href="/Tienda_ropa/publico/index.php?accion=cerrar_sesion" class="nav-link">
                            <span>Cerrar Sesión</span>
                        </a>
                    </div>

                <?php else: ?>
                    <!-- Enlaces para usuarios no autenticados -->
                    <div class="nav-button">
                        <a href="/Tienda_ropa/publico/index.php" class="nav-link">
                            <span>Inicio</span>
                        </a>
                    </div>
                    <div class="nav-button">
                        <a href="/Tienda_ropa/aplicacion/vistas/productos/nosotros.php" class="nav-link">
                            <span>Nosotros</span>
                        </a>
                    </div>

                    <div class="nav-button">
                        <a href="/Tienda_ropa/publico/index.php?accion=iniciar_sesion" class="nav-link">
                            <span>Iniciar Sesión</span>
                        </a>
                    </div>

                    <div class="nav-button nav-destacado">
                        <a href="/Tienda_ropa/publico/index.php?accion=registrarse" class="nav-link">
                            <span>Registrarse</span>
                        </a>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <script src="/Tienda_ropa/publico/recursos/js/cabecera.js" defer></script>
    <script src="/Tienda_ropa/publico/recursos/js/confirmaciones.js" defer></script>
