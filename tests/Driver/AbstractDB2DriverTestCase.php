<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver;

use Corma\DBAL\Connection;
use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\API\IBMDB2\ExceptionConverter;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\DB2Platform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\DB2SchemaManager;

/** @extends AbstractDriverTestCase<DB2Platform> */
abstract class AbstractDB2DriverTestCase extends AbstractDriverTestCase
{
    protected function createPlatform(): AbstractPlatform
    {
        return new DB2Platform();
    }

    protected function createSchemaManager(Connection $connection): AbstractSchemaManager
    {
        return new DB2SchemaManager(
            $connection,
            $this->createPlatform(),
        );
    }

    protected function createExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }
}
