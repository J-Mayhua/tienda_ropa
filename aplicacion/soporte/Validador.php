<?php

namespace Tienda\Soporte;

class Validador
{
    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function password(string $password, int $minimo = 8): bool
    {
        return strlen($password) >= $minimo;
    }

    public static function requeridos(array $datos, array $campos): bool
    {
        foreach ($campos as $campo) {
            if (!isset($datos[$campo]) || trim((string) $datos[$campo]) === '') {
                return false;
            }
        }

        return true;
    }
}
