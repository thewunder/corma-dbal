<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\PDO\SQLite;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\PDO\SQLite\Driver;
use Corma\DBAL\Tests\Driver\AbstractSQLiteDriverTestCase;

class DriverTest extends AbstractSQLiteDriverTestCase
{
    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
