<?php
// aplicacion/vistas/admin/panel.php
require_once __DIR__ . '/../plantillas/cabecera.php';

use Tienda\Modelos\ModeloUsuarios;

// Total de usuarios (ya existe un método listo para esto)
$modeloUsuarios = new ModeloUsuarios();
$totalUsuarios = $modeloUsuarios->contarUsuarios();

// Total de productos y pedidos: se consulta directo mientras no exista
// un ModeloProductos / ModeloPedidos. Si el nombre de tabla no coincide
// con tu esquema real, devuelve null y se muestra "—" sin romper la página.
function contar_filas_tabla(string $tabla): ?int {
    global $db;
    if (!$db) {
        return null;
    }
    try {
        $stmt = $db->prepare("SELECT COUNT(*) AS total FROM {$tabla}");
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($fila['total'] ?? 0);
    } catch (\PDOException $e) {
        return null;
    }
}

$totalProductos = contar_filas_tabla('productos');
$totalPedidos = contar_filas_tabla('pedidos');
?>
<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/panel.css">

<div class="contenedor-principal">
    <div class="contenedor">
        <div class="tarjeta-bienvenida">
            <div class="avatar-iniciales avatar-iniciales--lg">
                <?php echo htmlspecialchars(iniciales_usuario($nombre_usuario), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="tarjeta-bienvenida__info">
                <h2>
                    Bienvenido<?php echo $nombre_usuario ? ', ' . htmlspecialchars($nombre_usuario, ENT_QUOTES, 'UTF-8') : ''; ?>
                    <span class="badge-rol badge-rol--admin">Admin</span>

                </h2>

                <p>Selecciona una opción del menú para comenzar.</p>
            </div>
            <a href="/Tienda_ropa/publico/index.php?accion=editar_perfil" class="btn btn-secundario btn-sm tarjeta-bienvenida__accion">
        <i class="fa-solid fa-pen"></i> Editar perfil
    </a>
        </div>

        <div class="resumen-admin">
            <div class="resumen-card">
                <div class="resumen-card__icono"><i class="fas fa-tshirt"></i></div>
                <div>
                    <span class="resumen-card__numero"><?php echo $totalProductos ?? '—'; ?></span>
                    <span class="resumen-card__label">Productos</span>
                </div>
                <a href="/Tienda_ropa/publico/index.php?accion=listar_productos" class="resumen-card__link">
                    Productos <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="resumen-card">
                <div class="resumen-card__icono"><i class="fas fa-box"></i></div>
                <div>
                    <span class="resumen-card__numero"><?php echo $totalPedidos ?? '—'; ?></span>
                    <span class="resumen-card__label">Pedidos</span>
                </div>
                <a href="/Tienda_ropa/publico/index.php?accion=listar_pedidos" class="resumen-card__link">
                    Pedidos <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="resumen-card">
                <div class="resumen-card__icono"><i class="fas fa-users"></i></div>
                <div>
                    <span class="resumen-card__numero"><?php echo $totalUsuarios ?? '—'; ?></span>
                    <span class="resumen-card__label">Usuarios</span>
                </div>
                <a href="/Tienda_ropa/publico/index.php?accion=gestionar_usuarios" class="resumen-card__link">
                    Usuarios <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../plantillas/pie.php';
?>
