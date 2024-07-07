<?php

declare(strict_types=1);

namespace Corma\DBAL\Tests\Functional\Schema\SQLite;

use Corma\DBAL\Platforms\AbstractPlatform;
use Corma\DBAL\Platforms\SQLitePlatform;
use Corma\DBAL\Schema\AbstractSchemaManager;
use Corma\DBAL\Schema\Comparator;
use Corma\DBAL\Schema\Table;
use Corma\DBAL\Tests\Functional\Schema\ComparatorTestUtils;
use Corma\DBAL\Tests\FunctionalTestCase;
use Corma\DBAL\Types\Types;

final class ComparatorTest extends FunctionalTestCase
{
    private AbstractPlatform $platform;

    private AbstractSchemaManager $schemaManager;

    private Comparator $comparator;

    protected function setUp(): void
    {
        $this->platform = $this->connection->getDatabasePlatform();

        if (! $this->platform instanceof SQLitePlatform) {
            self::markTestSkipped();
        }

        $this->schemaManager = $this->connection->createSchemaManager();
        $this->comparator    = $this->schemaManager->createComparator();
    }

    public function testChangeTableCollation(): void
    {
        $table  = new Table('comparator_test');
        $column = $table->addColumn('id', Types::STRING);
        $this->dropAndCreateTable($table);

        $column->setPlatformOption('collation', 'NOCASE');
        ComparatorTestUtils::assertDiffNotEmpty($this->connection, $this->comparator, $table);
    }
}
