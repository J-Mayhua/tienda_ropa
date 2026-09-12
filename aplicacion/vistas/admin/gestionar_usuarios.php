<?php
// aplicacion/vistas/admin/usuarios/gestionar_usuarios.php
require_once __DIR__ . '/../plantillas/cabecera.php';
?>

<div class="contenedor">
    <h2>Gestionar Usuarios</h2>
    <a href="/Tienda_ropa/publico/index.php?accion=listar_usuarios" class="btn btn-secundario">Volver a la Lista</a>
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
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="/Tienda_ropa/publico/index.php?accion=editar_usuario&id=<?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn">Editar</a>
                    <a href="/Tienda_ropa/publico/index.php?accion=eliminar_usuario&id=<?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-peligro">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require_once __DIR__ . '/../plantillas/pie.php';
?>