<?php
// aplicacion/vistas/admin/usuarios/gestionar_usuarios.php
require_once __DIR__ . '/../plantillas/cabecera.php';
?>
<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/gestionar_usuarios.css">

<div class="contenedor contenedor-principal contenedor--angosto">
    <h2>Gestionar Usuarios</h2>

    <div class="tabla-envoltorio">
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="5" class="tabla__vacio">Aún no hay usuarios registrados.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                    <?php
                        $rol = $usuario['rol'] ?? '';
                        $rolClase = strtolower($rol) === 'admin' ? 'badge-rol--admin' : 'badge-rol--cliente';
                        $nombreEscapado = htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8');
                        $mensajeConfirmacion = htmlspecialchars(
                            "¿Seguro que quieres eliminar a {$usuario['nombre']}? Esta acción no se puede deshacer.",
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                    <tr>
                        <td data-label="ID"><?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td data-label="Nombre"><?php echo $nombreEscapado; ?></td>
                        <td data-label="Email"><?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td data-label="Rol">
                            <span class="badge-rol <?php echo $rolClase; ?>"><?php echo htmlspecialchars($rol, ENT_QUOTES, 'UTF-8'); ?></span>
                        </td>
                        <td data-label="Acciones" class="tabla__acciones">
                            <a href="/Tienda_ropa/publico/index.php?accion=editar_usuario&id=<?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm">Editar</a>
                            <a href="/Tienda_ropa/publico/index.php?accion=eliminar_usuario&id=<?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?>"
                               class="btn btn-sm btn-peligro"
                               data-confirmar="<?php echo $mensajeConfirmacion; ?>">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../plantillas/pie.php';
?>
