<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

/**
 * Exception for an unknown table referenced in a statement detected in the driver.
 *
 * @psalm-immutable
 */
class TableNotFoundException extends DatabaseObjectNotFoundException
{
}
