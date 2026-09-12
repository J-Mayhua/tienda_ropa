<!-- aplicacion/vistas/usuarios/registrar_admin.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>
<link rel="stylesheet" href="/tienda_ropa/publico/recursos/css/iniciar_sesion.css">
<div class="login-container">
    <h1>Registrar Administrador</h1>
    <form method="POST" action="" class="login-form">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <!-- Campo oculto para el rol -->
        <input type="hidden" name="rol" value="admin">
        <div class="form-actions">
            <button type="submit" class="btn">Registrar Administrador</button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>