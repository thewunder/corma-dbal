<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver;

use Corma\DBAL\Driver;
use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\API\SQLite\ExceptionConverter;
use Corma\DBAL\Platforms\SQLitePlatform;
use Corma\DBAL\ServerVersionProvider;

/**
 * Abstract base implementation of the {@see Driver} interface for SQLite based drivers.
 */
abstract class AbstractSQLiteDriver implements Driver
{
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): SQLitePlatform
    {
        return new SQLitePlatform();
    }

    public function getExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }
}
