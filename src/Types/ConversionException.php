<?php

declare(strict_types=1);

namespace Corma\DBAL\Types;

use Corma\DBAL\Exception;

/**
 * Conversion Exception is thrown when the database to PHP conversion fails.
 *
 * @psalm-immutable
 */
class ConversionException extends \Exception implements Exception
{
}
