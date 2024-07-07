<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\Middleware;

use Corma\DBAL\Driver;
use Corma\DBAL\Driver\Connection;
use Corma\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use PHPUnit\Framework\TestCase;

final class AbstractDriverMiddlewareTest extends TestCase
{
    public function testConnect(): void
    {
        $connection = $this->createMock(Connection::class);
        $driver     = $this->createMock(Driver::class);
        $driver->expects(self::once())
            ->method('connect')
            ->with(['host' => 'localhost'])
            ->willReturn($connection);

        self::assertSame($connection, $this->createMiddleware($driver)->connect(['host' => 'localhost']));
    }

    private function createMiddleware(Driver $driver): AbstractDriverMiddleware
    {
        return new class ($driver) extends AbstractDriverMiddleware {
        };
    }
}
