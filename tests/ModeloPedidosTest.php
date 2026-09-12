<?php

namespace Tests;

use PDO;
use Tienda\Modelos\ModeloPedidos;

final class ModeloPedidosTest extends TestCase
{
    public function testObtenerPedidosPorUsuarioEnlazaUsuario(): void
    {
        $pdo = $this->createMock(PDO::class);
        $consulta = $this->createMock(\PDOStatement::class);
        $consulta->expects($this->once())->method('execute')->with([':usuario_id' => 4]);
        $consulta->method('fetchAll')->willReturn([['id' => 10, 'usuario_id' => 4]]);
        $pdo->expects($this->once())->method('prepare')->willReturn($consulta);

        $pedidos = (new ModeloPedidos($pdo))->obtenerPedidosPorUsuario(4);

        $this->assertCount(1, $pedidos);
        $this->assertSame(10, $pedidos[0]['id']);
    }
}
