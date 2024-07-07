<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for a foreign key constraint violation detected in the driver.
 *
 * @psalm-immutable
 */
class ForeignKeyConstraintViolationException extends ConstraintViolationException
{
}
