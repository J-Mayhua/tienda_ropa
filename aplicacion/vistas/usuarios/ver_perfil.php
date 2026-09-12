
<!-- aplicacion/vistas/perfil/ver_perfil.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<h1>Mi Perfil</h1>

<?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

<?php if (isset($usuario)): ?>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?></p>

    <a href="/Tienda_ropa/publico/index.php?accion=editar_perfil">Editar Perfil</a>
<?php else: ?>
    <p>No se encontró la información del usuario.</p>
<?php endif; ?>



<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>