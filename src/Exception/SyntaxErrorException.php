<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for a syntax error in a statement detected in the driver.
 *
 * @psalm-immutable
 */
class SyntaxErrorException extends ServerException
{
}
