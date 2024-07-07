<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema;

use Corma\DBAL\Exception;
use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\DB2Platform;

class Db2SchemaManagerTest extends SchemaManagerFunctionalTestCase
{
    protected function supportsPlatform(AbstractPlatform $platform): bool
    {
        return $platform instanceof DB2Platform;
    }

    public function testListDatabases(): void
    {
        $this->expectException(Exception::class);

        $this->schemaManager->listDatabases();
    }
}
