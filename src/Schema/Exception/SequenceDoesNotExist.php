<?php

declare(strict_types=1);

namespace Corma\DBAL\Schema\Exception;

use Corma\DBAL\Schema\SchemaException;
use LogicException;

use function sprintf;

/** @psalm-immutable */
final class SequenceDoesNotExist extends LogicException implements SchemaException
{
    public static function new(string $sequenceName): self
    {
        return new self(sprintf('There exists no sequence with the name "%s".', $sequenceName));
    }
}
