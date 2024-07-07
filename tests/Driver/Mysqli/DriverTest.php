<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\Mysqli;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\Mysqli\Driver;
use Corma\DBAL\Tests\Driver\AbstractMySQLDriverTestCase;

class DriverTest extends AbstractMySQLDriverTestCase
{
    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
