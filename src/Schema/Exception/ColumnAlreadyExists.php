<?php

declare(strict_types=1);

namespace Corma\DBAL\Schema\Exception;

use Corma\DBAL\Schema\SchemaException;
use LogicException;

use function sprintf;

/** @psalm-immutable */
final class ColumnAlreadyExists extends LogicException implements SchemaException
{
    public static function new(string $tableName, string $columnName): self
    {
        return new self(sprintf('The column "%s" on table "%s" already exists.', $columnName, $tableName));
    }
}
