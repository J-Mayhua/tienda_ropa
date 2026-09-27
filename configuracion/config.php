<?php
// configuracion/config.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../configuracion/csrf.php';

// En desarrollo permite cargar variables desde .env.
// En Vercel se usan las variables configuradas en el panel del proyecto.
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

/**
 * Lee primero $_ENV y luego el entorno del servidor.
 */
$leerVariable = static function (string $nombre): ?string {
    $valor = $_ENV[$nombre] ?? getenv($nombre);

    if ($valor === false || $valor === null) {
        return null;
    }

    return (string) $valor;
};

// Variables necesarias para conectarse a Aiven.
$variablesDb = [
    'DB_HOST',
    'DB_PORT',
    'DB_NAME',
    'DB_USER',
    'DB_PASSWORD',
];

foreach ($variablesDb as $variableDb) {
    $valor = $leerVariable($variableDb);

    if ($valor === null || trim($valor) === '') {
        throw new RuntimeException(
            "Falta la variable de entorno {$variableDb}."
        );
    }

    if (!defined($variableDb)) {
        define($variableDb, $valor);
    }
}

// Valida que el puerto sea un número válido.
$puertoDb = filter_var(
    DB_PORT,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1, 'max_range' => 65535]]
);

if ($puertoDb === false) {
    throw new RuntimeException('DB_PORT debe ser un puerto válido.');
}

// No se intenta conectar en el entorno de pruebas.
$appEnv = $leerVariable('APP_ENV') ?? '';
$db = null;

if ($appEnv !== 'testing') {
    // Debe coincidir con la ubicación del CA certificate dentro del proyecto.
    $caPath = __DIR__ . '/../certificados/ca.pem';

    if (!is_file($caPath)) {
        throw new RuntimeException(
            'No se encontró el certificado CA en certificados/ca.pem.'
        );
    }

    $dsn = 'mysql:host=' . DB_HOST
         . ';port=' . $puertoDb
         . ';dbname=' . DB_NAME
         . ';charset=utf8mb4';

    try {
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_SSL_CA => $caPath,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
            PDO::MYSQL_ATTR_TIMEOUT => 10,
        ];

        $db = new PDO($dsn, DB_USER, DB_PASSWORD, $opciones);
    } catch (PDOException $e) {
        // El detalle queda en los logs del servidor, no visible al visitante.
        error_log('Error de conexión MySQL: ' . $e->getMessage());

        http_response_code(500);
        exit('No se pudo conectar a la base de datos.');
    }
}

// Configuración de sesiones.
if (session_status() === PHP_SESSION_NONE) {
    session_name('tienda_ropa_session');

    session_set_cookie_params([
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');

    session_start();
}

// No mostrar errores internos a los visitantes.
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');

error_reporting(E_ALL);
