<!-- aplicacion/vistas/usuarios/registrar_admin.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>
<link rel="stylesheet" href="/tienda_ropa/publico/recursos/css/iniciar_sesion.css">
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
<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>