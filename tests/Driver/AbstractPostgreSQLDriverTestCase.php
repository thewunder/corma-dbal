<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver;

use Corma\DBAL\Connection;
use Corma\DBAL\Driver\API\ExceptionConverter;
use Corma\DBAL\Driver\API\PostgreSQL;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\PostgreSQLSchemaManager;

/** @extends AbstractDriverTestCase<PostgreSQLPlatform> */
abstract class AbstractPostgreSQLDriverTestCase extends AbstractDriverTestCase
{
    protected function createPlatform(): AbstractPlatform
    {
        return new PostgreSQLPlatform();
    }

    protected function createSchemaManager(Connection $connection): AbstractSchemaManager
    {
        return new PostgreSQLSchemaManager(
            $connection,
            $this->createPlatform(),
        );
    }

    protected function createExceptionConverter(): ExceptionConverter
    {
        return new PostgreSQL\ExceptionConverter();
    }
}
