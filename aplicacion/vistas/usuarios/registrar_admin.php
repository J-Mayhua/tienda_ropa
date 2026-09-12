<!-- aplicacion/vistas/usuarios/registrar_admin.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>
<link rel="stylesheet" href="/tienda_ropa/publico/recursos/css/iniciar_sesion.css">
<<<<<<< HEAD
<div class="contenedor-inicio-sesion">
<h1>Registrar Administrador</h1>
<form method="POST" action="">
    <?php echo csrf_field(); ?>
    <p>Los campos marcados con * son obligatorios.</p>
    <label for="nombre">Nombre: <span aria-hidden="true">*</span></label>
    <input type="text" id="nombre" name="nombre" required>
    <br>
    <label for="email">Email: <span aria-hidden="true">*</span></label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Contraseña: <span aria-hidden="true">*</span></label>
    <input type="password" id="password" name="password" required>
    <br>
    <!-- Campo oculto para el rol -->
    <input type="hidden" name="rol" value="admin">
    <button type="submit">Registrar Administrador</button>
</form>
<div>
=======
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
>>>>>>> agents/css-redesign-ecommerce-visual-update
<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>