<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Portability;

use Corma\DBAL\Driver\Connection as ConnectionInterface;
use Corma\DBAL\Portability\Connection;
use Corma\DBAL\Portability\Converter;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public function testGetServerVersion(): void
    {
        $driverConnection = $this->createMock(ConnectionInterface::class);
        $driverConnection->expects(self::once())
            ->method('getServerVersion')
            ->willReturn('1.2.3');

        $connection = new Connection($driverConnection, new Converter(false, false, Converter::CASE_LOWER));

        self::assertSame('1.2.3', $connection->getServerVersion());
    }

    public function testGetNativeConnection(): void
    {
        $nativeConnection = new class () {
        };

        $driverConnection = $this->createMock(ConnectionInterface::class);
        $driverConnection->method('getNativeConnection')
            ->willReturn($nativeConnection);

        $connection = new Connection($driverConnection, new Converter(false, false, Converter::CASE_LOWER));

        self::assertSame($nativeConnection, $connection->getNativeConnection());
    }
}
