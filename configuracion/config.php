<?php
// configuracion/config.php

// Evita mostrar errores al visitante.
// Los detalles técnicos quedan en los logs del servidor.
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
$enVercel = ($leerVariable('VERCEL') ?? '') === '1';

$esProduccion = $enVercel
    || in_array($appEnv, ['production', 'prod'], true);

/*
 * Vercel sirve los archivos ubicados en /public desde la raíz del dominio.
 * Por eso, public/recursos/css/... se solicita como /recursos/css/...
 *
 * En XAMPP, el proyecto se encuentra bajo /Tienda_ropa.
 */
if (!defined('ASSET_BASE_URL')) {
    define(
        'ASSET_BASE_URL',
        $enVercel
            ? '/recursos'
            : '/Tienda_ropa/publico/recursos'
    );
}

/*
 * En Vercel, vercel.json envía la ruta / a /api/index.php.
 * En XAMPP, se usa la ruta local del proyecto.
 */
if (!defined('APP_ENTRY_URL')) {
    define(
        'APP_ENTRY_URL',
        $enVercel
            ? '/'
            : '/Tienda_ropa/publico/index.php'
    );
}

// Variables necesarias para la conexión a la base de datos.
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

// Comprueba que el puerto de base de datos sea válido.
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

// Inicia la sesión antes de que se envíe contenido al navegador.
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
    // Aiven en Vercel: DB_SSL=true y certificados/ca.pem.
    $usarSsl = strtolower($leerVariable('DB_SSL') ?? 'false') === 'true';

    if ($usarSsl) {
        $caPath = __DIR__ . '/../certificados/ca.pem';

        if (!is_file($caPath) || !is_readable($caPath)) {
            error_log('No se encontró o no se puede leer certificados/ca.pem.');

            http_response_code(500);
            exit('No se pudo establecer la conexión segura con la base de datos.');
        }

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
        // El detalle técnico se registra en los logs, no se muestra al visitante.
        error_log('Error de conexión MySQL: ' . $e->getMessage());

        http_response_code(500);
        exit('No se pudo conectar a la base de datos.');
    }
}
