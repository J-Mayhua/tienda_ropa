<?php

namespace Tienda\Soporte;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as MonologLogger;

class Logger
{
    private static ?MonologLogger $logger = null;

    public static function obtener(): MonologLogger
    {
        if (self::$logger === null) {
            $directorio = dirname(__DIR__, 2) . '/logs';
            if (!is_dir($directorio) && !mkdir($directorio, 0750, true) && !is_dir($directorio)) {
                throw new \RuntimeException('No se pudo crear el directorio de logs.');
            }

            self::$logger = new MonologLogger('tienda_ropa');
            self::$logger->pushHandler(
                new RotatingFileHandler($directorio . '/app.log', 14, MonologLogger::DEBUG)
            );
        }

        return self::$logger;
    }
}
