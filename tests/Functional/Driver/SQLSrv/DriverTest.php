<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Driver\SQLSrv;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\SQLSrv\Driver;
use Corma\DBAL\Tests\Functional\Driver\AbstractDriverTestCase;
use Corma\DBAL\Tests\TestUtil;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('sqlsrv')]
class DriverTest extends AbstractDriverTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (TestUtil::isDriverOneOf('sqlsrv')) {
            return;
        }

        self::markTestSkipped('This test requires the sqlsrv driver.');
    }

    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }

    protected static function getDatabaseNameForConnectionWithoutDatabaseNameParameter(): ?string
    {
        return 'master';
    }
}
