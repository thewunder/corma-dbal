<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\ConnectionException;

/** @psalm-immutable */
final class NoActiveTransaction extends ConnectionException
{
    public static function new(): self
    {
        return new self('There is no active transaction.');
    }
}
