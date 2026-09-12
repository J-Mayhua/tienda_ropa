<?php
// configuracion/config.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../configuracion/csrf.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$variablesDb = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];
foreach ($variablesDb as $variableDb) {
    $valor = $_ENV[$variableDb] ?? getenv($variableDb);
    if ($valor === false) {
        throw new RuntimeException("Falta la variable de entorno {$variableDb}.");
    }
    define($variableDb, $valor);
}

// Crear conexión solo fuera de pruebas; modelos aceptan PDO inyectado.
$db = null;
if (getenv('APP_ENV') !== 'testing') {
    try {
        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}

// Configuración de sesiones
if (session_status() === PHP_SESSION_NONE) {
    session_name('tienda_ropa_session');
    session_set_cookie_params([
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');
    session_start();
}

// Para depuración (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// En producción, desactiva la visualización de errores y usa un log
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/../logs/error.log');
