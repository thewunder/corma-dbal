<?php

declare(strict_types=1);

namespace Corma\DBAL\Query\Exception;

use Corma\DBAL\Query\QueryException;

use function implode;
use function sprintf;

/** @psalm-immutable */
final class UnknownAlias extends QueryException
{
    /** @param string[] $registeredAliases */
    public static function new(string $alias, array $registeredAliases): self
    {
        return new self(
            sprintf(
                'The given alias "%s" is not part of any FROM or JOIN clause table. '
                    . 'The currently registered aliases are: %s.',
                $alias,
                implode(', ', $registeredAliases),
            ),
        );
    }
}
