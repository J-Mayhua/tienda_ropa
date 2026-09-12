<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/iniciar_sesion.css">

<div class="contenedor-inicio-sesion">
    <h1>Iniciar Sesión</h1>
    
    <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>
    
    <form method="POST" action="/Tienda_ropa/publico/index.php?accion=iniciar_sesion">
        <?php echo csrf_field(); ?>
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Iniciar Sesión</button>
    </form>

    <p>¿No tienes una cuenta? <a href="/Tienda_ropa/publico/index.php?accion=registrarse">Regístrate aquí</a></p>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>