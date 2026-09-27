<?php
// configuracion/config.php

// Evita que avisos o errores se impriman antes de iniciar la sesión.
// Los detalles quedan en los logs del servidor.
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/csrf.php';

// Carga el .env local si existe.
// En Vercel, las variables se leen desde Environment Variables.
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

/**
 * Lee una variable desde Dotenv o desde el entorno del servidor.
 */
$leerVariable = static function (string $nombre): ?string {
    $valor = $_ENV[$nombre] ?? getenv($nombre);

    if ($valor === false || $valor === null) {
        return null;
    }

    return (string) $valor;
};

$appEnv = strtolower($leerVariable('APP_ENV') ?? '');
$esProduccion = in_array($appEnv, ['production', 'prod'], true);

// Variables necesarias para la conexión.
$variablesDb = [
    'DB_HOST',
    'DB_PORT',
    'DB_NAME',
    'DB_USER',
    'DB_PASSWORD',
];

foreach ($variablesDb as $variableDb) {
    $valor = $leerVariable($variableDb);

    // DB_PASSWORD puede estar vacía en XAMPP.
    if (
        $valor === null ||
        ($variableDb !== 'DB_PASSWORD' && trim($valor) === '')
    ) {
        error_log("Falta la variable de entorno {$variableDb}.");

        http_response_code(500);
        exit('La configuración del servidor está incompleta.');
    }

    if (!defined($variableDb)) {
        define($variableDb, $valor);
    }
}

// Comprueba que el puerto sea válido.
$puertoDb = filter_var(
    DB_PORT,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1, 'max_range' => 65535]]
);

if ($puertoDb === false) {
    error_log('DB_PORT debe ser un puerto válido.');

    http_response_code(500);
    exit('La configuración del servidor no es válida.');
}

// Configura e inicia la sesión antes de cualquier salida.
if (session_status() === PHP_SESSION_NONE) {
    session_name('tienda_ropa_session');

    $usaHttps = $esProduccion
        || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

    session_set_cookie_params([
        'secure' => $usaHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');

    session_start();
}

// En pruebas automatizadas no se abre una conexión.
$db = null;

if ($appEnv !== 'testing') {
    $dsn = 'mysql:host=' . DB_HOST
         . ';port=' . $puertoDb
         . ';dbname=' . DB_NAME
         . ';charset=utf8mb4';

    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 10,
    ];

    // XAMPP local: DB_SSL=false.
    // Aiven en Vercel: DB_SSL=true y se requiere certificados/ca.pem.
    $usarSsl = strtolower($leerVariable('DB_SSL') ?? 'false') === 'true';

    if ($usarSsl) {
        $caPath = __DIR__ . '/../certificados/ca.pem';

        if (!is_file($caPath) || !is_readable($caPath)) {
            error_log('No se encontró o no se puede leer certificados/ca.pem.');

            http_response_code(500);
            exit('No se pudo establecer la conexión segura con la base de datos.');
        }

        // PHP 8.5 o posterior usa los nombres nuevos de las constantes.
        if (PHP_VERSION_ID >= 80500) {
            $opciones[\Pdo\Mysql::ATTR_SSL_CA] = $caPath;
            $opciones[\Pdo\Mysql::ATTR_SSL_VERIFY_SERVER_CERT] = true;
        } else {
            $opciones[\PDO::MYSQL_ATTR_SSL_CA] = $caPath;
            $opciones[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
        }
    }

    try {
        $db = new PDO($dsn, DB_USER, DB_PASSWORD, $opciones);
    } catch (PDOException $e) {
        // El detalle técnico queda en los logs, no se muestra al visitante.
        error_log('Error de conexión MySQL: ' . $e->getMessage());

        http_response_code(500);
        exit('No se pudo conectar a la base de datos.');
    }
}
