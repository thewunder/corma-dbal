<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\Exception;

use Corma\DBAL\Driver\AbstractException;
use Throwable;

/**
 * @internal
 *
 * @psalm-immutable
 */
final class IdentityColumnsNotSupported extends AbstractException
{
    public static function new(?Throwable $previous = null): self
    {
        return new self('The driver does not support identity columns.', null, 0, $previous);
    }
}
