<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for a unique constraint violation detected in the driver.
 *
 * @psalm-immutable
 */
class UniqueConstraintViolationException extends ConstraintViolationException
{
}
