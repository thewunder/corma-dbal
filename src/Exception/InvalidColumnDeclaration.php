<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\Exception;
use LogicException;

use function sprintf;

/** @psalm-immutable */
final class InvalidColumnDeclaration extends LogicException implements Exception
{
    public static function fromInvalidColumnType(string $columnName, InvalidColumnType $e): self
    {
        return new self(sprintf('Column "%s" has invalid type', $columnName), 0, $e);
    }
}
