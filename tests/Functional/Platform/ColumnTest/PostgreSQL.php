<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Platform\ColumnTest;

use Corma\DBAL\Platforms\PostgreSQLPlatform;
use Corma\DBAL\Tests\Functional\Platform\AbstractColumnTestCase;

final class PostgreSQL extends AbstractColumnTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->requirePlatform(PostgreSQLPlatform::class);
    }
}
