<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\Middleware;

use Corma\DBAL\Driver;
use Corma\DBAL\Driver\API\ExceptionConverter;
use Corma\DBAL\Driver\Connection as DriverConnection;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\ServerVersionProvider;
use SensitiveParameter;

abstract class AbstractDriverMiddleware implements Driver
{
    public function __construct(private readonly Driver $wrappedDriver)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function connect(
        #[SensitiveParameter]
        array $params,
    ): DriverConnection {
        return $this->wrappedDriver->connect($params);
    }

    public function getDatabasePlatform(ServerVersionProvider $versionProvider): AbstractPlatform
    {
        return $this->wrappedDriver->getDatabasePlatform($versionProvider);
    }

    public function getExceptionConverter(): ExceptionConverter
    {
        return $this->wrappedDriver->getExceptionConverter();
    }
}
