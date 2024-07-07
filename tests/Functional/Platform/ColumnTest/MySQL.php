<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform\ColumnTest;

use Corma\DBAL\Platforms\AbstractMySQLPlatform;
use Corma\DBAL\Tests\Functional\Platform\AbstractColumnTestCase;

final class MySQL extends AbstractColumnTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->requirePlatform(AbstractMySQLPlatform::class);
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
