<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\Connection;

use function sprintf;

/** @psalm-immutable */
final class InvalidWrapperClass extends InvalidArgumentException
{
    public static function new(string $wrapperClass): self
    {
        return new self(
            sprintf(
                'The given wrapper class %s has to be a subtype of %s.',
                $wrapperClass,
                Connection::class,
            ),
        );
    }
}
