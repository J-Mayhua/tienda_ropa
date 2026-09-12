<?php
// aplicacion/controladores/ControladorAutenticacion.php

namespace Tienda\Controladores;

require_once __DIR__ . '/../../configuracion/config.php';

use Tienda\Modelos\ModeloUsuarios;
use Tienda\Soporte\Validador;
use PDOException;

class ControladorAutenticacion {
    private const MAX_INTENTOS_LOGIN = 5;
    private const VENTANA_LOGIN_SEGUNDOS = 900;

    private $modelo;

    // Constructor: inicializa el modelo
    public function __construct() {
        $this->modelo = new ModeloUsuarios(); // Instancia el modelo
    }

    // Método para registrar administradores
    public function registrarAdmin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = $_POST['password'];
            if (!Validador::email($email) || !Validador::password($password)) {
                $_SESSION['error'] = "Email o contraseña no válidos.";
                header('Location: /Tienda_ropa/publico/index.php?accion=iniciar_sesion');
                exit;
            }
            $rol = $_POST['rol'];

            try {
                if ($this->modelo->registrar($nombre, $email, $password, $rol)) {
                    $_SESSION['mensaje'] = "Administrador registrado correctamente.";
                    header('Location: /Tienda_ropa/publico/index.php?accion=listar_usuarios');
                    exit;
                } else {
                    $_SESSION['error'] = "Error al registrar el administrador.";
                }
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $_SESSION['error'] = "Error: El correo electrónico ya está registrado. Por favor, utiliza otro.";
                } else {
                    $_SESSION['error'] = "Error en el registro: " . $e->getMessage();
                }
            }
        }
        require_once __DIR__ . '/../vistas/usuarios/registrar_admin.php';
    }

    // Método para iniciar sesión - CORREGIDO
    public function iniciarSesion() {
        // Guardar cualquier mensaje de error previo
        $error_previo = isset($_SESSION['error']) ? $_SESSION['error'] : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim((string) ($_POST['email'] ?? ''));
            $password = $_POST['password'];
            if (!Validador::email($email) || !Validador::password($password)) {
                $_SESSION['error'] = "Email o contraseña no válidos.";
                require_once __DIR__ . '/../vistas/usuarios/iniciar_sesion.php';
                return;
            }
            $claveIntento = $this->obtenerClaveIntento($email);

            if ($this->loginEstaLimitado($claveIntento)) {
                $_SESSION['error'] = "Demasiados intentos. Intenta nuevamente más tarde.";
                header('Location: /Tienda_ropa/publico/index.php?accion=iniciar_sesion');
                exit;
            }

            try {
                $usuario = $this->modelo->iniciarSesion($email, $password);

                if ($usuario) {
                    unset($_SESSION['intentos_login'][$claveIntento]);

                    // Almacenar datos de usuario en sesión actual
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['rol'] = $usuario['rol'];

                    // Regenerar ID de sesión para seguridad
                    session_regenerate_id(true);

                    // Redirigir según el rol
                    if ($usuario['rol'] === 'admin') {
                        header('Location: /Tienda_ropa/publico/index.php?accion=panel_admin');
                    } else {
                        header('Location: /Tienda_ropa/publico/index.php');
                    }
                    exit;
                } else {
                    // Credenciales incorrectas
                    $this->registrarIntentoFallido($claveIntento);
                    $_SESSION['error'] = "Credenciales incorrectas. Verifica tu email y contraseña.";
                    header('Location: /Tienda_ropa/publico/index.php?accion=iniciar_sesion');
                    exit;
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error de conexión: " . $e->getMessage();
                header('Location: /Tienda_ropa/publico/index.php?accion=iniciar_sesion');
                exit;
            }
        }

        // Restaurar mensaje de error previo si existe
        if ($error_previo) {
            $_SESSION['error'] = $error_previo;
        }

        // Cargar vista
        require_once __DIR__ . '/../vistas/usuarios/iniciar_sesion.php';
    }

    private function obtenerClaveIntento(string $email): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        return hash('sha256', strtolower(trim($email)) . '|' . $ip);
    }

    private function loginEstaLimitado(string $clave): bool
    {
        $intento = $_SESSION['intentos_login'][$clave] ?? null;
        if ($intento === null) {
            return false;
        }

        if (time() - $intento['inicio'] >= self::VENTANA_LOGIN_SEGUNDOS) {
            unset($_SESSION['intentos_login'][$clave]);
            return false;
        }

        return $intento['cantidad'] >= self::MAX_INTENTOS_LOGIN;
    }

    private function registrarIntentoFallido(string $clave): void
    {
        $intento = $_SESSION['intentos_login'][$clave] ?? null;
        if ($intento === null || time() - $intento['inicio'] >= self::VENTANA_LOGIN_SEGUNDOS) {
            $_SESSION['intentos_login'][$clave] = [
                'cantidad' => 1,
                'inicio' => time()
            ];
            return;
        }

        $_SESSION['intentos_login'][$clave]['cantidad']++;
    }

    // Método para cerrar sesión - CORREGIDO
    public function cerrarSesion() {
        // Guardar el rol para la redirección
        $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';

        // Limpiar y destruir la sesión
        $_SESSION = array();

        // Eliminar cookie de sesión si existe
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir la sesión
        session_destroy();

        // Redirigir según el rol
        if ($rol === 'admin') {
            header('Location: /Tienda_ropa/publico/index.php?accion=iniciar_sesion');
        } else {
            header('Location: /Tienda_ropa/publico/index.php');
        }
        exit;
    }

    // Método para registro de clientes
    public function registrarse() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            try {
                if ($this->modelo->registrar($nombre, $email, $password, 'cliente')) {
                    $_SESSION['mensaje'] = "Registro exitoso. Por favor, inicia sesión.";
                    header('Location: /Tienda_ropa/publico/index.php?accion=iniciar_sesion');
                    exit;
                } else {
                    $_SESSION['error'] = "Error en el registro.";
                }
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $_SESSION['error'] = "Error: El correo electrónico ya está registrado. Por favor, utiliza otro.";
                } else {
                    $_SESSION['error'] = "Error en el registro: " . $e->getMessage();
                }
            }
        }
        require_once __DIR__ . '/../vistas/usuarios/registrarse.php';
    }
}
