<?php

declare(strict_types=1);

namespace Corma\DBAL\ArrayParameters\Exception;

use Corma\DBAL\ArrayParameters\Exception;
use LogicException;

use function sprintf;

/**
 * @internal
 *
 * @psalm-immutable
 */
class MissingPositionalParameter extends LogicException implements Exception
{
    public static function new(int $index): self
    {
        return new self(
            sprintf('Positional parameter at index %d does not have a bound value.', $index),
        );
    }
}
