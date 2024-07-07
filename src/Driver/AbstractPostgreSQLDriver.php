<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver;

use Corma\DBAL\Driver;
use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\API\PostgreSQL\ExceptionConverter;
use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\ServerVersionProvider;

/**
 * Abstract base implementation of the {@see Driver} interface for PostgreSQL based drivers.
 */
abstract class AbstractPostgreSQLDriver implements Driver
{
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): PostgreSQLPlatform
    {
        return new PostgreSQLPlatform();
    }

    public function getExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }
}
