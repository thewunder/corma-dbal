<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver;

use Corma\DBAL\Connection;
use Corma\DBAL\Driver\API\ExceptionConverter;
use Corma\DBAL\Driver\API\SQLite;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\SQLitePlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\SQLiteSchemaManager;

/** @extends AbstractDriverTestCase<SQLitePlatform> */
abstract class AbstractSQLiteDriverTestCase extends AbstractDriverTestCase
{
    protected function createPlatform(): AbstractPlatform
    {
        return new SQLitePlatform();
    }

    protected function createSchemaManager(Connection $connection): AbstractSchemaManager
    {
        return new SQLiteSchemaManager(
            $connection,
            $this->createPlatform(),
        );
    }

    protected function createExceptionConverter(): ExceptionConverter
    {
        return new SQLite\ExceptionConverter();
    }

    public function testThrowsExceptionOnCreatingDatabasePlatformsForInvalidVersion(): void
    {
        self::markTestSkipped('SQLite drivers do not use server version to instantiate platform');
    }
}
