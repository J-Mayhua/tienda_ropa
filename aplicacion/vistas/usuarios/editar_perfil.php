<!-- aplicacion/vistas/perfil/editar_perfil.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>
<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/estilo.css">

<center><h1>Editar Perfil</h1></center>

<?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

<form action="/Tienda_ropa/publico/index.php?accion=actualizar_perfil" method="post" class="form-card">
    <?php echo csrf_field(); ?>

    <!-- Si un admin puede editar el perfil de otro usuario, hay que enviar el id explícitamente -->
    <?php if (isset($usuario['id'])): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8'); ?>">
    <?php endif; ?>

    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">Guardar Cambios</button>
        <a href="<?php echo (isset($usuario_sesion['rol']) && $usuario_sesion['rol'] === 'admin')
    ? '/Tienda_ropa/publico/index.php?accion=perfil_admin'
    : '/Tienda_ropa/publico/index.php?accion=ver_perfil'; ?>" class="btn btn-secundario">Cancelar</a>
    </div>
</form>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
