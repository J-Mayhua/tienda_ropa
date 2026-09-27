<!-- aplicacion/vistas/perfil/ver_perfil.php -->
<?php require_once __DIR__ . '/../plantillas/cabecera.php'; ?>

<div class="contenedor-principal">
    <div class="contenedor">

        <?php require __DIR__ . '/../plantillas/mensajes.php'; ?>

        <?php if (isset($usuario)): ?>

            <?php
                // Iniciales para el avatar (ej: "Juan Pérez" -> "JP")
                $palabrasNombre = preg_split('/\s+/', trim($usuario['nombre']));
                $iniciales = strtoupper(mb_substr($palabrasNombre[0], 0, 1));
                if (count($palabrasNombre) > 1) {
                    $iniciales .= strtoupper(mb_substr(end($palabrasNombre), 0, 1));
                }
            ?>

            <div class="tarjeta-bienvenida">
                <div class="avatar-iniciales avatar-iniciales--lg">
                    <?php echo htmlspecialchars($iniciales, ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div class="tarjeta-bienvenida__info">
                    <h2>
                        <?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                        <?php if (!empty($usuario['rol'])): ?>
                            <span class="badge-rol badge-rol--admin">
                                <?php echo htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        <?php endif; ?>
                    </h2>
                    <p><?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>

            <div class="resumen-admin">
                <div class="resumen-card">
                    <div class="resumen-card__icono">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="resumen-card__numero"><?php echo htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="resumen-card__label">Nombre completo</span>
                </div>

                <div class="resumen-card">
                    <div class="resumen-card__icono">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <span class="resumen-card__numero"><?php echo htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="resumen-card__label">Correo electrónico</span>
                </div>

                <div class="resumen-card">
                    <div class="resumen-card__icono">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                    <span class="resumen-card__label" style="margin-top:0;">Actualiza tus datos</span>
                    <a href="/Tienda_ropa/publico/index.php?accion=editar_perfil" class="resumen-card__link">
                        Editar perfil
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

        <?php else: ?>
            <div class="tarjeta-bienvenida">
                <p>No se encontró la información del usuario.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
