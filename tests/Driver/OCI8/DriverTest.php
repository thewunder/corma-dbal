<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\OCI8;

use Corma\DBAL\Driver as DriverInterface;
use Corma\DBAL\Driver\OCI8\Driver;
use Corma\DBAL\Driver\OCI8\Exception\InvalidConfiguration;
use Corma\DBAL\Tests\Driver\AbstractOracleDriverTestCase;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('oci8')]
class DriverTest extends AbstractOracleDriverTestCase
{
    public function testPersistentAndExclusiveAreMutuallyExclusive(): void
    {
        $this->expectException(InvalidConfiguration::class);

        (new Driver())->connect([
            'persistent' => true,
            'driverOptions' => ['exclusive' => true],
        ]);
    }

    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
