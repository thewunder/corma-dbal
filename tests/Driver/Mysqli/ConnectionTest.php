<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Driver\Mysqli;

use Corma\DBAL\Driver\Mysqli\Driver;
use Corma\DBAL\Driver\Mysqli\Exception\HostRequired;
use Corma\DBAL\Tests\FunctionalTestCase;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

#[RequiresPhpExtension('mysqli')]
class ConnectionTest extends FunctionalTestCase
{
    public function testHostnameIsRequiredForPersistentConnection(): void
    {
        $this->expectException(HostRequired::class);
        (new Driver())->connect(['persistent' => true]);
    }
}
