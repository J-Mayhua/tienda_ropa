<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../configuracion/config.php';

header("Content-Security-Policy: default-src 'self'; img-src 'self' data: https:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; script-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; frame-ancestors 'none'; form-action 'self'; base-uri 'self'");
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

verificar_csrf();

use Tienda\Controladores\ControladorAdmin;
use Tienda\Controladores\ControladorAutenticacion;
use Tienda\Controladores\ControladorCarrito;
use Tienda\Controladores\ControladorPagos;
use Tienda\Controladores\ControladorPedidos;
use Tienda\Controladores\ControladorPerfil;
use Tienda\Controladores\ControladorProductos;

$rutas = [
    'iniciar_sesion' => [ControladorAutenticacion::class, 'iniciarSesion'],
    'registrarse' => [ControladorAutenticacion::class, 'registrarse'],
    'registrar_admin' => [ControladorAutenticacion::class, 'registrarAdmin'],
    'cerrar_sesion' => [ControladorAutenticacion::class, 'cerrarSesion'],
    'catalogo' => [ControladorProductos::class, 'catalogo'],
    'mostrar_producto' => [ControladorProductos::class, 'mostrarProducto'],
    'añadir_al_carrito' => [ControladorCarrito::class, 'añadirAlCarrito'],
    'ver_carrito' => [ControladorCarrito::class, 'verCarrito'],
    'eliminar_del_carrito' => [ControladorCarrito::class, 'eliminarDelCarrito'],
    'vaciar_carrito' => [ControladorCarrito::class, 'vaciarCarrito'],
    'finalizar_compra' => [ControladorCarrito::class, 'finalizarCompra'],
    'ver_pedidos' => [ControladorPedidos::class, 'verPedidos'],
    'ver_detalles_pedido' => [ControladorPedidos::class, 'verDetallePedido'],
    'pago_yape' => [ControladorPagos::class, 'pagoYape'],
    'procesar_pago_yape' => [ControladorPagos::class, 'procesarPagoYape'],
    'panel_admin' => [ControladorAdmin::class, 'panel'],
    'listar_productos' => [ControladorAdmin::class, 'listarProductos'],
    'añadir_producto' => [ControladorAdmin::class, 'añadirProducto'],
    'editar_producto' => [ControladorAdmin::class, 'editarProducto'],
    'eliminar_producto' => [ControladorAdmin::class, 'eliminarProducto'],
    'listar_pedidos' => [ControladorAdmin::class, 'listarPedidos'],
    'ver_pedido_admin' => [ControladorAdmin::class, 'verPedido'],
    'cambiar_estado_pedido' => [ControladorAdmin::class, 'cambiarEstadoPedido'],
    'listar_usuarios' => [ControladorAdmin::class, 'listarUsuarios'],
    'editar_usuario' => [ControladorAdmin::class, 'editarUsuario'],
    'eliminar_usuario' => [ControladorAdmin::class, 'eliminarUsuario'],
    'gestionar_usuarios' => [ControladorAdmin::class, 'gestionarUsuarios'],
    'ver_perfil' => [ControladorPerfil::class, 'verPerfil'],
    'editar_perfil' => [ControladorPerfil::class, 'editarPerfil'],
    'actualizar_perfil' => [ControladorPerfil::class, 'actualizarPerfil']
];

$accion = $_GET['accion'] ?? 'inicio';
if (!isset($rutas[$accion])) {
    (new ControladorProductos())->catalogo();
    exit;
}

$ruta = $rutas[$accion];
$controlador = new $ruta[0]();
$metodo = $ruta[1];

$accionesConId = [
    'mostrar_producto',
    'ver_detalles_pedido',
    'editar_producto',
    'eliminar_producto',
    'ver_pedido_admin',
    'cambiar_estado_pedido',
    'editar_usuario',
    'eliminar_usuario'
];

if (in_array($accion, $accionesConId, true)) {
    if (!isset($_GET['id'])) {
        $_SESSION['error'] = "No se proporcionó un ID.";
        header('Location: /Tienda_ropa/publico/index.php?accion=ver_pedidos');
        exit;
    }
    $controlador->$metodo($_GET['id']);
    exit;
}

if ($accion === 'añadir_al_carrito' || $accion === 'eliminar_del_carrito') {
    $controlador->$metodo($_POST['id'] ?? null);
    exit;
}

$controlador->$metodo();
