<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\OCI8\Exception;

use Corma\DBAL\Driver\AbstractException;

use function assert;
use function oci_error;

/**
 * @internal
 *
 * @psalm-immutable
 */
final class ConnectionFailed extends AbstractException
{
    public static function new(): self
    {
        $error = oci_error();
        assert($error !== false);

        return new self($error['message'], null, $error['code']);
    }
}
