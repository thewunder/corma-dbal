<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for a lock wait timeout error of a transaction detected in the driver.
 *
 * @psalm-immutable
 */
class LockWaitTimeoutException extends ServerException implements RetryableException
{
}
