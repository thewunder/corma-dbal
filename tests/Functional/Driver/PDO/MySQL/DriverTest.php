<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Driver\PDO\MySQL;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\PDO\MySQL\Driver;
use Corma\DBAL\Tests\Functional\Driver\AbstractDriverTestCase;
use Corma\DBAL\Tests\TestUtil;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('pdo_mysql')]
class DriverTest extends AbstractDriverTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (TestUtil::isDriverOneOf('pdo_mysql')) {
            return;
        }

        self::markTestSkipped('This test requires the pdo_mysql driver.');
    }

    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
