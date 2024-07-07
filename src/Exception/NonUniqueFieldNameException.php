<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for a non-unique/ambiguous specified field name in a statement detected in the driver.
 *
 * @psalm-immutable
 */
class NonUniqueFieldNameException extends ServerException
{
}
