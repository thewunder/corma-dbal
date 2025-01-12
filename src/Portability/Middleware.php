<?php

declare(strict_types=1);

namespace Corma\DBAL\Portability;

use Corma\DBAL\ColumnCase;
use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\Middleware as MiddlewareInterface;

final class Middleware implements MiddlewareInterface
{
    public function __construct(private readonly int $mode, private readonly ?ColumnCase $case)
    {
    }

    public function wrap(DriverInterface $driver): DriverInterface
    {
        if ($this->mode !== 0) {
            return new Driver($driver, $this->mode, $this->case);
        }

        return $driver;
    }
}
