<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform\ColumnTest;

use Corma\DBAL\Platforms\SQLitePlatform;
use Corma\DBAL\Tests\Functional\Platform\AbstractColumnTestCase;

final class SQLite extends AbstractColumnTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->requirePlatform(SQLitePlatform::class);
    }
}
