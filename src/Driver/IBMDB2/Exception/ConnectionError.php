<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\IBMDB2\Exception;

use Corma\DBAL\Driver\AbstractException;

use function db2_conn_error;
use function db2_conn_errormsg;

/**
 * @internal
 *
 * @psalm-immutable
 */
final class ConnectionError extends AbstractException
{
    /** @param resource $connection */
    public static function new($connection): self
    {
        $message  = db2_conn_errormsg($connection);
        $sqlState = db2_conn_error($connection);

        return Factory::create($message, static fn(int $code): self => new self($message, $sqlState, $code));
    }
}
