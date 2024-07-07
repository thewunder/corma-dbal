<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception\InvalidColumnType;

use Corma\DBAL\Exception\InvalidColumnType;

/**
 * @internal
 *
 * @psalm-immutable
 */
final class ColumnScaleRequired extends InvalidColumnType
{
    public static function new(): self
    {
        return new self('Column scale is not specified');
    }
}
