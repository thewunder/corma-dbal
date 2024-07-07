<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for a deadlock error of a transaction detected in the driver.
 *
 * @psalm-immutable
 */
class DeadlockException extends ServerException implements RetryableException
{
}
