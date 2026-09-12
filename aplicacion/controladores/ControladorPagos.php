<?php
// aplicacion/controladores/ControladorPagos.php

namespace Tienda\Controladores;

require_once __DIR__ . '/../../configuracion/config.php';
require_once __DIR__ . '/../../configuracion/uploads.php';

use Tienda\Modelos\ModeloProductos;
use Exception;
use PDO;
use RuntimeException;

class ControladorPagos {
    private $db;

    public function __construct(?PDO $db = null) {
        if ($db !== null) {
            $this->db = $db;
            return;
        }

        global $db;
        $this->db = $db;
    }

    // Método para mostrar la página de pago con Yape
    public function pagoYape() {
        // Verificar si hay un total de pedido en la sesión
        if (!isset($_SESSION['total_pedido']) || !isset($_SESSION['usuario_id'])) {
            header('Location: /Tienda_ropa/publico/index.php?accion=ver_carrito');
            exit;
        }

        // Cargar la vista de pago con Yape
        $total = $_SESSION['total_pedido'];
        require_once __DIR__ . '/../vistas/carrito/pago_yape.php';
    }

    // Método para procesar el pago con Yape
    public function procesarPagoYape() {
        // Verificar si el usuario ha iniciado sesión y tiene carrito
        if (!isset($_SESSION['usuario_id']) || empty($_SESSION['carrito'])) {
            header('Location: /Tienda_ropa/publico/index.php?accion=ver_carrito');
            exit;
        }

        // Validar que se haya subido un comprobante
        if (!isset($_FILES['comprobante']) || $_FILES['comprobante']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_pago'] = "Debes subir un comprobante de pago.";
            header('Location: /Tienda_ropa/publico/index.php?accion=pago_yape');
            exit;
        }

        // Asegurarse de que el directorio existe
        $directorioComprobantes = __DIR__ . '/../../comprobantes/';
        try {
            $nombreArchivo = guardar_imagen_subida($_FILES['comprobante'], $directorioComprobantes);
        } catch (RuntimeException $e) {
            $_SESSION['error_pago'] = "Hubo un error al subir el comprobante.";
            header('Location: /Tienda_ropa/publico/index.php?accion=pago_yape');
            exit;
        }

        try {
            // Crear el pedido
            $pedidoId = $this->crearPedido($nombreArchivo);
            
            // Redirigir a la página de detalles del pedido (usando el ControladorPedidos)
            header('Location: /Tienda_ropa/publico/index.php?accion=ver_pedidos&id=' . $pedidoId);
            exit;
        } catch (Exception $e) {
            $_SESSION['error_pago'] = "Error al procesar el pago: " . $e->getMessage();
            header('Location: /Tienda_ropa/publico/index.php?accion=pago_yape');
            exit;
        }
    }

    // Método para crear el pedido
    private function crearPedido($nombreComprobante) {
        // Verificar si el usuario tiene un carrito
        if (empty($_SESSION['carrito'])) {
            throw new Exception("El carrito está vacío.");
        }

        try {
            // Iniciar transacción
            $this->db->beginTransaction();
            
            // Datos del pedido
            $usuarioId = $_SESSION['usuario_id'];
            $fecha = date('Y-m-d H:i:s');
            $estado = 'pendiente'; // Cambiar a 'pagado' después de validar el comprobante
            $total = 0;
            $productos = [];

            // Bloquear cada producto en esta misma transacción para evitar sobreventa.
            foreach ($_SESSION['carrito'] as $productoId => $cantidad) {
                $cantidad = filter_var($cantidad, FILTER_VALIDATE_INT, [
                    'options' => ['min_range' => 1]
                ]);
                if ($cantidad === false) {
                    throw new Exception("La cantidad del producto no es válida.");
                }

                $query = "SELECT id, precio, stock
                          FROM productos
                          WHERE id = :producto_id
                          FOR UPDATE";
                $stmt = $this->db->prepare($query);
                $stmt->execute([':producto_id' => $productoId]);
                $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$producto || (int) $producto['stock'] < $cantidad) {
                    throw new Exception("Stock insuficiente para uno de los productos.");
                }

                $productos[] = [
                    'id' => $producto['id'],
                    'cantidad' => $cantidad,
                    'precio' => (float) $producto['precio']
                ];
                $total += (float) $producto['precio'] * $cantidad;
            }

            // Insertar pedido
            $query = "INSERT INTO pedidos (usuario_id, fecha, total, estado, comprobante) VALUES (:usuario_id, :fecha, :total, :estado, :comprobante)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':fecha' => $fecha,
                ':total' => $total,
                ':estado' => $estado,
                ':comprobante' => $nombreComprobante
            ]);
            $pedidoId = $this->db->lastInsertId();

            // Descontar stock y crear detalles mientras las filas siguen bloqueadas.
            foreach ($productos as $producto) {
                $query = "UPDATE productos
                          SET stock = stock - :cantidad
                          WHERE id = :producto_id
                            AND stock >= :cantidad";
                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    ':producto_id' => $producto['id'],
                    ':cantidad' => $producto['cantidad']
                ]);

                if ($stmt->rowCount() !== 1) {
                    throw new Exception("No se pudo actualizar el stock del producto.");
                }

                $query = "INSERT INTO detalles_pedido
                          (pedido_id, producto_id, cantidad, precio_unitario)
                          VALUES (:pedido_id, :producto_id, :cantidad, :precio_unitario)";
                $stmt = $this->db->prepare($query);
                $stmt->execute([
                    ':pedido_id' => $pedidoId,
                    ':producto_id' => $producto['id'],
                    ':cantidad' => $producto['cantidad'],
                    ':precio_unitario' => $producto['precio']
                ]);
            }

            // Confirmar transacción
            $this->db->commit();

            // Limpiar carrito y total de sesión
            unset($_SESSION['carrito']);
            unset($_SESSION['total_pedido']);

            return $pedidoId;
        } catch (Exception $e) {
            // Si hay algún error, revertir la transacción
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }
}