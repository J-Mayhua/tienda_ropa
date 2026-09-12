<?php
// aplicacion/modelos/ModeloUsuarios.php

namespace Tienda\Modelos;

require_once __DIR__ . '/../../configuracion/config.php';

use Tienda\Soporte\Logger;
use Tienda\Soporte\Validador;
use PDO;
use PDOException;

class ModeloUsuarios {
    private $db;

    public function __construct(?PDO $conexion = null) {
        if ($conexion !== null) {
            $this->db = $conexion;
            return;
        }

        global $db; // Usar la conexión global
        $this->db = $db;
    }

    /**
     * Registrar un nuevo usuario.
     *
     * @param string $nombre Nombre del usuario.
     * @param string $email Email del usuario.
     * @param string $contrasena Contraseña del usuario.
     * @param string $rol Rol del usuario (por defecto: 'cliente').
     * @return bool True si se registró correctamente, false en caso contrario.
     */
    public function registrar($nombre, $email, $contrasena, $rol = 'cliente') {
        if (!Validador::requeridos(
                compact('nombre', 'email', 'contrasena', 'rol'),
                ['nombre', 'email', 'contrasena', 'rol']
            )
            || !Validador::email($email)
            || !Validador::password($contrasena)) {
            return false;
        }

        try {
            // Verificar si el email ya está registrado
            $query = "SELECT id FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                Logger::obtener()->warning('Email ya registrado', ['email' => $email]);
                return false; // Email ya registrado
            }

            // Hash de la contraseña
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
            Logger::obtener()->info('Hash de contraseña creado', ['email' => $email]);

            // Insertar el nuevo usuario
            $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :contrasena, :rol)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':contrasena' => $contrasenaHash,
                ':rol' => $rol
            ]);
            Logger::obtener()->info('Usuario registrado', ['email' => $email]);
            return true;
        } catch (PDOException $e) {
            Logger::obtener()->error('Error al registrar usuario', ['exception' => $e]);
            throw $e; // Relanzar la excepción para ser capturada por el controlador
        }
    }

    /**
     * Iniciar sesión de usuario.
     *
     * @param string $email Email del usuario.
     * @param string $contrasena Contraseña del usuario.
     * @return array|false Datos del usuario si las credenciales son válidas, false en caso contrario.
     */
    public function iniciarSesion($email, $contrasena) {
        try {
            Logger::obtener()->info('Intento de inicio de sesión', ['email' => $email]);
            
            $query = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                Logger::obtener()->warning('Usuario no encontrado', ['email' => $email]);
                return false;
            }

            Logger::obtener()->info('Usuario encontrado', ['email' => $email]);
            
            // Para depuración, verificar el hash almacenado
            if (password_verify($contrasena, $usuario['password'])) {
                Logger::obtener()->info('Contraseña verificada', ['email' => $email]);
                return $usuario;
            } else {
                Logger::obtener()->warning('Contraseña incorrecta', ['email' => $email]);
                return false;
            }
        } catch (PDOException $e) {
            Logger::obtener()->error('Error de base de datos en inicio de sesión', ['exception' => $e]);
            throw $e; // Relanzar la excepción para ser capturada por el controlador
        }
    }

    /**
     * Obtener todos los usuarios.
     *
     * @return array Lista de usuarios.
     */
    public function obtenerUsuarios() {
        try {
            $query = "SELECT * FROM usuarios";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Logger::obtener()->error('Error al obtener usuarios', ['exception' => $e]);
            return [];
        }
    }

    /**
     * Obtener un usuario por su ID.
     *
     * @param int $id ID del usuario.
     * @return array|false Datos del usuario o false si no se encuentra.
     */
    public function obtenerUsuarioPorId($id) {
        try {
            $query = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Logger::obtener()->error('Error al obtener usuario por ID', ['exception' => $e]);
            return false;
        }
    }

    /**
     * Actualizar un usuario.
     *
     * @param int $id ID del usuario.
     * @param string $nombre Nombre del usuario.
     * @param string $email Email del usuario.
     * @param string $rol Rol del usuario.
     * @return bool True si se actualizó correctamente, false en caso contrario.
     */
    public function actualizarUsuario($id, $nombre, $email, $rol) {
        try {
            $query = "UPDATE usuarios SET nombre = :nombre, email = :email, rol = :rol WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $id,
                ':nombre' => $nombre,
                ':email' => $email,
                ':rol' => $rol
            ]);
            return true;
        } catch (PDOException $e) {
            Logger::obtener()->error('Error al actualizar usuario', ['exception' => $e]);
            return false;
        }
    }

    /**
     * Eliminar un usuario.
     *
     * @param int $id ID del usuario.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function eliminarUsuario($id) {
        try {
            $query = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            Logger::obtener()->error('Error al eliminar usuario', ['exception' => $e]);
            return false;
        }
    }

    /**
     * Contar el número total de usuarios.
     *
     * @return int Número total de usuarios.
     */
    public function contarUsuarios() {
        try {
            $query = "SELECT COUNT(*) AS total FROM usuarios";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            Logger::obtener()->error('Error al contar usuarios', ['exception' => $e]);
            return 0;
        }
    }
}