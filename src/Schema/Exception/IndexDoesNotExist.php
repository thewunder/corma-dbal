<?php

declare(strict_types=1);

namespace Corma\DBAL\Schema\Exception;

use Corma\DBAL\Schema\SchemaException;
use LogicException;

use function sprintf;

/** @psalm-immutable */
final class IndexDoesNotExist extends LogicException implements SchemaException
{
    public static function new(string $indexName, string $table): self
    {
        return new self(sprintf('Index "%s" does not exist on table "%s".', $indexName, $table));
    }
}
