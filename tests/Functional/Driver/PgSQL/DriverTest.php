<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Driver\PgSQL;

use Corma\DBAL\Driver\PgSQL\Driver;
use Corma\DBAL\Tests\Functional\Driver\AbstractPostgreSQLDriverTestCase;
use Corma\DBAL\Tests\TestUtil;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('pgsql')]
class DriverTest extends AbstractPostgreSQLDriverTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (TestUtil::isDriverOneOf('pgsql')) {
            return;
        }

        self::markTestSkipped('This test requires the pgsql driver.');
    }

    protected function createDriver(): Driver
    {
        return new Driver();
    }
}
