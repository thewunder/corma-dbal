<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\PDO\SQLSrv;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\PDO\SQLSrv\Driver;
use Corma\DBAL\Tests\Driver\AbstractSQLServerDriverTestCase;

class DriverTest extends AbstractSQLServerDriverTestCase
{
    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
