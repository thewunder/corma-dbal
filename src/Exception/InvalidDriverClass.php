<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\Driver;

use function sprintf;

/** @psalm-immutable */
final class InvalidDriverClass extends InvalidArgumentException
{
    public static function new(string $driverClass): self
    {
        return new self(
            sprintf(
                'The given driver class %s has to implement the %s interface.',
                $driverClass,
                Driver::class,
            ),
        );
    }
}
