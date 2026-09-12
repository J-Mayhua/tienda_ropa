<?php

namespace Tests;

use Exception;
use PDO;
use PDOException;
use ReflectionMethod;
use Tienda\Controladores\ControladorPagos;

final class ControladorPagosTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [
            'usuario_id' => 8,
            'carrito' => [3 => 2],
            'total_pedido' => 0
        ];
    }

    public function testFinalizarCompraRechazaStockInsuficienteYHaceRollback(): void
    {
        $_SESSION['carrito'] = [3 => 2];
        $pdo = $this->createMock(PDO::class);
        $producto = $this->createMock(\PDOStatement::class);
        $producto->method('fetch')->willReturn(['id' => 3, 'precio' => 25, 'stock' => 1]);

        $pdo->expects($this->once())->method('beginTransaction');
        $pdo->expects($this->once())->method('prepare')->willReturn($producto);
        $pdo->expects($this->once())->method('rollBack');
        $pdo->method('inTransaction')->willReturn(true);

        $metodo = new ReflectionMethod(ControladorPagos::class, 'crearPedido');
        $metodo->setAccessible(true);

        $this->expectException(Exception::class);
        $metodo->invoke(new ControladorPagos($pdo), 'comprobante.jpg');
    }

    public function testFinalizarCompraDescuentaStockDentroDeTransaccion(): void
    {
        $pdo = $this->createMock(PDO::class);
        $producto = $this->createMock(\PDOStatement::class);
        $producto->method('fetch')->willReturn(['id' => 3, 'precio' => 25, 'stock' => 5]);
        $pedido = $this->createMock(\PDOStatement::class);
        $actualizacion = $this->createMock(\PDOStatement::class);
        $actualizacion->method('rowCount')->willReturn(1);
        $detalle = $this->createMock(\PDOStatement::class);

        $pdo->expects($this->once())->method('beginTransaction');
        $pdo->expects($this->exactly(4))->method('prepare')
            ->willReturnOnConsecutiveCalls($producto, $pedido, $actualizacion, $detalle);
        $pdo->method('lastInsertId')->willReturn('42');
        $pdo->expects($this->once())->method('commit');
        $actualizacion->expects($this->once())->method('execute')
            ->with($this->callback(fn (array $datos): bool => $datos[':cantidad'] === 2));

        $metodo = new ReflectionMethod(ControladorPagos::class, 'crearPedido');
        $metodo->setAccessible(true);

        $resultado = $metodo->invoke(new ControladorPagos($pdo), 'comprobante.jpg');

        $this->assertSame('42', $resultado);
        $this->assertArrayNotHasKey('carrito', $_SESSION);
    }

    public function testFinalizarCompraHaceRollbackSiFallaDetalle(): void
    {
        $_SESSION['carrito'] = [3 => 1];
        $pdo = $this->createMock(PDO::class);
        $producto = $this->createMock(\PDOStatement::class);
        $producto->method('fetch')->willReturn(['id' => 3, 'precio' => 25, 'stock' => 5]);
        $pedido = $this->createMock(\PDOStatement::class);
        $actualizacion = $this->createMock(\PDOStatement::class);
        $actualizacion->method('rowCount')->willReturn(1);
        $detalle = $this->createMock(\PDOStatement::class);
        $detalle->method('execute')->willThrowException(new PDOException('fallo simulado'));

        $pdo->method('prepare')
            ->willReturnOnConsecutiveCalls($producto, $pedido, $actualizacion, $detalle);
        $pdo->method('inTransaction')->willReturn(true);
        $pdo->expects($this->once())->method('rollBack');

        $metodo = new ReflectionMethod(ControladorPagos::class, 'crearPedido');
        $metodo->setAccessible(true);

        $this->expectException(PDOException::class);
        $metodo->invoke(new ControladorPagos($pdo), 'comprobante.jpg');
    }
}
