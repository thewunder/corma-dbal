<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\Exception;

use function sprintf;

/** @psalm-immutable */
class DatabaseRequired extends \Exception implements Exception
{
    public static function new(string $methodName): self
    {
        return new self(
            sprintf(
                'A database is required for the method: %s.',
                $methodName,
            ),
        );
    }
}
