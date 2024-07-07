<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\PgSQL\Exception;

use Corma\DBAL\Driver\AbstractException;

use function sprintf;

/** @psalm-immutable */
final class UnknownParameter extends AbstractException
{
    public static function new(string $param): self
    {
        return new self(
            sprintf('Could not find parameter %s in the SQL statement', $param),
        );
    }
}
