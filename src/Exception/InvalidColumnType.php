<?php

declare(strict_types=1);

namespace Corma\DBAL\Exception;

use Corma\DBAL\Exception;
use LogicException;

/** @psalm-immutable */
abstract class InvalidColumnType extends LogicException implements Exception
{
}
