<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\ConnectionException;

/** @psalm-immutable */
final class SavepointsNotSupported extends ConnectionException
{
    public static function new(): self
    {
        return new self('Savepoints are not supported by this driver.');
    }
}
