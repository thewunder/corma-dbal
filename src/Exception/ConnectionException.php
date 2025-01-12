<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Base class for all connection related errors detected in the driver.
 *
 * @psalm-immutable
 */
class ConnectionException extends DriverException
{
}
