<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    protected function crearStatementMock(array $fetch = [], ?int $rowCount = null)
    {
        $statement = $this->createMock(\PDOStatement::class);
        $statement->method('fetch')->willReturnOnConsecutiveCalls(...$fetch);
        $statement->method('fetchAll')->willReturn($fetch);
        if ($rowCount !== null) {
            $statement->method('rowCount')->willReturn($rowCount);
        }
        return $statement;
    }
}
