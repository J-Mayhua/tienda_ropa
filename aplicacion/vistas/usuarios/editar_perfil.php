<!-- aplicacion/vistas/perfil/editar_perfil.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<h1>Editar Perfil</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<form action="/Tienda_ropa/publico/index.php?accion=actualizar_perfil" method="post" class="form-card">
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">Guardar Cambios</button>
        <a href="/Tienda_ropa/publico/index.php?accion=ver_perfil" class="btn btn-secundario">Cancelar</a>
    </div>
</form>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>