<!-- aplicacion/vistas/perfil/editar_perfil.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<h1>Editar Perfil</h1>

<?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

<form action="/Tienda_ropa/publico/index.php?accion=actualizar_perfil" method="post">
    <?php echo csrf_field(); ?>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?>" required>

    <button type="submit">Guardar Cambios</button>
</form>

<a href="/Tienda_ropa/publico/index.php?accion=ver_perfil">Cancelar</a>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>