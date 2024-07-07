<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for a NOT NULL constraint violation detected in the driver.
 *
 * @psalm-immutable
 */
class NotNullConstraintViolationException extends ConstraintViolationException
{
}
