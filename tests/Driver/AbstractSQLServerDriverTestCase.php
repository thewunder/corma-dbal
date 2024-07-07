<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver;

use Corma\DBAL\Connection;
use Corma\DBAL\Driver\AbstractSQLServerDriver\Exception\PortWithoutHost;
use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\API\SQLSrv\ExceptionConverter;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\SQLServerPlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\SQLServerSchemaManager;

/** @extends AbstractDriverTestCase<SQLServerPlatform> */
abstract class AbstractSQLServerDriverTestCase extends AbstractDriverTestCase
{
    protected function createPlatform(): AbstractPlatform
    {
        return new SQLServerPlatform();
    }

    protected function createSchemaManager(Connection $connection): AbstractSchemaManager
    {
        return new SQLServerSchemaManager(
            $connection,
            $this->createPlatform(),
        );
    }

    protected function createExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }

    public function testPortWithoutHost(): void
    {
        $this->expectException(PortWithoutHost::class);
        $this->driver->connect(['port' => 1433]);
    }

    public function testThrowsExceptionOnCreatingDatabasePlatformsForInvalidVersion(): void
    {
        self::markTestSkipped('SQL Server drivers do not use server version to instantiate platform');
    }
}
