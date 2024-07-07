<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\PDO\OCI;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\PDO\OCI\Driver;
use Corma\DBAL\Tests\Driver\AbstractOracleDriverTestCase;

class DriverTest extends AbstractOracleDriverTestCase
{
    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
