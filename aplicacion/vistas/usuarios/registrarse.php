<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>
<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/iniciar_sesion.css">

<div class="contenedor-inicio-sesion">
    <h1>Registrarse</h1>

    <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

    <form method="POST" action="/Tienda_ropa/publico/index.php?accion=registrarse" class="login-form">
        <?php echo csrf_field(); ?>
        <p>Los campos marcados con * son obligatorios.</p>

        <div class="form-group">
            <label for="nombre">Nombre: <span aria-hidden="true">*</span></label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="email">Email: <span aria-hidden="true">*</span></label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña: <span aria-hidden="true">*</span></label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Registrarse</button>
        </div>
    </form>

    <p>¿Ya tienes una cuenta? <a href="/Tienda_ropa/publico/index.php?accion=iniciar_sesion">Inicia sesión aquí</a></p>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
