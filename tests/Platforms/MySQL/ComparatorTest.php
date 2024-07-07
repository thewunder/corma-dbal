<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Platforms\MySQL;

use Corma\DBAL\Platforms\MySQL\CharsetMetadataProvider;
use Corma\DBAL\Platforms\MySQL\CollationMetadataProvider;
use Corma\DBAL\Platforms\MySQL\Comparator;
use Corma\DBAL\Platforms\MySQL\DefaultTableOptions;
use Corma\DBAL\Platforms\MySQLPlatform;
use Corma\DBAL\Tests\Schema\AbstractComparatorTestCase;

class ComparatorTest extends AbstractComparatorTestCase
{
    protected function setUp(): void
    {
        $this->comparator = new Comparator(
            new MySQLPlatform(),
            self::createStub(CharsetMetadataProvider::class),
            self::createStub(CollationMetadataProvider::class),
            new DefaultTableOptions('utf8mb4', 'utf8mb4_general_ci'),
        );
    }
}
