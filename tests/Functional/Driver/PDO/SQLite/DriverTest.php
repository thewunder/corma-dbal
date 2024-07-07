<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Driver\PDO\SQLite;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\PDO\SQLite\Driver;
use Corma\DBAL\Tests\Functional\Driver\AbstractDriverTestCase;
use Corma\DBAL\Tests\TestUtil;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('pdo_sqlite')]
class DriverTest extends AbstractDriverTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (TestUtil::isDriverOneOf('pdo_sqlite')) {
            return;
        }

        self::markTestSkipped('This test requires the pdo_sqlite driver.');
    }

    protected static function getDatabaseNameForConnectionWithoutDatabaseNameParameter(): ?string
    {
        return 'main';
    }

    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
