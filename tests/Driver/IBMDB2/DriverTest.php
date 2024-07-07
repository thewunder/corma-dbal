<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\IBMDB2;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\IBMDB2\Driver;
use Corma\DBAL\Tests\Driver\AbstractDB2DriverTestCase;

class DriverTest extends AbstractDB2DriverTestCase
{
    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
