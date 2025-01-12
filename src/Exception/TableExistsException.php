<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for an already existing table referenced in a statement detected in the driver.
 *
 * @psalm-immutable
 */
class TableExistsException extends DatabaseObjectExistsException
{
}
