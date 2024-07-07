<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Driver\IBMDB2;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\IBMDB2\Driver;
use Corma\DBAL\Tests\Functional\Driver\AbstractDriverTestCase;
use Corma\DBAL\Tests\TestUtil;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('ibm_db2')]
class DriverTest extends AbstractDriverTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (TestUtil::isDriverOneOf('ibm_db2')) {
            return;
        }

        self::markTestSkipped('This test requires the ibm_db2 driver.');
    }

    public function testConnectsWithoutDatabaseNameParameter(): void
    {
        self::markTestSkipped('IBM DB2 does not support connecting without database name.');
    }

    public function testReturnsDatabaseNameWithoutDatabaseNameParameter(): void
    {
        self::markTestSkipped('IBM DB2 does not support connecting without database name.');
    }

    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
