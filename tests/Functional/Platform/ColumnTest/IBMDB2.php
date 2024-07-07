<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform\ColumnTest;

use Corma\DBAL\Platforms\DB2Platform;
use Corma\DBAL\Tests\Functional\Platform\AbstractColumnTestCase;

final class IBMDB2 extends AbstractColumnTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->requirePlatform(DB2Platform::class);
    }

    public function testVariableLengthStringNoLength(): void
    {
        self::markTestSkipped();
    }

    public function testVariableLengthBinaryNoLength(): void
    {
        self::markTestSkipped();
    }
}
