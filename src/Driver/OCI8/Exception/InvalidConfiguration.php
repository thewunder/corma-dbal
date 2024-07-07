<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\OCI8\Exception;

use Corma\DBAL\Driver\AbstractException;

/**
 * @internal
 *
 * @psalm-immutable
 */
final class InvalidConfiguration extends AbstractException
{
    public static function forPersistentAndExclusive(): self
    {
        return new self('The "persistent" parameter and the "exclusive" driver option are mutually exclusive');
    }
}
