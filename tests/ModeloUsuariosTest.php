<?php

namespace Tests;

use PDO;
use Tienda\Modelos\ModeloUsuarios;

final class ModeloUsuariosTest extends TestCase
{
    public function testRegistrarUsuarioConEmailNuevo(): void
    {
        $pdo = $this->createMock(PDO::class);
        $consultaEmail = $this->createMock(\PDOStatement::class);
        $consultaEmail->method('fetch')->willReturn(false);
        $insercion = $this->createMock(\PDOStatement::class);

        $pdo->expects($this->exactly(2))
            ->method('prepare')
            ->willReturnOnConsecutiveCalls($consultaEmail, $insercion);
        $consultaEmail->expects($this->once())->method('execute');
        $insercion->expects($this->once())->method('execute')
            ->with($this->callback(fn (array $datos): bool =>
                $datos[':email'] === 'ana@example.com' &&
                password_verify('password-segura', $datos[':contrasena'])
            ));

        $modelo = new ModeloUsuarios($pdo);

        $this->assertTrue($modelo->registrar('Ana', 'ana@example.com', 'password-segura'));
    }

    public function testRegistrarRechazaEmailDuplicado(): void
    {
        $pdo = $this->createMock(PDO::class);
        $consulta = $this->createMock(\PDOStatement::class);
        $consulta->method('fetch')->willReturn(['id' => 1]);
        $pdo->expects($this->once())->method('prepare')->willReturn($consulta);

        $this->assertFalse(
            (new ModeloUsuarios($pdo))->registrar('Ana', 'ana@example.com', 'password-segura')
        );
    }

    public function testLoginRechazaPasswordIncorrecto(): void
    {
        $pdo = $this->createMock(PDO::class);
        $consulta = $this->createMock(\PDOStatement::class);
        $consulta->method('fetch')->willReturn([
            'id' => 1,
            'email' => 'ana@example.com',
            'password' => password_hash('password-correcta', PASSWORD_DEFAULT),
            'rol' => 'cliente'
        ]);
        $pdo->method('prepare')->willReturn($consulta);

        $this->assertFalse(
            (new ModeloUsuarios($pdo))->iniciarSesion('ana@example.com', 'password-incorrecta')
        );
    }
}
