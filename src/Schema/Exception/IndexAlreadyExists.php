<?php

declare(strict_types=1);

namespace Corma\DBAL\Schema\Exception;

use Corma\DBAL\Schema\SchemaException;
use LogicException;

use function sprintf;

/** @psalm-immutable */
final class IndexAlreadyExists extends LogicException implements SchemaException
{
    public static function new(string $indexName, string $table): self
    {
        return new self(
            sprintf('An index with name "%s" was already defined on table "%s".', $indexName, $table),
        );
    }
}
