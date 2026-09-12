<?php

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        throw new RuntimeException('La sesión debe estar activa antes de generar el token CSRF.');
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' .
        htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function verificar_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $tokenSesion = $_SESSION['csrf_token'] ?? '';
    $tokenSolicitud = $_POST['csrf_token'] ?? '';

    if (
        !is_string($tokenSesion) ||
        !is_string($tokenSolicitud) ||
        $tokenSesion === '' ||
        !hash_equals($tokenSesion, $tokenSolicitud)
    ) {
        http_response_code(403);
        exit('Solicitud no válida.');
    }
}
