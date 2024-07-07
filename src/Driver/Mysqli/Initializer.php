<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver\Mysqli;

use Corma\DBAL\Driver\Exception;
use mysqli;

interface Initializer
{
    /** @throws Exception */
    public function initialize(mysqli $connection): void;
}
