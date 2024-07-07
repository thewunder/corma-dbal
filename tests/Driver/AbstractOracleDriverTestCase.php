<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver;

use Corma\DBAL\Connection;
use Corma\DBAL\Driver\API\ExceptionConverter;
use Corma\DBAL\Driver\API\OCI;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\OraclePlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\OracleSchemaManager;

/** @extends AbstractDriverTestCase<OraclePlatform> */
abstract class AbstractOracleDriverTestCase extends AbstractDriverTestCase
{
    protected function createPlatform(): AbstractPlatform
    {
        return new OraclePlatform();
    }

    protected function createSchemaManager(Connection $connection): AbstractSchemaManager
    {
        return new OracleSchemaManager(
            $connection,
            $this->createPlatform(),
        );
    }

    protected function createExceptionConverter(): ExceptionConverter
    {
        return new OCI\ExceptionConverter();
    }

    public function testThrowsExceptionOnCreatingDatabasePlatformsForInvalidVersion(): void
    {
        self::markTestSkipped('Oracle drivers do not use server version to instantiate platform');
    }
}
