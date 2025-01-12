<?php

declare(strict_types=1);

namespace Corma\DBAL\ArrayParameters\Exception;

use Corma\DBAL\ArrayParameters\Exception;
use LogicException;

use function sprintf;

/** @psalm-immutable */
class MissingNamedParameter extends LogicException implements Exception
{
    public static function new(string $name): self
    {
        return new self(
            sprintf('Named parameter "%s" does not have a bound value.', $name),
        );
    }
}
