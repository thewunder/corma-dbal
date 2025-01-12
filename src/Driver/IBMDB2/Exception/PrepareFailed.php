<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\IBMDB2\Exception;

use Corma\DBAL\Driver\AbstractException;

/**
 * @internal
 *
 * @psalm-immutable
 */
final class PrepareFailed extends AbstractException
{
    /** @psalm-param array{message: string, ...}|null $error */
    public static function new(?array $error): self
    {
        if ($error === null) {
            return new self('Unknown error');
        }

        return new self($error['message']);
    }
}
