<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver;

use Corma\DBAL\Connection;
use Corma\DBAL\Driver\API\ExceptionConverter;
use Corma\DBAL\Driver\API\MySQL;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\MySQLPlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\MySQLSchemaManager;

/** @extends AbstractDriverTestCase<MySQLPlatform> */
abstract class AbstractMySQLDriverTestCase extends AbstractDriverTestCase
{
    protected function createPlatform(): AbstractPlatform
    {
        return new MySQLPlatform();
    }

    protected function createSchemaManager(Connection $connection): AbstractSchemaManager
    {
        return new MySQLSchemaManager(
            $connection,
            $this->createPlatform(),
        );
    }

    protected function createExceptionConverter(): ExceptionConverter
    {
        return new MySQL\ExceptionConverter();
    }
}
