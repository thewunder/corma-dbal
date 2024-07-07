<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\Exception;

/**
 * Exception to be thrown when invalid arguments are passed to any DBAL API
 *
 * @psalm-immutable
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{
}
