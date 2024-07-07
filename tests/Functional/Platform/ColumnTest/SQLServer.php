<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform\ColumnTest;

use Corma\DBAL\Platforms\SQLServerPlatform;
use Corma\DBAL\Tests\Functional\Platform\AbstractColumnTestCase;

final class SQLServer extends AbstractColumnTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->requirePlatform(SQLServerPlatform::class);
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
