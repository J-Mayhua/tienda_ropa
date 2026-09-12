<?php
$mensajes = [
    ['clave' => 'error', 'clase' => 'alerta-error'],
    ['clave' => 'error_pago', 'clase' => 'alerta-error'],
    ['clave' => 'exito', 'clase' => 'alerta-exito'],
    ['clave' => 'mensaje', 'clase' => 'alerta-exito'],
];

foreach ($mensajes as $mensaje):
    if (isset($_SESSION[$mensaje['clave']])):
?>
        <div class="alerta <?php echo $mensaje['clase']; ?>" role="alert" aria-live="polite">
            <?php echo htmlspecialchars($_SESSION[$mensaje['clave']], ENT_QUOTES, 'UTF-8'); ?>
        </div>
<?php
        unset($_SESSION[$mensaje['clave']]);
    endif;
endforeach;
?>
