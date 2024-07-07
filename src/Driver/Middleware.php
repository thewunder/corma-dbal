<?php

declare(strict_types=1);

namespace Corma\DBAL\Driver;

use Corma\DBAL\Driver;

interface Middleware
{
    public function wrap(Driver $driver): Driver;
}
