<?php
// configuracion/config.php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../configuracion/csrf.php';

// Carga el archivo .env local si existe.
// En Vercel, las variables se leen desde Environment Variables.
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

/**
 * Lee una variable primero desde Dotenv y luego desde el entorno del servidor.
 */
$leerVariable = static function (string $nombre): ?string {
    $valor = $_ENV[$nombre] ?? getenv($nombre);

    if ($valor === false || $valor === null) {
        return null;
    }

    return (string) $valor;
};

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

    // La contraseña puede estar vacía en XAMPP.
    if (
        $valor === null ||
        ($variableDb !== 'DB_PASSWORD' && trim($valor) === '')
    ) {
        throw new RuntimeException(
            "Falta la variable de entorno {$variableDb}."
        );
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
    throw new RuntimeException('DB_PORT debe ser un puerto válido.');
}

// En pruebas automatizadas no se abre una conexión.
$db = null;
$appEnv = strtolower($leerVariable('APP_ENV') ?? '');

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
    // Aiven en Vercel: DB_SSL=true y se requiere el certificado CA.
    $usarSsl = strtolower($leerVariable('DB_SSL') ?? 'false') === 'true';

    if ($usarSsl) {
        $caPath = __DIR__ . '/../certificados/ca.pem';

        if (!is_file($caPath)) {
            throw new RuntimeException(
                'Falta el certificado CA de Aiven en certificados/ca.pem.'
            );
        }

        $opciones[PDO::MYSQL_ATTR_SSL_CA] = $caPath;
        $opciones[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
    }

    try {
        $db = new PDO($dsn, DB_USER, DB_PASSWORD, $opciones);
    } catch (PDOException $e) {
        // El detalle se guarda en los logs, no se muestra al visitante.
        error_log('Error de conexión MySQL: ' . $e->getMessage());

        http_response_code(500);
        exit('No se pudo conectar a la base de datos.');
    }
}

// Configuración de sesiones.
if (session_status() === PHP_SESSION_NONE) {
    session_name('tienda_ropa_session');

    $esProduccion = in_array($appEnv, ['production', 'prod'], true);
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

// En producción no se muestran errores internos en la página.
$esProduccion = in_array($appEnv, ['production', 'prod'], true);

ini_set('display_errors', $esProduccion ? '0' : '1');
ini_set('display_startup_errors', $esProduccion ? '0' : '1');
ini_set('log_errors', '1');

error_reporting(E_ALL);
