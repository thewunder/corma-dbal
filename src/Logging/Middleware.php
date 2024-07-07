<?php

declare(strict_types=1);

namespace Corma\DBAL\Logging;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\Middleware as MiddlewareInterface;
use Psr\Log\LoggerInterface;

final class Middleware implements MiddlewareInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function wrap(DriverInterface $driver): DriverInterface
    {
        return new Driver($driver, $this->logger);
    }
}
