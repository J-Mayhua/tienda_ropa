<?php

namespace Tienda\Soporte;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

class Logger
{
    private static ?MonologLogger $logger = null;

    public static function obtener(): MonologLogger
    {
        if (self::$logger !== null) {
            return self::$logger;
        }

        self::$logger = new MonologLogger('tienda_ropa');

        // Vercel ofrece los logs de la función; no hay que crear archivos.
        if (getenv('VERCEL') === '1') {
            self::$logger->pushHandler(
                new StreamHandler('php://stderr', MonologLogger::DEBUG)
            );

            return self::$logger;
        }

        // En local, conserva los logs rotativos.
        $directorio = dirname(__DIR__, 2) . '/logs';

        if (!is_dir($directorio)) {
            @mkdir($directorio, 0750, true);
        }

        if (is_dir($directorio) && is_writable($directorio)) {
            self::$logger->pushHandler(
                new RotatingFileHandler(
                    $directorio . '/app.log',
                    14,
                    MonologLogger::DEBUG
                )
            );
        } else {
            // Evita que un problema con la carpeta de logs detenga la aplicación.
            self::$logger->pushHandler(
                new StreamHandler('php://stderr', MonologLogger::DEBUG)
            );
        }

        return self::$logger;
    }
}
