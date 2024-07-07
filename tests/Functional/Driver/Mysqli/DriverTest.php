<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Driver\Mysqli;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\Mysqli\Driver;
use Corma\DBAL\Tests\Functional\Driver\AbstractDriverTestCase;
use Corma\DBAL\Tests\TestUtil;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('mysqli')]
class DriverTest extends AbstractDriverTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (TestUtil::isDriverOneOf('mysqli')) {
            return;
        }

        self::markTestSkipped('This test requires the mysqli driver.');
    }

    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
