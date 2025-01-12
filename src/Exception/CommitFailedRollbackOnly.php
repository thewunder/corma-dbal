<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\ConnectionException;

/** @psalm-immutable */
final class CommitFailedRollbackOnly extends ConnectionException
{
    public static function new(): self
    {
        return new self('Transaction commit failed because the transaction has been marked for rollback only.');
    }
}
