<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver;

use Corma\DBAL\Driver;
use Corma\DBAL\Driver\API\ExceptionConverter as ExceptionConverterInterface;
use Corma\DBAL\Driver\API\IBMDB2\ExceptionConverter;
use Corma\DBAL\Platforms\DB2Platform;
use Corma\DBAL\ServerVersionProvider;

/**
 * Abstract base implementation of the {@see Driver} interface for IBM DB2 based drivers.
 */
abstract class AbstractDB2Driver implements Driver
{
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): DB2Platform
    {
        return new DB2Platform();
    }

    public function getExceptionConverter(): ExceptionConverterInterface
    {
        return new ExceptionConverter();
    }
}
