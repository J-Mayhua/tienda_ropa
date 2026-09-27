<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/iniciar_sesion.css">

<div class="contenedor-inicio-sesion">
    <h1>Iniciar Sesión</h1>

    <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

    <form method="POST" action="/Tienda_ropa/publico/index.php?accion=iniciar_sesion" class="login-form">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Iniciar Sesión</button>
        </div>
    </form>

    <div style="color: rgba(100, 100, 100, 0.75); font-size: 0.875rem; line-height: 1.5; margin-top: 1rem;">
        <p style="margin: 0 0 0.4rem;">Cuentas para probar el sistema:</p>
        <p style="margin: 0;">Administrador: admin2@tienda.com <br> Contraseña: Admin1234</p>
        <p style="margin: 0;">Usuario: user@tienda.com <br> Contraseña: User1234</p>
    </div>

    <p>¿No tienes una cuenta? <a href="/Tienda_ropa/publico/index.php?accion=registrarse">Regístrate aquí</a></p>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
