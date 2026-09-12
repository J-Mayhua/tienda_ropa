<?php

namespace Tests;

use PDO;
use Tienda\Modelos\ModeloProductos;

final class ModeloProductosTest extends TestCase
{
    public function testObtenerProductoUsaIdPreparado(): void
    {
        $pdo = $this->createMock(PDO::class);
        $consulta = $this->createMock(\PDOStatement::class);
        $consulta->expects($this->once())->method('execute')->with([':id' => 7]);
        $consulta->method('fetch')->willReturn(['id' => 7, 'stock' => 3]);
        $pdo->expects($this->once())->method('prepare')->willReturn($consulta);

        $producto = (new ModeloProductos($pdo))->obtenerPorId(7);

        $this->assertSame(3, $producto['stock']);
    }
}
