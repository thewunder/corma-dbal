<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\Mysqli\Exception;

use Corma\DBAL\Driver\AbstractException;

use function sprintf;

/**
 * @internal
 *
 * @psalm-immutable
 */
final class InvalidOption extends AbstractException
{
    public static function fromOption(int $option, mixed $value): self
    {
        return new self(
            sprintf('Failed to set option %d with value "%s"', $option, $value),
        );
    }
}
