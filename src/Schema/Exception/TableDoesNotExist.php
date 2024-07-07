<?php

declare(strict_types=1);

namespace Corma\DBAL\Schema\Exception;

use Corma\DBAL\Schema\SchemaException;
use LogicException;

use function sprintf;

/** @psalm-immutable */
final class TableDoesNotExist extends LogicException implements SchemaException
{
    public static function new(string $tableName): self
    {
        return new self(sprintf('There is no table with name "%s" in the schema.', $tableName));
    }
}
